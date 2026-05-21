<?php
namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Tithe;
use App\Models\Event;
use App\Models\ChurchBudget;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers   = Member::count();
        $activeMembers  = Member::where('status', 'active')->count();
        $upcomingEvents = Event::where('date', '>=', today())
                               ->where('status', '!=', 'completed')
                               ->count();

        // Total ever collected
        $totalCollected = DB::table('tithes')->sum(DB::raw('tithe_amount + offering_amount + donation_amount')) ?? 0;
        $thisYearTotal  = DB::table('tithes')->whereYear('date', now()->year)->sum(DB::raw('tithe_amount + offering_amount + donation_amount')) ?? 0;

        // Money spent = completed event budgets
        $totalSpent = DB::table('event_expenses')->sum('amount_spent') ?? 0;

        // Money reserved = allocated to non-completed events
        $totalReserved = Event::where('status', '!=', 'completed')->sum('budget_allocated');

        // Available = collected - spent - reserved
        $availableBalance = $totalCollected - $totalSpent - $totalReserved;

        $recentTithes       = Tithe::with('event')->latest()->take(5)->get();
        $upcomingEventsList = Event::where('status', '!=', 'completed')
                                   ->where('date', '>=', today())
                                   ->orderBy('date')
                                   ->take(5)
                                   ->get();
        $currentBudget      = ChurchBudget::with('breakdown')->where('year', now()->year)->first();
        $recentlyCompleted  = Event::where('status', 'completed')->latest()->take(3)->get();

        return view('dashboard', compact(
            'totalMembers', 'activeMembers', 'upcomingEvents',
            'totalCollected', 'thisYearTotal',
            'totalSpent', 'totalReserved', 'availableBalance',
            'recentTithes', 'upcomingEventsList',
            'currentBudget', 'recentlyCompleted'
        ));
    }
}