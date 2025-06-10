<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    App\Providers\Filament\AppPanelProvider::class,
    \App\Feature\Polymorphic\Providers\PolymorphicServiceProvider::class,
];
