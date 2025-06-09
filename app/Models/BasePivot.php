<?php

namespace App\Models;

use App\Feature\Revision\Interfaces\Revisionable;
use App\Feature\Revision\Observers\RevisionableObserver;
use App\Feature\Revision\Traits\LogsRevisions;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([RevisionableObserver::class])]
class BasePivot extends Pivot implements Revisionable
{
    use LogsRevisions;
}
