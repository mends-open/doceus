<?php

namespace App\Feature\Revision\Observers;

use App\Feature\Revision\Enums\RevisionType;
use App\Feature\Revision\Jobs\CreateRevision;
use App\Feature\Revision\Traits\LogsRevisionHelpers;
use Illuminate\Database\Eloquent\Model;

class RevisionableObserver
{
    use LogsRevisionHelpers;

    protected function userId(): ?int
    {
        return auth()->id() ?? null;
    }

    protected function tenantId(): ?int
    {
        $tenant = filament()?->getTenant();

        return $tenant?->id ?? null;
    }

    protected function dispatchRevisionJob(Model $model, RevisionType $type): void
    {
        if (! method_exists($model, 'getRevisionable')) {
            return;
        }
        $revisionData = $this->buildRevisionData($model, $type, $this->userId(), $this->tenantId());
        dispatch(new CreateRevision($revisionData, $model));
    }

    public function created(Model $model): void
    {
        $this->dispatchRevisionJob($model, RevisionType::Created);
    }

    public function updated(Model $model): void
    {
        if (! method_exists($model, 'getRevisionable')) {
            return;
        }
        $revisionData = $this->buildRevisionData($model, RevisionType::Updated, $this->userId(), $this->tenantId());
        if (! empty($revisionData['data'])) {
            dispatch(new CreateRevision($revisionData, $model));
        }
    }

    public function deleted(Model $model): void
    {
        if ((method_exists($model, 'isForceDeleting') && $model->isForceDeleting()) ||
            (property_exists($model, 'forceDeleting') && $model->forceDeleting)) {
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
