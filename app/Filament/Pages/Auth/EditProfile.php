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
                        $this->getEmailDisplayComponent(),
                        $this->getFirstNameFormComponent(),
                        $this->getLastNameFormComponent(),
                        $this->getPeselFormComponent(),
                    ])
                    ->operation('edit')
                    ->model($this->getUser()->person)
                    ->statePath('data')
                    ->inlineLabel(! static::isSimple()),
            ),
        ];
    }

    protected function getEmailDisplayComponent(): TextInput
    {
        return TextInput::make('email')
            ->label(__('Email'))
            ->default($this->getUser()->email)
            ->disabled()
            ->dehydrated(false);
    }

    protected function getFirstNameFormComponent(): TextInput
    {
        return TextInput::make('person.first_name')
            ->label(__('doceus.auth.first_name'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getLastNameFormComponent(): TextInput
    {
        return TextInput::make('person.last_name')
            ->label(__('doceus.auth.last_name'))
            ->required()
            ->maxLength(255);
    }

    protected function getPeselFormComponent(): TextInput
    {
        return TextInput::make('person.pesel')
            ->label(__('PESEL'))
            ->required()
            ->mask('99999999999');
    }

    /**
     * Load data from the authenticated user's related Person record.
     * @throws \Exception
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->getUser()->with('person')->first()->toArray();
    }

    /**
     * Persist profile updates to the Person model instead of the User.
     */
    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $record->person->update($data);

        return $record;
    }
}
