<?php

namespace App\Domain\Revision\Traits;

use App\Domain\Revision\Enums\RevisionType;
use Illuminate\Database\Eloquent\Model;

trait LogsRevisionHelpers
{
    protected function revisionableRaw(Model $model): array
    {
        $fields = $model->getRevisionable();

        return array_intersect_key($model->getAttributes(), array_flip($fields));
    }

    protected function changedRevisionableRaw(Model $model): array
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
            RevisionType::Created => $this->revisionableRaw($model),
            RevisionType::Updated => $this->changedRevisionableRaw($model),
            RevisionType::Deleted,
            RevisionType::ForceDeleted,
            RevisionType::Restored => null,
        };

        $morph = $this->resolveRevisionableMorph($model, $forcedType, $forcedId);

        return [
            'dispatched_at' => now()->format('Y-m-d H:i:s.u') ,
            'organization_id' => $tenantId,
            'user_id' => $userId,
            'revisionable_type' => $morph['revisionable_type'],
            'revisionable_id' => $morph['revisionable_id'],
            'type' => $eventType->value,
            'data' => $data,
        ];
    }
}
