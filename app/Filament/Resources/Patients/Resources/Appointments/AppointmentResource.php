<?php

namespace App\Filament\Resources\Patients\Resources\Appointments;

use App\Filament\Resources\Patients\PatientResource;
use App\Filament\Resources\Patients\Resources\Appointments\Pages\CreateAppointment;
use App\Filament\Resources\Patients\Resources\Appointments\Pages\EditAppointment;
use App\Filament\Resources\Patients\Resources\Appointments\Pages\ViewAppointment;
use App\Filament\Resources\Patients\Resources\Appointments\Schemas\AppointmentForm;
use App\Filament\Resources\Patients\Resources\Appointments\Schemas\AppointmentInfolist;
use App\Filament\Resources\Patients\Resources\Appointments\Tables\AppointmentsTable;
use App\Models\Appointment;
use App\Traits\BelongsToManyOrganizations;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $tenantOwnershipRelationshipName = 'organizations';

    protected static ?string $model = Appointment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = PatientResource::class;

    public static function form(Schema $schema): Schema
    {
        return AppointmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AppointmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AppointmentsTable::configure($table);
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
            'create' => CreateAppointment::route('/create'),
            'view' => ViewAppointment::route('/{record}'),
            'edit' => EditAppointment::route('/{record}/edit'),
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
