<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'date', 'time',
        'location', 'budget_allocated', 'status'
    ];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function tithes()
    {
        return $this->hasMany(Tithe::class);
    }

    public function budgetBreakdown()
    {
        return $this->hasMany(EventBudget::class);
    }

    public function expense()
    {
        return $this->hasOne(EventExpense::class);
    }

    public function getTotalCollectedAttribute(): float
    {
        return $this->tithes->sum(function($t) {
            return $t->tithe_amount + $t->offering_amount + $t->donation_amount;
        });
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}