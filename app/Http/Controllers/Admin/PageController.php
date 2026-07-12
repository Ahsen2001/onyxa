<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Page;
use App\Support\HtmlSanitizer;
use App\Support\MediaLibrary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $this->ensureDefaultSections();
        $pages = Page::query()
            ->orderBy('page_key', 'asc')
            ->orderBy('section_key', 'asc')
            ->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function edit(Page $page): View
    {
        $mediaItems = Media::images()->latest()->take(80)->get();

        return view('admin.pages.edit', compact('page', 'mediaItems'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image_media_id' => ['nullable', 'exists:media,id'],
            'status' => ['required', 'in:draft,published'],
        ]);
        $data['content'] = HtmlSanitizer::clean($data['content'] ?? null);
        $selectedImage = MediaLibrary::imagePathFromRequest($request->input('image_media_id'));
        unset($data['image_media_id']);

        if ($selectedImage) {
            MediaLibrary::deleteIfUntracked($page->image);
            $data['image'] = $selectedImage;
        }

        if ($request->hasFile('image')) {
            MediaLibrary::deleteIfUntracked($page->image);
            $data['image'] = MediaLibrary::store($request->file('image'), $request->user()->id, $data['title'], 'pages')->file_path;
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page section updated successfully.');
    }

    private function ensureDefaultSections(): void
    {
        $sections = [
            ['page_key' => 'about', 'section_key' => 'about_us', 'title' => 'About Us'],
            ['page_key' => 'sustainability', 'section_key' => 'sustainability', 'title' => 'Sustainability'],
            ['page_key' => 'home', 'section_key' => 'introduction', 'title' => 'Home page introduction'],
            ['page_key' => 'about', 'section_key' => 'vision', 'title' => 'Vision'],
            ['page_key' => 'about', 'section_key' => 'mission', 'title' => 'Mission'],
            ['page_key' => 'footer', 'section_key' => 'description', 'title' => 'Footer description'],
        ];

        foreach ($sections as $section) {
            Page::firstOrCreate(
                ['page_key' => $section['page_key'], 'section_key' => $section['section_key']],
                [
                    'title' => $section['title'],
                    'slug' => Str::slug($section['page_key'].'-'.$section['section_key']),
                    'content' => null,
                    'status' => 'published',
                ]
            );
        }
    }
}
