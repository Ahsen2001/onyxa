<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'a', 'blockquote', 'br', 'caption', 'code', 'em', 'figcaption', 'figure',
        'h2', 'h3', 'h4', 'hr', 'i', 'img', 'li', 'ol', 'p', 'pre', 's', 'span',
        'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'tfoot', 'th', 'thead',
        'tr', 'u', 'ul',
    ];

    private const BLOCKED_TAGS = [
        'base', 'button', 'embed', 'form', 'iframe', 'input', 'link', 'math',
        'meta', 'object', 'option', 'script', 'select', 'style', 'svg',
        'textarea',
    ];

    private const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'height', 'width'],
        'td' => ['colspan', 'rowspan'],
        'th' => ['colspan', 'rowspan', 'scope'],
    ];

    public static function clean(?string $html): ?string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return null;
        }

        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML(
            '<!doctype html><html><body>'.$html.'</body></html>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        $body = $document->getElementsByTagName('body')->item(0);

        if (! $body) {
            return null;
        }

        self::sanitizeNode($body);

        $clean = '';

        foreach ($body->childNodes as $childNode) {
            $clean .= $document->saveHTML($childNode);
        }

        return trim($clean) ?: null;
    }

    private static function sanitizeNode(DOMNode $node): void
    {
        for ($index = $node->childNodes->length - 1; $index >= 0; $index--) {
            $child = $node->childNodes->item($index);

            if (! $child) {
                continue;
            }

            if ($child->nodeType === XML_COMMENT_NODE) {
                $node->removeChild($child);

                continue;
            }

            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (in_array($tag, self::BLOCKED_TAGS, true)) {
                    $node->removeChild($child);

                    continue;
                }

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    self::unwrapElement($child);

                    continue;
                }

                self::sanitizeAttributes($child, $tag);
            }

            self::sanitizeNode($child);
        }
    }

    private static function sanitizeAttributes(DOMElement $element, string $tag): void
    {
        $allowed = self::ALLOWED_ATTRIBUTES[$tag] ?? [];

        for ($index = $element->attributes->length - 1; $index >= 0; $index--) {
            $attribute = $element->attributes->item($index);

            if (! $attribute) {
                continue;
            }

            $name = strtolower($attribute->name);
            $value = trim($attribute->value);

            if (! in_array($name, $allowed, true) || str_starts_with($name, 'on')) {
                $element->removeAttribute($attribute->name);

                continue;
            }

            if (in_array($name, ['href', 'src'], true) && ! self::isSafeUrl($value, $name === 'src')) {
                $element->removeAttribute($attribute->name);
            }
        }

        if ($tag === 'a') {
            $element->setAttribute('rel', 'noopener noreferrer');
        }
    }

    private static function isSafeUrl(string $url, bool $image): bool
    {
        if ($url === '' || preg_match('/[\x00-\x1F\x7F]/', $url)) {
            return false;
        }

        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return true;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        if ($image) {
            return in_array($scheme, ['http', 'https'], true);
        }

        return $scheme === '' || in_array($scheme, ['http', 'https', 'mailto', 'tel'], true);
    }

    private static function unwrapElement(DOMElement $element): void
    {
        $parent = $element->parentNode;

        if (! $parent) {
            return;
        }

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }
}
