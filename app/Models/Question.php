<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'token';
    }

    protected static function booted(): void
    {
        static::creating(function ($question) {
            $question->token ??= (string) Str::uuid();
        });
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function isOpen(): bool
    {
        return $this->type === 'open';
    }

    public function playUrl(): string
    {
        return route('play.show', $this);
    }
}
