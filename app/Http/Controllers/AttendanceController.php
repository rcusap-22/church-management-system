<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Member;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['member', 'event']);

        // Filters
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('member_id')) {
            $query->where('member_id', $request->member_id);
        }

        $attendance = $query->latest()->paginate(10)->withQueryString();
        $events     = Event::orderBy('date', 'desc')->get();
        $members    = Member::where('status', 'active')->orderBy('first_name')->get();

        return view('attendance.index', compact('attendance', 'events', 'members'));
    }

    public function create()
    {
        $members = Member::where('status', 'active')->orderBy('first_name')->get();
        $events  = Event::orderBy('date', 'desc')->get();
        return view('attendance.create', compact('members', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'event_id'  => 'required|exists:events,id',
            'status'    => 'required|in:present,absent,late',
        ]);

        Attendance::create($request->all());
        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    public function edit(Attendance $attendance)
    {
        $members = Member::where('status', 'active')->orderBy('first_name')->get();
        $events  = Event::orderBy('date', 'desc')->get();
        return view('attendance.edit', compact('attendance', 'members', 'events'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'event_id'  => 'required|exists:events,id',
            'status'    => 'required|in:present,absent,late',
        ]);

        $attendance->update($request->all());
        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully.');
    }
}