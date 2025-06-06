<?php

namespace App\Models;

use App\Services\Revisions\LogsRevisions;
use App\Traits\Sqids\HasSqid;
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
 */
class Person extends Model
{
    use HasFactory, HasSqid, LogsRevisions, SoftDeletes;

    protected $table = 'people';

    protected $fillable = [
        'first_name',
        'last_name',
        'pesel',
        'email',
        'phone',
        'organization_id',
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
