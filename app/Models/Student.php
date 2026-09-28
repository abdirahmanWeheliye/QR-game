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

    public function getDisplayNameAttribute(): string
    {
        if ($this->name) {
            return $this->name;
        }

        $nr = (string) $this->student_number;

        return substr($nr, 0, 2).str_repeat('•', max(strlen($nr) - 4, 0)).substr($nr, -2);
    }

    use HasFactory;
}
