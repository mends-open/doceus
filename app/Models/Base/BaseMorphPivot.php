<?php

namespace App\Models\Base;

use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

#[ObservedBy([RevisionableObserver::class])]
class BaseMorphPivot extends MorphPivot implements Revisionable
{
    use LogsRevisions;
}
