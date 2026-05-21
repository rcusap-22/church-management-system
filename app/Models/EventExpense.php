<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventExpense extends Model
{
    protected $table = 'event_expenses';

    protected $fillable = [
        'event_id', 'amount_spent', 'completed_at'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}