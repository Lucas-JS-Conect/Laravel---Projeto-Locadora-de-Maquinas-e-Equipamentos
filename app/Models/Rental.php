<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id',
        'client_id',
        'user_id',
        'payment_method',
        'start_date',
        'end_date',
        'hours_rented',
        'total_amount',
        'paid',
        'returned',
        'requested_date', 
        'comments', 
        'paid'

    ];

    protected $dates = ['requested_date'];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
