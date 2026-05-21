<?php
namespace App\Http\Controllers;

use App\Models\Tithe;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TitheController extends Controller
{
   public function index(Request $request)
{
    $query = Tithe::with('event');

    if ($request->filled('event_id')) {
        $query->where('event_id', $request->event_id);
    }
    if ($request->filled('year')) {
        $query->whereYear('date', $request->year);
    }
    if ($request->filled('date_from')) {
        $query->whereDate('date', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('date', '<=', $request->date_to);
    }

    $tithes = $query->latest()->paginate(10)->withQueryString();
    $events = Event::orderBy('date', 'desc')->get();

    $totalCollected   = DB::table('tithes')->sum(DB::raw('tithe_amount + offering_amount + donation_amount')) ?? 0;
    $thisYearTotal    = DB::table('tithes')->whereYear('date', now()->year)->sum(DB::raw('tithe_amount + offering_amount + donation_amount')) ?? 0;
    $totalSpent       = DB::table('event_expenses')->sum('amount_spent') ?? 0;
    $totalReserved    = Event::where('status', '!=', 'completed')->sum('budget_allocated');
    $availableBalance = $totalCollected - $totalSpent - $totalReserved;

    return view('tithes.index', compact(
        'tithes', 'events',
        'thisYearTotal', 'totalCollected',
        'totalSpent', 'totalReserved', 'availableBalance'
    ));

    }

    public function create()
    {
        $events = Event::orderBy('date', 'desc')->get();
        return view('tithes.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id'        => 'nullable|exists:events,id',
            'tithe_amount'    => 'required|numeric|min:0',
            'offering_amount' => 'required|numeric|min:0',
            'donation_amount' => 'required|numeric|min:0',
            'date'            => 'required|date',
            'notes'           => 'nullable|string',
        ]);

        Tithe::create($request->all());
        return redirect()->route('tithes.index')->with('success', 'Collection recorded successfully.');
    }

    public function edit(Tithe $tithe)
    {
        $events = Event::orderBy('date', 'desc')->get();
        return view('tithes.edit', compact('tithe', 'events'));
    }

    public function update(Request $request, Tithe $tithe)
    {
        $request->validate([
            'event_id'        => 'nullable|exists:events,id',
            'tithe_amount'    => 'required|numeric|min:0',
            'offering_amount' => 'required|numeric|min:0',
            'donation_amount' => 'required|numeric|min:0',
            'date'            => 'required|date',
            'notes'           => 'nullable|string',
        ]);

        $tithe->update($request->all());
        return redirect()->route('tithes.index')->with('success', 'Record updated successfully.');
    }

    public function destroy(Tithe $tithe)
    {
        $tithe->delete();
        return redirect()->route('tithes.index')->with('success', 'Record deleted successfully.');
    }
}