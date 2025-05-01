<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Review extends Model
{
    public function likes(): HasMany
    {
        return $this->hasMany(ReviewLike::class);
    }

    public function isLikedByUser(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rate(): HasOne
    {
        return $this->hasOne(Rate::class);
    }
}
