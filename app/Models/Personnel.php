<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personnel extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'personnel';
    protected $guarded = [];

    /**
     * Get the unit that this personnel belongs to.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the user associated with this personnel record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
