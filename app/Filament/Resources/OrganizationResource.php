<?php

namespace App\Filament\Resources;

use App\Enums\OrganizationType;
use App\Filament\Clusters\Settings;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Models\Organization;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrganizationResource extends Resource
{
    protected static ?string $cluster = Settings::class;

    protected static ?string $model = Organization::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('doceus.organization.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('doceus.organization.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return static::getPluralModelLabel();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->label(__('doceus.organization.type'))
                    ->options(
                        collect(OrganizationType::cases())
                            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                            ->toArray()
                    )
                    ->enum(OrganizationType::class)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label(__('doceus.organization.type'))
                    ->formatStateUsing(fn ($state) => $state?->label() ?? '-')
                    ->sortable(),
            ])
            ->recordAction('view')
            ->actions([
                ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
        ];
    }
}
