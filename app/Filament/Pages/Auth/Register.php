<?php

namespace App\Filament\Pages\Auth;

use App\Enums\RoleType;
use App\Jobs\CreateDefaultEntities;
use Filament\Forms\Components\Select;
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
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        Select::make('role')
                            ->options(RoleType::class)
                            ->enum(RoleType::class)
                            ->required(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

}
