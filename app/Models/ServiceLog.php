<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceLog extends Model
{
    protected $table = 'service-book';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle_id',
        'title',
        'note',
        'price',
        'hours',
        'service_date',
    ];

    protected $casts = [
        'service_date' => 'date',
    ];

    public function attachments(): ?HasMany
    {
        return null;
    }
}
