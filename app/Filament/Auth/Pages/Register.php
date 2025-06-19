<?php

namespace App\Filament\Auth\Pages;

use Exception;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class Register extends BaseRegister
{
    /**
     * @throws Exception
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPhoneFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    /**
     * @throws Exception
     */
    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label(__('doceus.user.phone'))
            ->tel()
            ->required();
    }
}
