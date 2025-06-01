<?php

namespace App\Utilities\MaterializedView\Listeners;

use App\Utilities\MaterializedView\Events\MaterializedViewNeedsRefresh;
use Illuminate\Support\Facades\Schema;

class RefreshMaterializedView
{
    public function handle(MaterializedViewNeedsRefresh $event): void
    {
        Schema::materializedView($event->viewName)->refresh($event->concurrently);
    }
}
