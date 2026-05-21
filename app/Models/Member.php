<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email',
        'phone', 'address', 'birthdate', 'status'
    ];

    public function tithes()
    {
        return $this->hasMany(Tithe::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}