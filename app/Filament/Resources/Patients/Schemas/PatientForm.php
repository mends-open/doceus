<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Filament\Resources\Tags\Schemas\TagSelector;
use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

class PatientForm
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'md'     => 6,     // 768-1023 px
                'lg'     => 8,     // 1024-1279 px
                'xl'     => 12,    // ≥1280 px
            ])
            ->components([
                PersonForm::make()
                    ->columnSpan(8)->columnStart(3),
            ]);
    }
}
