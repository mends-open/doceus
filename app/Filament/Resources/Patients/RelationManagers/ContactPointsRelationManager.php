<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use App\Feature\Identity\Enums\ContactPointSystem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;

class ContactPointsRelationManager extends RelationManager
{
    protected static string $relationship = 'contactPoints';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('system')
                ->options(ContactPointSystem::class)
                ->required(),
            TextInput::make('value')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('system'),
                TextColumn::make('value'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}

