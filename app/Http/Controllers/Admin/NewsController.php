<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $news = News::with('user')->latest()->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    public function create(): View
    {
        return view('admin.news.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['user_id'] = $request->user()->id;
        $data['published_at'] = $data['status'] === 'published'
            ? ($data['published_at'] ?? now())
            : $data['published_at'];

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'News post created successfully.');
    }

    public function show(News $news): View
    {
        $news->load('user');

        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news): View
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['title'], $news->id);
        $data['published_at'] = $data['status'] === 'published'
            ? ($data['published_at'] ?? now())
            : $data['published_at'];

        if ($request->hasFile('featured_image')) {
            $this->deleteImage($news->featured_image);
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.edit', $news)->with('success', 'News post updated successfully.');
    }

    public function destroy(News $news): RedirectResponse
    {
        $this->deleteImage($news->featured_image);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News post deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (News::where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
