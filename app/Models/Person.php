<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Feature\Identity\Enums\Gender;
use App\Models\ContactPoint;
use App\Models\Practitioner;
use App\Models\Patient;
use App\Feature\Identity\Enums\ContactableType;
use App\Feature\Identity\Enums\ContactPointSystem;
use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use App\Feature\Sqid\Interfaces\Sqidable;
use App\Feature\Sqid\Traits\HasSqids;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed|null $pesel
 * @property mixed|null $id_number
 * @property Gender|null $gender
 * @property Carbon|null $birth_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read string|null $sqid
 * @property-read Collection<int, ContactPoint> $contactPoints
 * @property-read int|null $contact_points_count
 * @property-read Practitioner|null $practitioner
 * @property-read Patient|null $patient
 * @method static PersonFactory factory($count = null, $state = [])
 * @method static Builder<static>|Person newModelQuery()
 * @method static Builder<static>|Person newQuery()
 * @method static Builder<static>|Person onlyTrashed()
 * @method static Builder<static>|Person query()
 * @method static Builder<static>|Person whereBirthDate($value)
 * @method static Builder<static>|Person whereCreatedAt($value)
 * @method static Builder<static>|Person whereDeletedAt($value)
 * @method static Builder<static>|Person whereFirstName($value)
 * @method static Builder<static>|Person whereGender($value)
 * @method static Builder<static>|Person whereId($value)
 * @method static Builder<static>|Person whereIdNumber($value)
 * @method static Builder<static>|Person whereLastName($value)
 * @method static Builder<static>|Person wherePesel($value)
 * @method static Builder<static>|Person whereUpdatedAt($value)
 * @method static Builder<static>|Person withTrashed()
 * @method static Builder<static>|Person withoutTrashed()
 * @mixin \Eloquent
 */
class Person extends BaseModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'pesel',
        'id_number',
        'gender',
        'birth_date',
        ];

    protected array $revisionable = [
        'first_name',
        'last_name',
        'pesel',
        'id_number',
        'gender',
        'birth_date',
    ];

    protected $casts = [
        'first_name' => 'encrypted',
        'last_name' => 'encrypted',
        'pesel' => 'encrypted',
        'id_number' => 'encrypted',
        'gender' => Gender::class,
        'birth_date' => 'date',
    ];

    public function contactPoints(): HasMany
    {
        return $this->hasMany(ContactPoint::class, 'contactable_id')
            ->where('contactable_type', ContactableType::Person);
    }

    public function organizations(): HasManyThrough
    {
        return $this->hasManyThrough(
            Organization::class,
            OrganizationPatient::class,
            'patient_id',
            'id',
            'id',
            'organization_id'
        );
    }

    /**
     * Person email addresses.
     */
    public function emails(): HasMany
    {
        return $this->contactPoints()->where('system', ContactPointSystem::Email);
    }

    /**
     * Person phone numbers.
     */
    public function phones(): HasMany
    {
        return $this->contactPoints()->where('system', ContactPointSystem::Phone);
    }

    public function practitioner(): HasOne
    {
        return $this->hasOne(Practitioner::class);
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }
}
