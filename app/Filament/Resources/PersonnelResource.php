<?php

namespace App\Filament\Resources;

use App\Enums\PersonnelType;
use App\Filament\Clusters\Settings;
use App\Filament\Resources\PersonnelResource\Pages;
use App\Models\Personnel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PersonnelResource extends Resource
{
    protected static ?string $cluster = Settings::class;

    protected static ?string $model = Personnel::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('doceus.personnel.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('doceus.personnel.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return static::getPluralModelLabel();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('unit_id')
                    ->relationship('unit', 'id')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'id')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label(__('doceus.personnel.type'))
                    ->options(PersonnelType::class)
                    ->enum(PersonnelType::class)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.first_name')->label(__('doceus.user.first_name'))->sortable(),
                TextColumn::make('user.last_name')->label(__('doceus.user.last_name'))->sortable(),
                TextColumn::make('user.email')->label(__('doceus.user.email'))->sortable(),
                TextColumn::make('type')->label(__('doceus.personnel.type'))->sortable()->formatStateUsing(fn ($state) => $state?->label() ?? ''),
                TextColumn::make('unit.type')->label(__('doceus.unit.type'))->sortable()->formatStateUsing(fn ($state) => $state?->label() ?? ''),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPersonnels::route('/'),
        ];
    }
}
