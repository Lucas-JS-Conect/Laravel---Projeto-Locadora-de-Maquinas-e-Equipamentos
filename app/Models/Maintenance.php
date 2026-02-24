<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id', 
        'start_date', 
        'end_date',
        'description',
        'status',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];


    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
