<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'feedback_hash', 'hash');
    }
}
