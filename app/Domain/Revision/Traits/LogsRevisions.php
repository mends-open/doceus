<?php

namespace App\Domain\Revision\Traits;

trait LogsRevisions
{
    /**
     * Get the revisionable attributes for the model.
     */
    public function getRevisionable(): array
    {
        return property_exists($this, 'revisionable')
            ? (array) $this->revisionable
            : [];
    }
}
