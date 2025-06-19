<?php

namespace App\Models;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\IdentityType;
use App\Feature\Postgres\Casts\EncryptedBinary;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $pesel
 * @property string $identity_number
 * @property IdentityType $identity_type
 * @property Gender $gender
 * @property \Illuminate\Support\Carbon $birth_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read Patient|null $patient
 * @property-read Practitioner|null $practitioner
 * @property-read User|null $user
 */
class Person extends BaseModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'pesel',
        'identity_number',
        'identity_type',
        'gender',
        'birth_date',
    ];

    protected array $revisionable = [
        'first_name',
        'last_name',
        'pesel',
        'identity_number',
        'identity_type',
        'gender',
        'birth_date',
    ];

    /* ────────────────────────────  Casts  ────────────────────────────── */
    protected $casts = [
        'first_name'      => EncryptedBinary::class,
        'last_name'       => EncryptedBinary::class,
        'pesel'           => EncryptedBinary::class,
        'identity_number' => EncryptedBinary::class,
        'identity_type'   => IdentityType::class,
        'gender'          => Gender::class,
        'birth_date'      => 'date',
    ];

    /* ─────────────────────────  Relationships  ───────────────────────── */

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

    public function practitioner(): HasOne
    {
        return $this->hasOne(Practitioner::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function isComplete(): bool
    {
        return filled($this->first_name)
            && filled($this->last_name)
            && filled($this->pesel);
    }

}

