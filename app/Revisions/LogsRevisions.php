<?php

namespace App\Revisions;

use Illuminate\Support\Facades\Auth;

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

        // Use high-precision microtime for timestamp (with ms, matching migration)
        $nowMs = now()->format('Y-m-d H:i:s.v');

        // Use visible revisionable attributes (excluding hidden)
        $revisionable = property_exists($this, 'revisionable') ? $this->revisionable : ($this->fillable ?? []);
        $hidden = [];
        if (property_exists($this, 'hidden') && is_array($this->hidden)) {
            $hidden = $this->hidden;
        } elseif (method_exists($this, 'getHidden')) {
            $result = $this->getHidden();
            $hidden = is_array($result) ? $result : [];
        }

        $visibleRevisionable = array_diff($revisionable, $hidden);

        // Get changed values for update, all for create/delete/restore
        $dirty = $action === 'updated' ? $this->getDirty() : $this->getAttributes();
        $revisionData = array_intersect_key($dirty, array_flip($visibleRevisionable));

        if (empty($revisionData)) {
            return;
        }

        // Dispatch creation to queue as a job, passing explicit attribute-value map
        dispatch(new \App\Revisions\CreateRevisionJob(
            clone $this,
            Auth::id(),
            $nowMs,
            $revisionData
        ));
    }
}
