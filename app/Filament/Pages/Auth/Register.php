<?php

namespace App\Filament\Pages\Auth;

use App\Enums\RoleType;
use App\Jobs\CreateDefaultEntities;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Support\Facades\Auth;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getFirstNameFormComponent(),
                        $this->getLastNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getFirstNameFormComponent(): TextInput
    {
        return TextInput::make('first_name')
            ->label(__('doceus.auth.first_name'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getLastNameFormComponent(): TextInput
    {
        return TextInput::make('last_name')
            ->label(__('doceus.auth.last_name'))
            ->required()
            ->maxLength(255);
    }

}
