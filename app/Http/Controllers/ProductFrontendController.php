<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductFrontendController extends Controller
{
    public function index(Request $request): View
    {
        $categories = ProductCategory::active()->ordered()->get();

        $products = Product::query()
            ->with('category')
            ->published()
            ->when($request->filled('category'), function ($query) use ($request): void {
                $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', (string) $request->string('category')));
            })
            ->when($request->filled('search'), function ($query) use ($request): void {
                $query->where('name', 'like', '%'.(string) $request->string('search').'%');
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('frontend.products.index', [
            'categories' => $categories,
            'products' => $products,
            'whatsappNumber' => $this->whatsappNumber(),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->status === 'published', 404);

        $product->load(['category', 'images']);

        $relatedProducts = Product::query()
            ->with('category')
            ->published()
            ->whereKeyNot($product->id)
            ->where('product_category_id', $product->product_category_id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'whatsappNumber' => $this->whatsappNumber(),
        ]);
    }

    private function whatsappNumber(): string
    {
        return preg_replace('/\D+/', '', Setting::valueFor('company_whatsapp', Setting::valueFor('company_phone', '940000000000')));
    }
}
