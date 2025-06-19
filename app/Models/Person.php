<?php

namespace App\Models;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Identity\Enums\IdentityType;
use App\Feature\Postgres\Casts\EncryptedBinary;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

}

