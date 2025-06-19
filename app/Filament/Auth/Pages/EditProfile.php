<?php

namespace App\Filament\Auth\Pages;

use App\Feature\Identity\Enums\Language;
use App\Feature\Identity\Rules\ValidPesel;
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
                $this->getEmailFormComponent()->disabled()->dehydrated(false),
                $this->getPhoneFormComponent()->disabled()->dehydrated(false),
                $this->getLanguageFormComponent(),
                $this->getPersonFormComponent(),
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

    protected function getPeselFormComponent(): Component
    {
        return TextInput::make('pesel')
            ->label(__('doceus.user.pesel'))
            ->required()
            ->rule(new ValidPesel);
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

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label(__('doceus.user.phone'))
            ->tel();
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
            ->schema(\App\People\Schemas\PersonSchema::make()->getComponents());
    }

    protected function getRedirectUrl(): ?string
    {
        return '/';
    }
}
