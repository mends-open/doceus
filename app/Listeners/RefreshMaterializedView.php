<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Schema;
use App\Events\MaterializedViewNeedsRefresh;

class RefreshMaterializedView
{
    public function handle(MaterializedViewNeedsRefresh $event): void
    {
        Schema::refreshMaterializedView($event->viewName, $event->concurrently);
    }
}
