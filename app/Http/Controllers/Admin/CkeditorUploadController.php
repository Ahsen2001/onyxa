<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CkeditorUploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $path = $data['upload']->store('ckeditor', 'public');

        return response()->json([
            'uploaded' => 1,
            'fileName' => basename($path),
            'url' => asset('storage/'.$path),
        ]);
    }
}
