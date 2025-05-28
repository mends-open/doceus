<?php

namespace App\Models;

use App\Enums\Language;
use App\Models\Traits\HasBlindIndex;
use App\Models\Traits\HasDisplayName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed $email
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasBlindIndex, HasDisplayName, HasFactory, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'pesel',
        'language',
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

    protected function language(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Language::from($value ?? config('app.locale')),
            set: fn ($value) => $value instanceof Language ? $value->value : $value,
        );
    }

    public function personnel(): HasMany
    {
        return $this->hasMany(Personnel::class);
    }

    public function units(): HasManyThrough
    {
        return $this->hasManyThrough(
            Unit::class,
            Personnel::class,
            'user_id',
            'id',
            'id',
            'unit_id'
        );
    }

    public function organizations()
    {
        return Organization::whereIn('id', $this->units()->pluck('organization_id'));
    }
}
