<?php

namespace App\Filament\Clusters\Managment\Resources;

use App\Filament\Clusters\Managment;
use App\Filament\Clusters\Managment\Resources\PersonResource\Pages;
use App\Models\Person;
use Eloquent;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Managment::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('first_name')
                ->label(__('First Name'))
                ->required()
                ->maxLength(255),

            TextInput::make('last_name')
                ->label(__('Last Name'))
                ->required()
                ->maxLength(255),

            TextInput::make('pesel')
                ->label(__('PESEL'))
                ->required()
                ->mask('99999999999'),

            TextInput::make('email')
                ->label(__('Email'))
                ->email()
                ->required()
                ->maxLength(255),

            TextInput::make('phone')
                ->label(__('Phone'))
                ->tel()
                ->maxLength(50),

            Hidden::make('organization_id')
                ->default(fn () => Filament::getTenant()?->getKey())
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('sqid')
                    ->label(__('ID'))
                    ->searchable(),

                TextColumn::make('first_name')
                    ->label(__('First Name'))
                    ->searchable()
                    ->limit(20),

                TextColumn::make('last_name')
                    ->label(__('Last Name'))
                    ->searchable()
                    ->limit(20),

                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->limit(30),

                TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->date('Y F d l')
                    ->sortable(),
            ])
            ->filters([
                // Add filters here if needed in the future.
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
        return [
            // Define relation managers here if needed.
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePerson::route('/create'),
            'edit' => Pages\EditPerson::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteKeyName(): string
    {
        // Tells Filament resource pages to use the route key "sqid"
        return 'sqid';
    }

    public static function resolveRecordRouteBinding($key): Eloquent
    {
        return (new Person)->resolveRouteBinding($key);
    }
}
