<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    /**
     * Get the organization that owns the unit.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the personnel assigned to the unit.
     */
    public function personnel()
    {
        return $this->hasMany(Personnel::class);
    }
}
