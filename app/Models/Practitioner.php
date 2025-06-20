<?php

namespace App\Models;

use App\Feature\Identity\Enums\Language;
use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use App\Feature\Sqid\Interfaces\Sqidable;
use App\Feature\Sqid\Traits\HasSqids;
use App\Traits\HasDisplayName;
use Database\Factories\PractitionerFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use App\Models\Person;
use App\Models\Organization;
use App\Models\OrganizationPractitioner;
use App\Models\Patient;
use App\Models\PatientPractitioner;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $person_id
 * @property string $email
 * @property string|null $language
 * @property string|null $phone_number
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $name
 * @property-read string|null $sqid
 * @property-read Person $person
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Organization> $organizations
 * @property-read int|null $organizations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Patient> $patients
 * @property-read int|null $patients_count
 *
 * @method static PractitionerFactory factory($count = null, $state = [])
 * @method static Builder<static>|Practitioner newModelQuery()
 * @method static Builder<static>|Practitioner newQuery()
 * @method static Builder<static>|Practitioner onlyTrashed()
 * @method static Builder<static>|Practitioner query()
 * @method static Builder<static>|Practitioner whereCreatedAt($value)
 * @method static Builder<static>|Practitioner whereDeletedAt($value)
 * @method static Builder<static>|Practitioner whereEmail($value)
 * @method static Builder<static>|Practitioner whereEmailVerifiedAt($value)
 * @method static Builder<static>|Practitioner whereId($value)
 * @method static Builder<static>|Practitioner whereLanguage($value)
 * @method static Builder<static>|Practitioner wherePassword($value)
 * @method static Builder<static>|Practitioner whereRememberToken($value)
 * @method static Builder<static>|Practitioner whereUpdatedAt($value)
 * @method static Builder<static>|Practitioner withTrashed()
 * @method static Builder<static>|Practitioner withoutTrashed()
 */
#[ObservedBy([RevisionableObserver::class])]
class Practitioner extends Authenticatable implements FilamentUser, HasTenants, MustVerifyEmail, Revisionable, Sqidable
{
    use HasDisplayName, HasFactory, HasSqids, LogsRevisions, Notifiable, SoftDeletes;

    protected $fillable = [
        'person_id',
        'email',
        'phone_number',
        'password',
        'language',
        'qualifications',
    ];

    protected array $revisionable = [
        'person_id',
        'email',
        'phone_number',
        'language',
        'qualifications',
    ];

    protected $casts = [
        'qualifications' => 'array',
        'email_verified_at' => 'datetime',
        'phone_number' => 'encrypted',
        'password' => 'hashed',
    ];

    protected function language(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $locale = $value ?? config('app.locale');

                return Language::tryFrom($locale) ?? Language::English;
            },
            set: fn ($value) => $value instanceof Language ? $value->value : $value,
        );
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->using(OrganizationPractitioner::class);
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

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class)
            ->using(PatientPractitioner::class);
    }

    public function createOrganization(array $attributes): Organization
    {
        $organization = Organization::create($attributes);
        $this->organizations()->attach($organization);

        return $organization;
    }
}
