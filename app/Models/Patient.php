<?php

namespace App\Models;

use App\Feature\Postgres\Casts\EncryptedBinary;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $person_id
 * @property string $email
 * @property string $phone_number
 */
class Patient extends BaseModel
{
    protected $fillable = [
        'person_id',
        'email',
        'phone_number',
    ];

    protected array $revisionable = [
        'person_id',
        'email',
        'phone_number',
    ];

    protected $casts = [
        'email' => EncryptedBinary::class,
        'phone_number' => EncryptedBinary::class,
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->using(OrganizationPatient::class);
    }
}
