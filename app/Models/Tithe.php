<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tithe extends Model
{
    protected $fillable = [
        'event_id', 'tithe_amount', 'offering_amount',
        'donation_amount', 'date', 'notes'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->tithe_amount + $this->offering_amount + $this->donation_amount;
    }
}