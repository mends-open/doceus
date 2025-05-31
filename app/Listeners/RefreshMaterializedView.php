<?php

namespace App\Listeners;

use App\Events\MaterializedViewNeedsRefresh;
use Illuminate\Support\Facades\Schema;

class RefreshMaterializedView
{
    public function handle(MaterializedViewNeedsRefresh $event): void
    {
        Schema::refreshMaterializedView($event->viewName, $event->concurrently);
    }
}
