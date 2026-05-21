<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventBudget;
use App\Models\Tithe;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::withCount('attendance');

        if ($request->filled('filter')) {
            if ($request->filter === 'upcoming') {
                $query->where('date', '>=', today());
            } elseif ($request->filter === 'past') {
                $query->where('date', '<', today());
            }
        }
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $events = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'date'             => 'required|date',
            'time'             => 'nullable',
            'location'         => 'nullable|string|max:255',
            'budget_allocated' => 'nullable|numeric|min:0',
        ]);

        $event = Event::create($request->only([
            'title', 'description', 'date', 'time', 'location', 'budget_allocated'
        ]));

        if ($request->filled('categories')) {
            foreach ($request->categories as $i => $category) {
                if (!empty($category) && !empty($request->amounts[$i])) {
                    EventBudget::create([
                        'event_id' => $event->id,
                        'category' => $category,
                        'amount'   => $request->amounts[$i],
                        'notes'    => $request->breakdown_notes[$i] ?? null,
                    ]);
                }
            }
        }

        // Warn if over budget after saving
        $totalCollected   = Tithe::selectRaw('SUM(tithe_amount + offering_amount + donation_amount) as total')->value('total') ?? 0;
        $totalAllocated   = Event::sum('budget_allocated');
        $remainingBalance = $totalCollected - $totalAllocated;

        if ($remainingBalance < 0) {
            return redirect()->route('events.index')
                ->with('warning', 'Event created, but total event budgets now exceed collected funds by ₱' . number_format(abs($remainingBalance), 2) . '. Consider adjusting budgets.');
        }

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $event->load('attendance.member', 'budgetBreakdown', 'tithes');
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $event->load('budgetBreakdown');
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'date'             => 'required|date',
            'time'             => 'nullable',
            'location'         => 'nullable|string|max:255',
            'budget_allocated' => 'nullable|numeric|min:0',
        ]);

        $event->update($request->only([
            'title', 'description', 'date', 'time', 'location', 'budget_allocated'
        ]));

        $event->budgetBreakdown()->delete();
        if ($request->filled('categories')) {
            foreach ($request->categories as $i => $category) {
                if (!empty($category) && !empty($request->amounts[$i])) {
                    EventBudget::create([
                        'event_id' => $event->id,
                        'category' => $category,
                        'amount'   => $request->amounts[$i],
                        'notes'    => $request->breakdown_notes[$i] ?? null,
                    ]);
                }
            }
        }

        // Warn if over budget after saving
        $totalCollected   = Tithe::selectRaw('SUM(tithe_amount + offering_amount + donation_amount) as total')->value('total') ?? 0;
        $totalAllocated   = Event::sum('budget_allocated');
        $remainingBalance = $totalCollected - $totalAllocated;

        if ($remainingBalance < 0) {
            return redirect()->route('events.index')
                ->with('warning', 'Event updated, but total event budgets now exceed collected funds by ₱' . number_format(abs($remainingBalance), 2) . '. Consider adjusting budgets.');
        }

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function complete(Request $request, Event $event)
{
    if ($event->isCompleted()) {
        return back()->with('error', 'Event is already marked as completed.');
    }

    // Mark event as completed
    $event->update(['status' => 'completed']);

    // Record the expense
    \App\Models\EventExpense::create([
        'event_id'     => $event->id,
        'amount_spent' => $event->budget_allocated,
        'completed_at' => now(),
    ]);

    return back()->with('success', 'Event marked as completed. ₱' . number_format($event->budget_allocated, 2) . ' has been recorded as spent.');
}

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}