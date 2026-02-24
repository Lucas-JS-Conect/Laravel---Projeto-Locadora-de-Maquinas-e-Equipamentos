<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depreciation extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id',
        'initial_value',
        'residual_value',
        'useful_life_years',
        'depreciation_rate',
        'amount',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
