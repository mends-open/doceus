<?php

namespace App\Models;

use App\Enums\Language;
use App\Models\Person;
use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use App\Feature\Sqid\Interfaces\Sqidable;
use App\Feature\Sqid\Traits\HasSqids;
use App\Traits\HasDisplayName;
use App\Models\Organization;
use App\Models\OrganizationPractitioner;
use App\Models\Practitioner;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 *
 *
 * @property int $id
 * @property string $email
 * @property string|null $language
 * @property int|null $person_id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $name
 * @property-read string|null $sqid
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read OrganizationPractitioner|null $pivot
 * @property-read Person|null $person
 * @property-read Practitioner|null $practitioner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Organization> $organizations
 * @property-read int|null $organizations_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @mixin \Eloquent
 */
#[ObservedBy([RevisionableObserver::class])]
class User extends Authenticatable implements FilamentUser, HasTenants, MustVerifyEmail, Revisionable, Sqidable
{
    use HasDisplayName, HasFactory, HasSqids, LogsRevisions, Notifiable, SoftDeletes;

    protected $fillable = [
        'person_id',
        'email',
        'password',
        'language',
    ];

    protected array $revisionable = [
        'person_id',
        'email',
        'language',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
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
            ->whereIn('organization_practitioner.practitioner_id', $this->practitioner()->select('id'));
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
        static::creating(function (self $user) {
            if (! $user->person_id) {
                $user->person()->associate(Person::factory()->create());
            }
        });

        static::created(function (self $user) {
            if (! $user->practitioner()->exists()) {
                $user->practitioner()->create(['person_id' => $user->person_id]);
            }
        });
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
