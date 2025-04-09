<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceAttachment extends Model
{
    protected $table = 'service-book-attachments';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'title',
        'path',
    ];

    public function serviceLog(): BelongsTo
    {
        return $this->belongsTo(ServiceLog::class, 'service_id', 'id');
    }
}
