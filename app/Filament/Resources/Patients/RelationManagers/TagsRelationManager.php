<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use App\Filament\Resources\Tags\TagResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';
    protected static ?string $title = 'Tags';
    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return TagResource::form($schema);
    }

    public function table(Table $table): Table
    {
        return TagResource::table($table);
    }
}
