<?php

namespace App\Filament\Clusters\Managment\Resources;

use App\Filament\Clusters\Managment;
use App\Filament\Clusters\Managment\Resources\PatientResource\Pages;
use App\Feature\Identity\Enums\Gender;
use App\Models\Patient;
use Eloquent;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $cluster = Managment::class;

    protected static ?string $tenantOwnershipRelationshipName = 'organizations';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('person.first_name')
                ->label(__('First Name'))
                ->required()
                ->maxLength(255),

            TextInput::make('person.last_name')
                ->label(__('Last Name'))
                ->required()
                ->maxLength(255),

            TextInput::make('person.pesel')
                ->label(__('PESEL'))
                ->required()
                ->mask('99999999999'),

            TextInput::make('person.id_number')
                ->label(__('ID Number'))
                ->maxLength(255),

            Select::make('person.gender')
                ->label(__('doceus.gender.label'))
                ->options(collect(Gender::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray())
                ->enum(Gender::class),

            Forms\Components\DatePicker::make('person.birth_date')
                ->label(__('Birth Date')),

            Select::make('person.emails')
                ->label(__('Emails'))
                ->relationship('person.emails', 'value')
                ->multiple()
                ->preload()
                ->searchable()
                ->createOptionForm([
                    TextInput::make('email')
                        ->label(__('Email'))
                        ->email()
                        ->required(),
                ]),

            Select::make('person.phones')
                ->label(__('Phones'))
                ->relationship('person.phones', 'value')
                ->multiple()
                ->preload()
                ->searchable()
                ->createOptionForm([
                    TextInput::make('phone')
                        ->label(__('Phone'))
                        ->tel()
                        ->required(),
                ]),
        ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('sqid')
                    ->label(__('ID'))
                    ->searchable(),

                TextColumn::make('person.first_name')
                    ->label(__('First Name'))
                    ->searchable()
                    ->limit(20),

                TextColumn::make('person.last_name')
                    ->label(__('Last Name'))
                    ->searchable()
                    ->limit(20),

                TextColumn::make('person.gender')
                    ->label(__('doceus.gender.label'))
                    ->formatStateUsing(fn (?Gender $state) => $state?->label())
                    ->sortable(),

                TextColumn::make('person.birth_date')
                    ->label(__('Birth Date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->date('Y F d l')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'sqid';
    }

    public static function resolveRecordRouteBinding($key): Eloquent
    {
        return (new Patient())->resolveRouteBinding($key);
    }
}

