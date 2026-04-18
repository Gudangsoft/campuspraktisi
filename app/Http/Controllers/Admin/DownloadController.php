<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::latest()->paginate(20);
        return view('admin.downloads.index', compact('downloads'));
    }

    public function create()
    {
        return view('admin.downloads.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'source_type' => 'required|in:upload,gdrive',
        ];

        if ($request->source_type === 'upload') {
            $rules['file'] = 'required|file|max:10240'; // max 10MB
        } else {
            $rules['gdrive_url'] = 'required|url';
        }

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'is_active' => $request->has('is_active'),
            'source_type' => $request->source_type,
        ];

        if ($request->source_type === 'upload') {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('downloads', $fileName, 'public');

            $data['file_path'] = $filePath;
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_size'] = $file->getSize();
        } else {
            // Google Drive
            $data['gdrive_url'] = $request->gdrive_url;
            $data['file_path'] = ''; // Kosong untuk gdrive
            $data['file_type'] = 'gdrive';
            $data['file_size'] = 0; // Tidak diketahui untuk gdrive
        }

        Download::create($data);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File berhasil ditambahkan!');
    }

    public function edit(Download $download)
    {
        return view('admin.downloads.edit', compact('download'));
    }

    public function update(Request $request, Download $download)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'source_type' => 'required|in:upload,gdrive',
        ];

        if ($request->source_type === 'upload') {
            $rules['file'] = 'nullable|file|max:10240';
        } else {
            $rules['gdrive_url'] = 'required|url';
        }

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'is_active' => $request->has('is_active'),
            'source_type' => $request->source_type,
        ];

        // Jika ganti source type atau ada perubahan file
        if ($request->source_type === 'upload') {
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($download->source_type === 'upload' && Storage::disk('public')->exists($download->file_path)) {
                    Storage::disk('public')->delete($download->file_path);
                }

                // Upload file baru
                $file = $request->file('file');
                $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('downloads', $fileName, 'public');

                $data['file_path'] = $filePath;
                $data['file_type'] = $file->getClientOriginalExtension();
                $data['file_size'] = $file->getSize();
                $data['gdrive_url'] = null;
            }
        } else {
            // Hapus file lama jika ganti ke gdrive
            if ($download->source_type === 'upload' && Storage::disk('public')->exists($download->file_path)) {
                Storage::disk('public')->delete($download->file_path);
            }

            $data['gdrive_url'] = $request->gdrive_url;
            $data['file_path'] = '';
            $data['file_type'] = 'gdrive';
            $data['file_size'] = 0;
        }

        $download->update($data);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File berhasil diupdate!');
    }

    public function destroy(Download $download)
    {
        // Hapus file dari storage jika upload
        if ($download->source_type === 'upload' && Storage::disk('public')->exists($download->file_path)) {
            Storage::disk('public')->delete($download->file_path);
        }

        $download->delete();

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File berhasil dihapus!');
    }
}
