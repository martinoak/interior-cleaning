<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'manufacturer',
        'model',
        'productionYear',
        'vin',
        'spz',
        'driver',
        'color',
        'stk',
        'tachograph',
        'oilChange',
        'insurance',
        'vtp',
    ];

    protected $casts = [
        'stk' => 'datetime',
        'tachograph' => 'datetime',
        'oilChange' => 'datetime',
        'insurance' => 'datetime',
    ];
}
