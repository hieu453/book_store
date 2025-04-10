<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewLike extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
