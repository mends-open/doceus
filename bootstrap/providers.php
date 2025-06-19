<?php

use App\Feature\Polymorphic\Providers\PolymorphicServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\Filament\AppPanelProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\TelescopeServiceProvider;

return [
    AppServiceProvider::class,
    HorizonServiceProvider::class,
    TelescopeServiceProvider::class,
    AppPanelProvider::class,
    PolymorphicServiceProvider::class,
];
