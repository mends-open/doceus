<?php

namespace App\Models;

use App\Feature\Identity\Enums\Language;
use App\Feature\Postgres\Casts\EncryptedBinary;
use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use App\Feature\Sqid\Interfaces\Sqidable;
use App\Feature\Sqid\Traits\HasSqids;
use App\Traits\HasDisplayName;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $email
 * @property string|null $language
 * @property int|null $person_id
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read string $name
 * @property-read string|null $sqid
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read OrganizationPractitioner|null $pivot
 * @property-read Person|null $person
 * @property-read Practitioner|null $practitioner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Organization> $organizations
 * @property-read int|null $organizations_count
 *
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User onlyTrashed()
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereDeletedAt($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereLanguage($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @method static Builder<static>|User withTrashed()
 * @method static Builder<static>|User withoutTrashed()
 *
 * @mixin \Eloquent
 */
#[ObservedBy([RevisionableObserver::class])]
class User extends Authenticatable implements FilamentUser, HasTenants, MustVerifyEmail, Revisionable, Sqidable
{
    use HasDisplayName, HasFactory, HasSqids, LogsRevisions, Notifiable, SoftDeletes;

    protected $fillable = [
        'person_id',
        'email',
        'phone_number',
        'password',
        'language',
    ];

    protected array $revisionable = [
        'person_id',
        'email',
        'phone_number',
        'language',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'language' => Language::class,
        'phone_number' => EncryptedBinary::class,
        'password' => 'hashed',
    ];

    protected function language(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Language::from($value ?? config('app.locale')),
            set: fn ($value) => $value instanceof Language ? $value->value : $value,
        );
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->organizations()->get();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->organizations()->whereKey($tenant)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * User is linked to organizations through their practitioner profile.
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(
            Organization::class,
            'organization_practitioner',
            'practitioner_id',
            'organization_id'
        )
            ->using(OrganizationPractitioner::class)
            ->whereIn(
                'organization_practitioner.practitioner_id',
                $this->practitioner()->select('id')
            );
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function practitioner(): HasOne
    {
        return $this->hasOne(Practitioner::class, 'person_id', 'person_id');
    }

    protected static function booted(): void
    {
        // Creation of related Person and Practitioner is handled
        // after the user's first login via an event listener.
    }

    /**
     * Create a new organization and attach the user's practitioner.
     */
    public function createOrganization(array $attributes): Organization
    {
        $organization = Organization::create($attributes);
        $this->practitioner->organizations()->attach($organization);

        return $organization;
    }
}
