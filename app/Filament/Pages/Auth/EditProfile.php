<?php

namespace App\Filament\Pages\Auth;

use App\Enums\Language;
use App\Rules\ValidPesel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent()->disabled(),
                TextInput::make('first_name')
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->maxLength(255),
                TextInput::make('pesel')
                    ->rule(new ValidPesel),
                Select::make('language')
                    ->options(Language::class)
                    ->enum(Language::class),
            ])
            ->columns(4);
    }
}
