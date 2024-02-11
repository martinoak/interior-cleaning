<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vin extends Model
{
    protected $table = 'vin';
    protected $primaryKey = 'vin';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'vin',
        'name',
        'manufacturer',
        'model',
        'engine',
        'year',
        'note',
        'parsed',
    ];
}
