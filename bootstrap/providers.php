<?php

use App\Feature\Polymorphic\Providers\PolymorphicServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\Filament\PractitionerPanelProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\TelescopeServiceProvider;

return [
    AppServiceProvider::class,
    HorizonServiceProvider::class,
    TelescopeServiceProvider::class,
    PractitionerPanelProvider::class,
    PolymorphicServiceProvider::class,
];
