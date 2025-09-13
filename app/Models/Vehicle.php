<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
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
        'spneu',
        'wpneu',
        'oni_id',
    ];

    protected $casts = [
        'stk' => 'date',
        'tachograph' => 'date',
        'oilChange' => 'date',
        'insurance' => 'date',
    ];

    public function serviceLog(): HasMany
    {
        return $this->hasMany(ServiceLog::class);
    }
}
