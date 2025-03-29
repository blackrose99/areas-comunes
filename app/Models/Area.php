<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'type',
        'status',
        'capacity',
        'opening_date',
        'closing_date'
    ];

    // Un área puede tener muchas reservaciones
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
