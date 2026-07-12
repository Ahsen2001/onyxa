<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Models\Client;
use App\Models\Media;
use App\Support\MediaLibrary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::query()
            ->ordered()
            ->paginate(12);

        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        $mediaItems = Media::images()->latest()->take(80)->get();

        return view('admin.clients.create', [
            'client' => null,
            'mediaItems' => $mediaItems,
        ]);
    }

    public function store(ClientRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['logo'] = MediaLibrary::imagePathFromRequest($request->input('logo_media_id')) ?? ($data['logo'] ?? null);
        unset($data['logo_media_id']);

        if ($request->hasFile('logo')) {
            $data['logo'] = MediaLibrary::store($request->file('logo'), $request->user()->id, $data['company_name'], 'clients')->file_path;
        }

        Client::create($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client logo created successfully.');
    }

    public function edit(Client $client): View
    {
        $mediaItems = Media::images()->latest()->take(80)->get();

        return view('admin.clients.edit', compact('client', 'mediaItems'));
    }

    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $data = $request->validated();
        $selectedLogo = MediaLibrary::imagePathFromRequest($request->input('logo_media_id'));
        unset($data['logo_media_id']);

        if ($selectedLogo) {
            MediaLibrary::deleteIfUntracked($client->logo);
            $data['logo'] = $selectedLogo;
        }

        if ($request->hasFile('logo')) {
            MediaLibrary::deleteIfUntracked($client->logo);
            $data['logo'] = MediaLibrary::store($request->file('logo'), $request->user()->id, $data['company_name'], 'clients')->file_path;
        }

        $client->update($data);

        return redirect()->route('admin.clients.edit', $client)->with('success', 'Client logo updated successfully.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        MediaLibrary::deleteIfUntracked($client->logo);
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client logo deleted successfully.');
    }

    public function updateStatus(Request $request, Client $client): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $client->update(['status' => $data['status']]);

        return back()->with('success', 'Client status updated successfully.');
    }
}
