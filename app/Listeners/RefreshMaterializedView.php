<?php

namespace App\Listeners;

use App\Events\MaterializedViewNeedsRefresh;
use App\Support\MaterializedView;

class RefreshMaterializedView
{
    public function handle(MaterializedViewNeedsRefresh $event): void
    {
        MaterializedView::refresh($event->viewName, $event->concurrently);
    }
}
