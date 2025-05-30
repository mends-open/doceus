<?php

namespace App\Listeners;

use App\Events\MaterializedViewNeedsRefresh;
use App\Database\Views\MaterializedView;

class RefreshMaterializedView
{
    public function handle(MaterializedViewNeedsRefresh $event): void
    {
        MaterializedView::make($event->viewName)->refresh($event->concurrently);
    }
}
