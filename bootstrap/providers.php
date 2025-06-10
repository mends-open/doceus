<?php

use App\Providers\AppServiceProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\TelescopeServiceProvider;
use App\Providers\Filament\AppPanelProvider;
use App\Feature\Polymorphic\Providers\PolymorphicServiceProvider;

return [
    AppServiceProvider::class,
    HorizonServiceProvider::class,
    TelescopeServiceProvider::class,
    AppPanelProvider::class,
    PolymorphicServiceProvider::class,
];
