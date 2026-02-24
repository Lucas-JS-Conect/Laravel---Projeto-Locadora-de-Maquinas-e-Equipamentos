<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['date'];

    protected $fillable = [
        'name',
        'type',
        'model',
        'brand',
        'manufacture_year',
        'acquisition_year',
        'serial_number',
        'image',
        'value',
        'status',
        'hourly_rate'
    ];

    protected $casts = [
        'manufacture_year' => 'integer',
        'acquisition_year' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function depreciations()
    {
        return $this->hasMany(Depreciation::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function scheduledMachines()
    {
        return $this->belongsToMany(
            Machine::class,
            'user_machine',
            'user_id',
            'machine_id'
        )
            ->withTimestamps();
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function isAvailableForRental()
    {
        return $this->status === 'Disponível' && !$this->isUnderMaintenance();
    }

    public function isUnderMaintenance()
    {
        return $this->status === 'Em Manutenção' || $this->maintenances()->whereNull('end_date')->exists();
    }

    public function startMaintenance()
    {
        $this->status = 'Em Manutenção';
        $this->save();
    }

    public function endMaintenance()
    {
        $this->status = 'Disponível';
        $this->save();
    }

}
