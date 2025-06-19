<?php

namespace App\Models;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Postgres\Casts\EncryptedBinary;
use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed|null $pesel
 * @property mixed|null $id_number
 * @property Gender|null $gender
 * @property Carbon|null $birth_date
 * @property string|null $email
 * @property string|null $phone_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read string|null $sqid
 * @property-read Practitioner|null $practitioner
 * @property-read Patient|null $patient
 *
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
 *
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
        'email',
        'phone_number',
    ];

    protected array $revisionable = [
        'first_name',
        'last_name',
        'pesel',
        'id_number',
        'gender',
        'birth_date',
        'email',
        'phone_number',
    ];

    protected $casts = [
        'first_name' => EncryptedBinary::class,
        'last_name' => EncryptedBinary::class,
        'pesel' => EncryptedBinary::class,
        'id_number' => EncryptedBinary::class,
        'gender' => Gender::class,
        'birth_date' => 'date',
        'email' => EncryptedBinary::class,
        'phone_number' => EncryptedBinary::class,
    ];

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
    public function practitioner(): HasOne
    {
        return $this->hasOne(Practitioner::class);
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }
}
