<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBudget extends Model
{
    protected $table = 'event_budgets';

    protected $fillable = [
        'event_id', 'category', 'amount', 'notes'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}