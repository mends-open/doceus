<?php

namespace App\Utilities\MaterializedView\Events;

class MaterializedViewNeedsRefresh
{
    public function __construct(
        public string $viewName,
        public bool $concurrently = false,
    ) {}
}
