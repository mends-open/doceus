<?php

namespace App\Models\Traits;

use App\Models\Organization;
use App\Services\Tenant;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::creating(function ($model) {
            if (! $model->organization_id && Tenant::current()) {
                $model->organization_id = Tenant::current()->id;
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            if ($org = Tenant::current()) {
                $builder->where($builder->getModel()->getTable() . '.organization_id', $org->id);
            }
        });
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
