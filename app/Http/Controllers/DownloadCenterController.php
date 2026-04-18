<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadCenterController extends Controller
{
    public function index(Request $request)
    {
        $query = Download::active();

        // Filter by category
        if ($request->filled('category') && $request->category != 'semua') {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $downloads = $query->latest()->paginate(12);
        
        // Get categories count
        $categoryCounts = Download::active()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        return view('frontend.downloads', compact('downloads', 'categoryCounts'));
    }

    public function download(Download $download)
    {
        if (!$download->is_active) {
            abort(404);
        }

        // Increment download count
        $download->incrementDownloads();

        // Redirect to Google Drive or download file
        if ($download->source_type === 'gdrive') {
            return redirect($download->gdrive_url);
        }

        return Storage::disk('public')->download($download->file_path, $download->title . '.' . $download->file_type);
    }
}
