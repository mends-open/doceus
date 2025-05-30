<?php

namespace App\Models;

use App\Enums\FeatureEvent;
use App\Enums\UserFeature;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationUserEvent extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'organization_user_events';

    protected $guarded = [];

    protected $casts = [
        'user_feature' => UserFeature::class,
        'event' => FeatureEvent::class,
    ];
}
