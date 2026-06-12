<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
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

    public function store(NewsRequest $request): RedirectResponse
    {
        $data = $request->validated();
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

    public function update(NewsRequest $request, News $news): RedirectResponse
    {
        $data = $request->validated();
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
        News::destroy($news->getKey());

        return redirect()->route('admin.news.index')->with('success', 'News post deleted successfully.');
    }

    public function updateStatus(Request $request, News $news): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:draft,published'],
        ]);

        $news->update([
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published'
                ? ($news->published_at ?: now())
                : $news->published_at,
        ]);

        return back()->with('success', 'News status updated successfully.');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (News::query()->where('slug', '=', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
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
