<?php

namespace App\Filament\Pages\Auth;

use App\Enums\RoleType;
use App\Jobs\CreateDefaultEntities;
use Filament\Forms\Components\Select;
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
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        Select::make('role')
                            ->options(
                                collect(RoleType::cases())->mapWithKeys(
                                    fn ($case) => [$case->value => $case->label()]
                                )->toArray()
                            )
                            ->enum(RoleType::class)
                            ->required(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    public function register(): ?RegistrationResponse
    {
        $response = parent::register();

        if (Auth::check()) {
            $role = RoleType::from($this->form->getState()['role']);
            CreateDefaultEntities::dispatch(Auth::id(), $role);
        }

        return $response;
    }
}
