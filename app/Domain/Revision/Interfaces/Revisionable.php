<?php

namespace App\Domain\Revision\Interfaces;

interface Revisionable
{
    /**
     * Get the revisionable attributes for the model.
     */
    public function getRevisionable(): array;
}
