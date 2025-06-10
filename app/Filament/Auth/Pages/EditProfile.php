<?php

namespace App\Filament\Auth\Pages;

use Exception;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Component;
use Filament\Forms\Components\TextInput;

class EditProfile extends BaseEditProfile
{
    /**
     * @throws Exception
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPersonFormComponent(),
            ]);
    }

    /**
     * @throws Exception
     */
    protected function getFirstNameFormComponent(): Component
    {
        return TextInput::make('first_name');
    }

    /**
     * @throws Exception
     */
    protected function getLastNameFormComponent(): Component
    {
        return TextInput::make('last_name');
    }

    /**
     * @throws Exception
     */
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::auth/pages/edit-profile.form.email.label'))
            ->email()
            ->required();
    }


    /**
     * @throws Exception
     */
    protected function getPersonFormComponent(): Component
    {
        return Group::make()
            ->relationship('person')
            ->schema([
                $this->getFirstNameFormComponent(),
                $this->getLastNameFormComponent(),
            ]);
    }

}
