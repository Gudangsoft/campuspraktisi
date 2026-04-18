<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use Illuminate\Http\Request;

class AcademicCalendarController extends Controller
{
    public function index(Request $request)
    {
        $query = AcademicCalendar::query();

        // Filter by academic year
        if ($request->has('academic_year') && $request->academic_year != '') {
            $query->academicYear($request->academic_year);
        }

        // Filter by semester
        if ($request->has('semester') && $request->semester != '') {
            $query->semester($request->semester);
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->category($request->category);
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status == 'upcoming') {
                $query->upcoming();
            } elseif ($request->status == 'current') {
                $query->current();
            }
        }

        $events = $query->orderBy('order')->orderBy('start_date', 'desc')->paginate(20);

        // Get unique academic years for filter
        $academicYears = AcademicCalendar::select('academic_year')
            ->distinct()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year');

        return view('admin.academic-calendar.index', compact('events', 'academicYears'));
    }

    public function create()
    {
        return view('admin.academic-calendar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string|max:20',
            'semester' => 'required|string|max:20',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category' => 'required|in:academic,exam,holiday,registration',
            'color' => 'required|string|max:20',
            'order' => 'nullable|integer'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        AcademicCalendar::create($validated);

        return redirect()->route('admin.academic-calendar.index')
            ->with('success', 'Event kalender berhasil ditambahkan');
    }

    public function edit(AcademicCalendar $academicCalendar)
    {
        return view('admin.academic-calendar.edit', compact('academicCalendar'));
    }

    public function update(Request $request, AcademicCalendar $academicCalendar)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string|max:20',
            'semester' => 'required|string|max:20',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category' => 'required|in:academic,exam,holiday,registration',
            'color' => 'required|string|max:20',
            'order' => 'nullable|integer'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $academicCalendar->update($validated);

        return redirect()->route('admin.academic-calendar.index')
            ->with('success', 'Event kalender berhasil diperbarui');
    }

    public function destroy(AcademicCalendar $academicCalendar)
    {
        $academicCalendar->delete();

        return redirect()->route('admin.academic-calendar.index')
            ->with('success', 'Event kalender berhasil dihapus');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer'
        ]);

        foreach ($request->orders as $id => $order) {
            AcademicCalendar::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['success' => true]);
    }
}
