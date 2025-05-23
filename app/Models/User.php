<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'email_blind_index',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_blind_index',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'name' => 'encrypted',
        'email' => 'encrypted', // This handles encryption/decryption
    ];

    // Mutator: set email and blind index
    protected static function booted()
    {
        static::saving(function ($user) {
            if ($user->isDirty('email')) {
                $normalized = \Illuminate\Support\Str::of($user->email)->lower()->trim();
                $hmacKey = base64_decode(\Illuminate\Support\Str::after(env('APP_BLIND_INDEX_KEY'), 'base64:'));
                $user->email_blind_index = hash_hmac('sha256', $normalized, $hmacKey);
            }
        });
    }

    // Blind index lookup
    public static function findByEmail(string $email): ?self
    {
        $normalized = Str::of($email)->lower()->trim();
        $hmacKey = base64_decode(Str::after(env('APP_BLIND_INDEX_KEY'), 'base64:')); // <<--- fixed here
        $blindIndex = hash_hmac('sha256', $normalized, $hmacKey);

        return self::where('email_blind_index', $blindIndex)->first();
    }
}
