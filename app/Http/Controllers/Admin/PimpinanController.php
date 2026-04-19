<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pimpinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PimpinanController extends Controller
{
    public function index()
    {
        $pimpinan = Pimpinan::orderBy('kategori')->orderBy('order')->get();
        return view('admin.pimpinan.index', compact('pimpinan'));
    }

    public function create()
    {
        return view('admin.pimpinan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'kategori' => 'required|in:pimpinan,yayasan',
            'foto' => 'nullable|image|max:2048',
            'order' => 'integer'
        ]);

        $data = $request->only(['nama', 'jabatan', 'kategori', 'order', 'email', 'linkedin']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pimpinan', 'public');
        }

        Pimpinan::create($data);

        return redirect()->route('admin.pimpinan.index')->with('success', 'Data pimpinan berhasil ditambahkan');
    }

    public function edit(Pimpinan $pimpinan)
    {
        return view('admin.pimpinan.edit', compact('pimpinan'));
    }

    public function update(Request $request, Pimpinan $pimpinan)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'kategori' => 'required|in:pimpinan,yayasan',
            'foto' => 'nullable|image|max:2048',
            'order' => 'integer'
        ]);

        $data = $request->only(['nama', 'jabatan', 'kategori', 'order', 'email', 'linkedin']);

        if ($request->hasFile('foto')) {
            if ($pimpinan->foto) {
                Storage::disk('public')->delete($pimpinan->foto);
            }
            $data['foto'] = $request->file('foto')->store('pimpinan', 'public');
        }

        $pimpinan->update($data);

        return redirect()->route('admin.pimpinan.index')->with('success', 'Data pimpinan berhasil diperbarui');
    }

    public function destroy(Pimpinan $pimpinan)
    {
        if ($pimpinan->foto) {
            Storage::disk('public')->delete($pimpinan->foto);
        }
        $pimpinan->delete();

        return redirect()->route('admin.pimpinan.index')->with('success', 'Data pimpinan berhasil dihapus');
    }
}
