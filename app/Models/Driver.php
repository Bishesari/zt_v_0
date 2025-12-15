<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'user_id',
        'is_active',
        'started_at',
    ];

    /**
     * رابطه یک به یک با User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * رابطه آسان به Profile از طریق User
     */
    public function profile()
    {
        return $this->user->profile();
    }

    /**
     * Scope برای راننده‌های فعال
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
