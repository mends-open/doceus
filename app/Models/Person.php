<?php

namespace App\Models;

use App\Feature\Identity\Enums\Gender;
use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use App\Feature\Sqid\Interfaces\Sqidable;
use App\Feature\Sqid\Traits\HasSqids;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $pesel
 * @property string|null $id_number
 * @property \App\Feature\Identity\Enums\Gender|null $gender
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string $email
 * @property string $phone
 * @property int $organization_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string|null $sqid
 * @property-read \App\Models\Organization|null $organization
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person wherePesel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person withoutTrashed()
 *
 * @mixin \Eloquent
 */
#[ObservedBy([RevisionableObserver::class])]
class Person extends Model implements Revisionable, Sqidable
{
    use HasFactory, HasSqids, LogsRevisions, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'pesel',
        'id_number',
        'gender',
        'birth_date',
        'email',
        'phone',
        'organization_id',
    ];

    protected array $revisionable = [
        'organization_id',
        'first_name',
        'last_name',
        'email',
        'phone',
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
        'email' => 'encrypted',
        'phone' => 'encrypted',
        'gender' => Gender::class,
        'birth_date' => 'date',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Make Person tenant-aware by implementing tenantId method (Filament tenancy)
     */
    public function getTenantKeyName(): string
    {
        return 'organization_id';
    }

    public function getTenantKey(): mixed
    {
        return $this->organization_id;
    }

    public function tenantKey(): mixed
    {
        return $this->organization_id;
    }
}
