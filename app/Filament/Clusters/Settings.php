<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Settings extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function getLabel(): string
    {
        return __('doceus.settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('doceus.settings');
    }
}
