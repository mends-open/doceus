<?php

namespace App\Filament\Pages\Tenancy;

use App\Enums\OrganizationType;
use App\Models\Organization;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Support\Facades\DB;

class RegisterOrganization extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register team';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->options(
                        collect(OrganizationType::cases())->mapWithKeys(
                            fn ($case) => [$case->value => $case->label()]
                        )->toArray()
                    )
                    ->enum(OrganizationType::class)
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->autofocus()
                    ->placeholder('Name of the organization')
                    ->helperText('Name of the organization')
                    ->label('Name'),
            ]);
    }

    protected function handleRegistration(array $data): Organization
    {
        return DB::transaction(function () use ($data) {
            $organization = Organization::create([
                'type' => $data['type'],
                'name' => $data['name'],
            ]);
            // Attach the current user to the organization, if authenticated
            if (auth()->check()) {
                $organization->users()->attach(auth()->id());
            }
            return $organization;
        });
    }
}
