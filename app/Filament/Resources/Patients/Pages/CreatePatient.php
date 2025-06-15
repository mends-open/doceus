<?php

namespace App\Filament\Resources\Patients\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class CreatePatient extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('tag_ids'),
        ]);
    }
}
