<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetBreakdown extends Model
{
    protected $table = 'budget_breakdown';

    protected $fillable = [
        'church_budget_id', 'category', 'amount', 'notes'
    ];

    public function churchBudget()
    {
        return $this->belongsTo(ChurchBudget::class, 'church_budget_id');
    }
}