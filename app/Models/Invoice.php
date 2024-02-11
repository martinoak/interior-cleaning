<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'type',
        'date',
        'name',
        'price',
        'worker',
    ];

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }
}
