<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $gaurded = [];
    protected $casts = ['options'=> 'array', 'is-active' => 'boolean'];

    public function getRouteKeyName(): string{return 'token';}

    public static function booted(): void {
        static::creating(fn ($q) => $q->token ??= (string) Str::uuid());
    }

    public function submissions() {return $this->hasMany(Submission::class); }
    public function isOpen(): bool {return $this->type === 'open'; }
    public function playUrl (): string { return route('play.show', $this); }

    use HasFactory;
}
