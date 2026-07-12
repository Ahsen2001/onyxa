<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed database before each test to have realistic data
        $this->seed();
    }

    public function test_search_page_loads_with_empty_query(): void
    {
        $response = $this->get(route('search'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.search');
        $response->assertSee('Ready to search');
        $response->assertSee('All Results (0)');
    }

    public function test_search_finds_products_news_and_events(): void
    {
        // Search for 'Coconut' which matches products, news, and events
        $response = $this->get(route('search', ['q' => 'Coconut']));

        $response->assertStatus(200);
        // Should find product: "Polished Coconut Shell Bowl" or "Coconut Shell Cup Set"
        $response->assertSee('Polished Coconut Shell Bowl');
        $response->assertSee('Coconut Shell Cup Set');
        // Should find news: "ONYXA Expands Coconut Shell Craft Collection"
        $response->assertSee('ONYXA Expands Coconut Shell Craft Collection');
        // Should find event: "Coconut Shell Craft Workshop"
        $response->assertSee('Coconut Shell Craft Workshop');

        // Verify count calculations are correct and visible
        $response->assertSee('All Results (8)'); // 4 products + 1 news + 3 events = 8 matching 'coconut'
        $response->assertSee('Products (4)');
        $response->assertSee('News (1)');
        $response->assertSee('Events (3)');
    }

    public function test_search_filters_by_type(): void
    {
        // Search 'Coconut' but filter only for products
        $response = $this->get(route('search', ['q' => 'Coconut', 'type' => 'products']));
        $response->assertStatus(200);
        $response->assertSee('Polished Coconut Shell Bowl');
        $response->assertDontSee('ONYXA Expands Coconut Shell Craft Collection'); // News should be hidden
        $response->assertDontSee('Coconut Shell Craft Workshop'); // Event should be hidden

        // Search 'Coconut' but filter only for news
        $response = $this->get(route('search', ['q' => 'Coconut', 'type' => 'news']));
        $response->assertStatus(200);
        $response->assertDontSee('Polished Coconut Shell Bowl');
        $response->assertSee('ONYXA Expands Coconut Shell Craft Collection');
        $response->assertDontSee('Coconut Shell Craft Workshop');

        // Search 'Coconut' but filter only for events
        $response = $this->get(route('search', ['q' => 'Coconut', 'type' => 'events']));
        $response->assertStatus(200);
        $response->assertDontSee('Polished Coconut Shell Bowl');
        $response->assertDontSee('ONYXA Expands Coconut Shell Craft Collection');
        $response->assertSee('Coconut Shell Craft Workshop');
    }
}
