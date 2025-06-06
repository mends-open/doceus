<?php

namespace App\Revisions;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use App\Revisions\CreateRevisionJob;

trait LogsRevisions
{
    /**
     * Boot the LogsRevisions trait for a model.
     */
    public static function bootLogsRevisions(): void
    {
        static::created(function ($model) {
            $model->maybeLogRevision('created');
        });
        static::updated(function ($model) {
            $model->maybeLogRevision('updated');
        });
    }

    /**
     * Check if a revision should be logged for this action and dispatch to queue with a ms-accurate timestamp.
     */
    protected function maybeLogRevision(string $action): void
    {
        $actions = property_exists($this, 'revisionActions')
            ? $this->revisionActions
            : ['created', 'updated', 'deleted', 'restored'];

        if (!in_array($action, $actions, true)) {
            return;
        }

        $dispatchedAt = now()->format('Y-m-d H:i:s.u');
        $visibleRevisionable = $this->getVisibleRevisionableAttributes();
        $revisionData = $this->getRevisionData($action, $visibleRevisionable);

        if (empty($revisionData)) {
            return;
        }

        dispatch(new CreateRevisionJob(
            clone $this,
            $dispatchedAt,              // string $dispatchedAt
            $revisionData,              // array $attributes
            filament()->getTenant()->id ?? null, // ?int $organizationId
            auth()->id()                // ?int $userId
        ));
    }

    /**
     * Get the list of revisionable attributes visible for revision logging (excluding hidden).
     */
    private function getVisibleRevisionableAttributes(): array
    {
        $revisionable = property_exists($this, 'revisionable') ? $this->revisionable : ($this->fillable ?? []);
        $hidden = [];
        if (property_exists($this, 'hidden') && is_array($this->hidden)) {
            $hidden = $this->hidden;
        } elseif (method_exists($this, 'getHidden')) {
            $result = $this->getHidden();
            $hidden = is_array($result) ? $result : [];
        }
        return array_diff($revisionable, $hidden);
    }

    /**
     * Get the revision data for the given action and attribute whitelist.
     */
    private function getRevisionData(string $action, array $visibleRevisionable): array
    {
        $attributes = $action === 'updated' ? $this->getDirty() : $this->getAttributes();
        return array_intersect_key($attributes, array_flip($visibleRevisionable));
    }
}
