<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Models\Patient;
use App\People\Schemas\PersonSchema;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Group::make()
                ->relationship('person')
                ->schema(PersonSchema::make()->getComponents()),
            TextInput::make('email')
                ->label(__('doceus.user.email'))
                ->email()
                ->required(),
            TextInput::make('phone_number')
                ->label(__('doceus.user.phone'))
                ->tel()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('person.first_name')
                ->label(__('doceus.user.first_name'))
                ->sortable()
                ->searchable(),
            TextColumn::make('person.last_name')
                ->label(__('doceus.user.last_name'))
                ->sortable()
                ->searchable(),
            TextColumn::make('email')
                ->label(__('doceus.user.email')),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
