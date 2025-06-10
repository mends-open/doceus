<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\EditProfile as BasePage;

class EditProfile extends BasePage
{
    /**
     * @throws \Exception
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailDisplayComponent(),
                        Group::make()
                            ->relationship('person')
                            ->schema([
                                $this->getFirstNameFormComponent(),
                                $this->getLastNameFormComponent(),
                                $this->getPeselFormComponent(),
                            ])
                    ])
                    ->operation('edit')
                    ->statePath('data')
                    ->model($this->getUser())
                    ->inlineLabel(! static::isSimple()),
            ),
        ];
    }

    protected function getEmailDisplayComponent(): TextInput
    {
        return TextInput::make('email')
            ->label(__('Email'))
            ->disabled()
            ->dehydrated(false);
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
