<?php

namespace App\Models;

use App\Enums\Language;
use App\Models\Traits\HasBlindIndex;
use App\Models\Traits\HasDisplayName;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * @property mixed $email
 */
class User extends Authenticatable implements FilamentUser, HasTenants, MustVerifyEmail
{
    use HasBlindIndex, HasDisplayName, HasFactory, HasUuids, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'pesel',
        'language',
        'default_role_id',
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

    protected $blindIndexes = [
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

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->using(OrganizationUser::class);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->organizations()->get()->unique();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->organizations()->whereKey($tenant)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
