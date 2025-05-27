<?php

namespace App\Models;

use App\Models\Traits\HasDisplayName;
use App\Models\Traits\HasBlindIndex;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Personnel;
use App\Models\Unit;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed $email
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasDisplayName, HasBlindIndex, HasFactory, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'pesel',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'email' => 'encrypted', // This handles encryption/decryption
        'first_name' => 'encrypted',
        'last_name' => 'encrypted',
        'pesel' => 'encrypted',
    ];

    protected $blind = [
        'email' => ['unique' => true],
        'first_name' => ['nullable' => true],
        'last_name' => ['nullable' => true],
        'pesel' => ['unique' => true, 'nullable' => true],
    ];

    /**
     * Personnel assignments for the user.
     */
    public function personnel(): HasMany
    {
        return $this->hasMany(Personnel::class);
    }

    /**
     * Units the user belongs to via personnel records.
     */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'personnel');
    }
}
