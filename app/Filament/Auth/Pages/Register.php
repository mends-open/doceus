<?php

namespace App\Filament\Auth\Pages;

use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;
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

    /**
     * Create an empty person record during registration.
     *
     * @param  array<string, mixed>  $data
     */
    protected function handleRegistration(array $data): Model
    {
        $person = Person::create();
        $data['person_id'] = $person->id;

        return $this->getUserModel()::create($data);
    }
}
