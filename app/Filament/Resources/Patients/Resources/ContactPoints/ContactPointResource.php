<?php

namespace App\Filament\Resources\Patients\Resources\ContactPoints;

use App\Filament\Resources\Patients\PatientResource;
use App\Filament\Resources\Patients\Resources\ContactPoints\Pages\CreateContactPoint;
use App\Filament\Resources\Patients\Resources\ContactPoints\Pages\EditContactPoint;
use App\Filament\Resources\Patients\Resources\ContactPoints\Schemas\ContactPointForm;
use App\Filament\Resources\Patients\Resources\ContactPoints\Tables\ContactPointsTable;
use App\Models\ContactPoint;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactPointResource extends Resource
{
    protected static ?string $model = ContactPoint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = PatientResource::class;

    public static function form(Schema $schema): Schema
    {
        return ContactPointForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactPointsTable::configure($table);
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
            'create' => CreateContactPoint::route('/create'),
            'edit' => EditContactPoint::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
