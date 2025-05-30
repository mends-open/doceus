<?php

namespace App\Listeners;

use App\Database\Views\MaterializedView;
use App\Events\MaterializedViewNeedsRefresh;

class RefreshMaterializedView
{
    public function handle(MaterializedViewNeedsRefresh $event): void
    {
        MaterializedView::make($event->viewName)->refresh($event->concurrently);
    }
}
