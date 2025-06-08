<?php

namespace App\Models;

use App\Domain\Revision\Interfaces\Revisionable;
use App\Domain\Revision\Observers\RevisionableObserver;
use App\Domain\Revision\Traits\LogsRevisions;
use App\Domain\Sqid\Interfaces\Sqidable;
use App\Domain\Sqid\Traits\HasSqids;
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
    ];

    protected $casts = [
        'first_name' => 'encrypted',
        'last_name' => 'encrypted',
        'pesel' => 'encrypted',
        'email' => 'encrypted',
        'phone' => 'encrypted',
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
