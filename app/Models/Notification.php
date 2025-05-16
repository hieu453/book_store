<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Notification extends Model
{
    use Prunable;

    public function prunable()
    {
        return static::whereNotNull('read_at')->where('read_at', '<', now()->subWeek());
    }
}
