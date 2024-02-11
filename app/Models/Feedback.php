<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $primaryKey = 'hash';
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'hash',
        'name',
        'message',
        'rating',
        'fromGoogle',
    ];

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'feedback_hash', 'hash');
    }
}
