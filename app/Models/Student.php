<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Student extends Model
{
    protected $guarded = [];

    protected static function booted(): void {
        static::creating(fn ($s) => $s->play_token ??= (string) Str::uuid() );
    }

    public function submissions() {return $this->hasMany(Submission::class); }
    public function totalPoints(): int {
        return (int) $this->submissions()->sum('points_awarded');
    }
    use HasFactory;
}
