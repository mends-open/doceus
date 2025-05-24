<?php

namespace App\Models;

use App\Models\Traits\HasBlindIndex;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable, SoftDeletes, HasBlindIndex;

    protected $fillable = [
        'email',
        'name',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'email' => 'encrypted', // This handles encryption/decryption
    ];

    protected $blind = [
        'email', 'name'
    ];

    // Mutator: set email and blind index

}
