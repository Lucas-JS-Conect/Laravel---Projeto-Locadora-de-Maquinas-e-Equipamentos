<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'cpf_cnpj',
        'phone',
        'birth_date',
        'gender',
        'address',
        'occupation',
        'user_id',
        'approved',
    ];

    protected $dates = [
        'birth_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

}