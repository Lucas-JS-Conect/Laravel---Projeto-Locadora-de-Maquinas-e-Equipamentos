<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'machine_id',
        'requested_date',
        'comments',
        'status',
    ];

    protected $dates = [
        'requested_date',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
}
