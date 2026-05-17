<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Summary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_name',
        'file_type',
        'topic',
        'slide_numbers',
        'summary',
        'raw_response',
    ];

    protected $casts = [
        'slide_numbers' => 'array',
        'raw_response' => 'array',
    ];

    /**
     * Get the user that owns the summary.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
