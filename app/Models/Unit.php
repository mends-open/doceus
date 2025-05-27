<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Organization;
use App\Models\Personnel;
use App\Models\User;

class Unit extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    /**
     * Organization the unit belongs to.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Personnel assigned to this unit.
     */
    public function personnel(): HasMany
    {
        return $this->hasMany(Personnel::class);
    }

    /**
     * Users assigned to the unit via personnel records.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'personnel');
    }
}
