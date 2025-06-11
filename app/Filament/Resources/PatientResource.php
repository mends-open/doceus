<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Models\Patient;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\Select::make('person_id')
                            ->relationship('person', 'first_name')
                            ->searchable()
                            ->required(),
                    ])->grow(),
                    Forms\Components\Section::make([
                        Forms\Components\ToggleButtons::make('tags')
                            ->relationship('tags', 'name')
                            ->options(fn () => Tag::pluck('name', 'id')->toArray())
                            ->columns(1)
                            ->multiple(),
                    ])->grow(false),
                ])->from('md'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('person.first_name')->label('First name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePatients::route('/'),
        ];
    }
}
