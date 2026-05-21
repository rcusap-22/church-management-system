<?php
namespace App\Http\Controllers;

use App\Models\ChurchBudget;
use App\Models\BudgetBreakdown;
use Illuminate\Http\Request;

class ChurchBudgetController extends Controller
{
    public function index()
    {
        $budgets = ChurchBudget::with('breakdown')->orderBy('year', 'desc')->get();
        return view('budget.index', compact('budgets'));
    }

    public function create()
    {
        return view('budget.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year'         => 'required|digits:4',
            'total_budget' => 'required|numeric|min:0',
            'notes'        => 'nullable|string',
        ]);

        $budget = ChurchBudget::create($request->only(['year', 'total_budget', 'notes']));

        if ($request->filled('categories')) {
            foreach ($request->categories as $i => $category) {
                if (!empty($category) && !empty($request->amounts[$i])) {
                    BudgetBreakdown::create([
                        'church_budget_id' => $budget->id,
                        'category'         => $category,
                        'amount'           => $request->amounts[$i],
                        'notes'            => $request->breakdown_notes[$i] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('budget.index')->with('success', 'Budget set successfully.');
    }

    public function edit(ChurchBudget $budget)
    {
        $budget->load('breakdown');
        return view('budget.edit', compact('budget'));
    }

    public function update(Request $request, ChurchBudget $budget)
    {
        $request->validate([
            'year'         => 'required|digits:4',
            'total_budget' => 'required|numeric|min:0',
            'notes'        => 'nullable|string',
        ]);

        $budget->update($request->only(['year', 'total_budget', 'notes']));

        $budget->breakdown()->delete();
        if ($request->filled('categories')) {
            foreach ($request->categories as $i => $category) {
                if (!empty($category) && !empty($request->amounts[$i])) {
                    BudgetBreakdown::create([
                        'church_budget_id' => $budget->id,
                        'category'         => $category,
                        'amount'           => $request->amounts[$i],
                        'notes'            => $request->breakdown_notes[$i] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('budget.index')->with('success', 'Budget updated successfully.');
    }

    public function destroy(ChurchBudget $budget)
    {
        $budget->delete();
        return redirect()->route('budget.index')->with('success', 'Budget deleted.');
    }
}