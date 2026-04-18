<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProdiUnggulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdiUnggulanController extends Controller
{
    public function index()
    {
        $prodis = ProdiUnggulan::latest()->paginate(10);
        return view('admin.prodi-unggulan.index', compact('prodis'));
    }

    public function create()
    {
        return view('admin.prodi-unggulan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('prodi_unggulan', 'public');
        }

        ProdiUnggulan::create($validated);

        return redirect()->route('admin.prodi-unggulan.index')
            ->with('success', 'Program Studi Unggulan berhasil ditambahkan.');
    }

    public function edit(ProdiUnggulan $prodiUnggulan)
    {
        return view('admin.prodi-unggulan.edit', compact('prodiUnggulan'));
    }

    public function update(Request $request, ProdiUnggulan $prodiUnggulan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('gambar')) {
            if ($prodiUnggulan->gambar) {
                Storage::disk('public')->delete($prodiUnggulan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('prodi_unggulan', 'public');
        }

        $prodiUnggulan->update($validated);

        return redirect()->route('admin.prodi-unggulan.index')
            ->with('success', 'Program Studi Unggulan berhasil diupdate.');
    }

    public function destroy(ProdiUnggulan $prodiUnggulan)
    {
        if ($prodiUnggulan->gambar) {
            Storage::disk('public')->delete($prodiUnggulan->gambar);
        }

        $prodiUnggulan->delete();

        return redirect()->route('admin.prodi-unggulan.index')
            ->with('success', 'Program Studi Unggulan berhasil dihapus.');
    }
}
