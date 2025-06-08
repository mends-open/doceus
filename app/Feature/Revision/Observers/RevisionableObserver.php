<?php

namespace App\Feature\Revision\Observers;

use App\Feature\Revision\Enums\RevisionType;
use App\Feature\Revision\Traits\DispatchesRevisions;
use Illuminate\Database\Eloquent\Model;

class RevisionableObserver
{
    use DispatchesRevisions;

    public function created(Model $model): void
    {
        $this->dispatchRevisionJob($model, RevisionType::Created);
    }

    public function updated(Model $model): void
    {
        if (! empty($this->getChangedAttributes($model))) {
            $this->dispatchRevisionJob($model, RevisionType::Updated);
        }
    }

    public function deleted(Model $model): void
    {
        if (method_exists($model, 'isForceDeleting') && $model->isForceDeleting()) {
            return;
        }

        $this->dispatchRevisionJob($model, RevisionType::Deleted);
    }

    public function restored(Model $model): void
    {
        $this->dispatchRevisionJob($model, RevisionType::Restored);
    }

    public function forceDeleted(Model $model): void
    {
        $this->dispatchRevisionJob($model, RevisionType::ForceDeleted);
    }
}
