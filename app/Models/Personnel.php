<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Unit;
use App\Models\User;

class Personnel extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'personnel';
    protected $guarded = [];

    /**
     * Unit this personnel assignment belongs to.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * User for this personnel record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
