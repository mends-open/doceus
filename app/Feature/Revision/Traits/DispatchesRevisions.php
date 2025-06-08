<?php

namespace App\Feature\Revision\Traits;

use App\Feature\Revision\Enums\RevisionType;
use App\Feature\Revision\Jobs\CreateRevision;
use Illuminate\Database\Eloquent\Model;

trait DispatchesRevisions
{
    protected function getUserId(): ?int
    {
        return auth()->id() ?? null;
    }

    protected function getOrganizationId(): ?int
    {
        $organization = filament()?->getTenant();

        return $organization?->id ?? null;
    }

    protected function getRevisableAttributes(Model $model): array
    {
        $fields = $model->getRevisionable();

        return array_intersect_key($model->getAttributes(), array_flip($fields));
    }

    protected function getChangedAttributes(Model $model): array
    {
        $changed = array_keys($model->getChanges());
        $fields = $model->getRevisionable();
        $changedFields = array_intersect($changed, $fields);

        return array_intersect_key($model->getAttributes(), array_flip($changedFields));
    }

    protected function resolveRevisionableMorph(Model $model, mixed $forcedType = null, mixed $forcedId = null): array
    {
        return [
            'revisionable_type' => $forcedType ?? get_class($model),
            'revisionable_id' => $forcedId ?? $model->getKey(),
        ];
    }

    protected function buildRevisionData(
        Model $model,
        RevisionType $eventType,
        ?int $userId,
        ?int $tenantId,
        mixed $forcedType = null,
        mixed $forcedId = null
    ): array {
        $data = match ($eventType) {
            RevisionType::Created => $this->getRevisableAttributes($model),
            RevisionType::Updated => $this->getChangedAttributes($model),
            RevisionType::Deleted,
            RevisionType::ForceDeleted,
            RevisionType::Restored => null,
        };

        $morph = $this->resolveRevisionableMorph($model, $forcedType, $forcedId);

        return [
            'dispatched_at' => now()->format('Y-m-d H:i:s.u'),
            'organization_id' => $tenantId,
            'user_id' => $userId,
            'revisionable_type' => $morph['revisionable_type'],
            'revisionable_id' => $morph['revisionable_id'],
            'type' => $eventType->value,
            'data' => $data,
        ];
    }

    protected function dispatchRevisionJob(Model $model, RevisionType $type): void
    {
        if (! method_exists($model, 'getRevisionable')) {
            return;
        }
        $revisionData = $this->buildRevisionData($model, $type, $this->getUserId(), $this->getOrganizationId());
        dispatch(new CreateRevision($revisionData, $model));
    }
}
