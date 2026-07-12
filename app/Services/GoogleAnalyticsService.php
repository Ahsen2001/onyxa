<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GoogleAnalyticsService
{
    public function dashboard(int $days = 30): array
    {
        if (! $this->isConfigured()) {
            return $this->emptyDashboard(false);
        }

        try {
            return [
                'configured' => true,
                'periodDays' => $days,
                'summary' => $this->summary($days),
                'visitorTrend' => $this->visitorTrend($days),
                'popularPages' => $this->popularPages($days),
                'mostViewedProducts' => $this->mostViewedProducts($days),
                'trafficSources' => $this->trafficSources($days),
                'error' => null,
            ];
        } catch (\Throwable $exception) {
            report($exception);

            $dashboard = $this->emptyDashboard(true);
            $dashboard['error'] = 'Google Analytics data could not be loaded. Check the GA4 property ID and service account credentials.';

            return $dashboard;
        }
    }

    private function summary(int $days): array
    {
        $rows = $this->runReport([
            'dateRanges' => [$this->dateRange($days)],
            'metrics' => [
                ['name' => 'activeUsers'],
                ['name' => 'sessions'],
                ['name' => 'screenPageViews'],
                ['name' => 'engagementRate'],
            ],
        ])['rows'][0]['metricValues'] ?? [];

        return [
            'visitors' => (int) ($rows[0]['value'] ?? 0),
            'sessions' => (int) ($rows[1]['value'] ?? 0),
            'pageViews' => (int) ($rows[2]['value'] ?? 0),
            'engagementRate' => round(((float) ($rows[3]['value'] ?? 0)) * 100, 1),
        ];
    }

    private function visitorTrend(int $days): array
    {
        $report = $this->runReport([
            'dateRanges' => [$this->dateRange($days)],
            'dimensions' => [['name' => 'date']],
            'metrics' => [
                ['name' => 'activeUsers'],
                ['name' => 'sessions'],
            ],
            'orderBys' => [['dimension' => ['dimensionName' => 'date']]],
            'limit' => 60,
        ]);

        return collect($report['rows'] ?? [])
            ->map(fn (array $row): array => [
                'label' => Carbon::createFromFormat('Ymd', $row['dimensionValues'][0]['value'])->format('M d'),
                'visitors' => (int) ($row['metricValues'][0]['value'] ?? 0),
                'sessions' => (int) ($row['metricValues'][1]['value'] ?? 0),
            ])
            ->all();
    }

    private function popularPages(int $days): array
    {
        $report = $this->runReport([
            'dateRanges' => [$this->dateRange($days)],
            'dimensions' => [
                ['name' => 'pageTitle'],
                ['name' => 'pagePath'],
            ],
            'metrics' => [
                ['name' => 'screenPageViews'],
                ['name' => 'activeUsers'],
            ],
            'orderBys' => [['metric' => ['metricName' => 'screenPageViews'], 'desc' => true]],
            'limit' => 8,
        ]);

        return $this->pageRows($report);
    }

    private function mostViewedProducts(int $days): array
    {
        $report = $this->runReport([
            'dateRanges' => [$this->dateRange($days)],
            'dimensions' => [
                ['name' => 'pageTitle'],
                ['name' => 'pagePath'],
            ],
            'metrics' => [
                ['name' => 'screenPageViews'],
                ['name' => 'activeUsers'],
            ],
            'dimensionFilter' => [
                'filter' => [
                    'fieldName' => 'pagePath',
                    'stringFilter' => [
                        'matchType' => 'CONTAINS',
                        'value' => '/products/',
                    ],
                ],
            ],
            'orderBys' => [['metric' => ['metricName' => 'screenPageViews'], 'desc' => true]],
            'limit' => 6,
        ]);

        return $this->pageRows($report);
    }

    private function trafficSources(int $days): array
    {
        $report = $this->runReport([
            'dateRanges' => [$this->dateRange($days)],
            'dimensions' => [['name' => 'sessionDefaultChannelGroup']],
            'metrics' => [
                ['name' => 'sessions'],
                ['name' => 'activeUsers'],
            ],
            'orderBys' => [['metric' => ['metricName' => 'sessions'], 'desc' => true]],
            'limit' => 8,
        ]);

        return collect($report['rows'] ?? [])
            ->map(fn (array $row): array => [
                'source' => $row['dimensionValues'][0]['value'] ?: 'Unknown',
                'sessions' => (int) ($row['metricValues'][0]['value'] ?? 0),
                'visitors' => (int) ($row['metricValues'][1]['value'] ?? 0),
            ])
            ->all();
    }

    private function pageRows(array $report): array
    {
        return collect($report['rows'] ?? [])
            ->map(fn (array $row): array => [
                'title' => $row['dimensionValues'][0]['value'] ?: 'Untitled page',
                'path' => $row['dimensionValues'][1]['value'] ?: '/',
                'views' => (int) ($row['metricValues'][0]['value'] ?? 0),
                'visitors' => (int) ($row['metricValues'][1]['value'] ?? 0),
            ])
            ->all();
    }

    private function runReport(array $payload): array
    {
        $propertyId = config('services.ga4.property_id');

        return Http::withToken($this->accessToken())
            ->acceptJson()
            ->post("https://analyticsdata.googleapis.com/v1beta/properties/{$propertyId}:runReport", $payload)
            ->throw()
            ->json();
    }

    private function accessToken(): string
    {
        return Cache::remember('ga4_access_token', 3300, function (): string {
            $credentials = $this->credentials();
            $now = time();
            $assertion = $this->signJwt([
                'iss' => $credentials['client_email'],
                'scope' => 'https://www.googleapis.com/auth/analytics.readonly',
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ], $credentials['private_key']);

            $response = Http::asForm()
                ->post('https://oauth2.googleapis.com/token', [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion' => $assertion,
                ])
                ->throw()
                ->json();

            return $response['access_token'] ?? throw new \RuntimeException('GA4 access token missing.');
        });
    }

    private function signJwt(array $claims, string $privateKey): string
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $segments = [
            $this->base64Url(json_encode($header, JSON_THROW_ON_ERROR)),
            $this->base64Url(json_encode($claims, JSON_THROW_ON_ERROR)),
        ];

        openssl_sign(implode('.', $segments), $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $segments[] = $this->base64Url($signature);

        return implode('.', $segments);
    }

    private function base64Url(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private function credentials(): array
    {
        $path = config('services.ga4.credentials_path');

        if ($path && is_file($path)) {
            return json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        }

        return [
            'client_email' => config('services.ga4.client_email'),
            'private_key' => str_replace('\\n', "\n", (string) config('services.ga4.private_key')),
        ];
    }

    private function isConfigured(): bool
    {
        $credentials = $this->credentials();

        return filled(config('services.ga4.property_id'))
            && filled($credentials['client_email'] ?? null)
            && filled($credentials['private_key'] ?? null);
    }

    private function dateRange(int $days): array
    {
        return [
            'startDate' => now()->subDays($days - 1)->toDateString(),
            'endDate' => 'today',
        ];
    }

    private function emptyDashboard(bool $configured): array
    {
        return [
            'configured' => $configured,
            'periodDays' => 30,
            'summary' => [
                'visitors' => 0,
                'sessions' => 0,
                'pageViews' => 0,
                'engagementRate' => 0,
            ],
            'visitorTrend' => [],
            'popularPages' => [],
            'mostViewedProducts' => [],
            'trafficSources' => [],
            'error' => null,
        ];
    }
}
