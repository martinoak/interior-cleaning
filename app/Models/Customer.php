<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'message',
        'variant',
        'term',
        'feedbackSent',
        'archived',
        'feedback_hash',
        'invoice_id',
    ];

    // Define relationships if needed
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function feedback(): BelongsTo
    {
        return $this->belongsTo(Feedback::class, 'feedback_hash', 'hash');
    }
}
