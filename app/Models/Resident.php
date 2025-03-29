<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'document',
        'document_type',
        'email',
        'phone',
        'address',
        'birth_date',
        'status'
    ];

    // Un residente puede tener muchas reservaciones
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
