<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChurchBudget extends Model
{
    protected $fillable = [
        'year', 'total_budget', 'notes'
    ];

    public function breakdown()
    {
        return $this->hasMany(BudgetBreakdown::class, 'church_budget_id');
    }
}