<?php

namespace App\Filament\Auth\Pages;

use App\Feature\Identity\Enums\Language;
use Exception;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

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
                $this->getLanguageFormComponent(),
                $this->getPersonFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                $this->getCurrentPasswordFormComponent(),
            ]);
    }

    /**
     * @throws Exception
     */
    protected function getFirstNameFormComponent(): Component
    {
        return TextInput::make('first_name')
            ->label(__('doceus.user.first_name'))
            ->required();
    }

    /**
     * @throws Exception
     */
    protected function getLastNameFormComponent(): Component
    {
        return TextInput::make('last_name')
            ->label(__('doceus.user.last_name'))
            ->required();
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
    protected function getLanguageFormComponent(): Component
    {
        return Select::make('language')
            ->label(__('doceus.user.language'))
            ->options(Language::class);
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
