<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\EditProfile as BasePage;

class EditProfile extends BasePage
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent()->disabled(),
                        $this->getFirstNameFormComponent(),
                        $this->getLastNameFormComponent(),
                        $this->getPeselFormComponent(),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
                    ->inlineLabel(! static::isSimple()),
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

    protected function getPeselFormComponent(): TextInput
    {
        return TextInput::make('pesel')
            ->label(__('PESEL'))
            ->required()
            ->mask('99999999999');
    }
}
