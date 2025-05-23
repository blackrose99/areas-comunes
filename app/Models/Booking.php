<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'resident_id',
        'area_id',
        'date',
        'time',
        'duration',
        'status',
        'comments'
    ];

    // Una reservación pertenece a un residente
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    // Una reservación pertenece a un área
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
