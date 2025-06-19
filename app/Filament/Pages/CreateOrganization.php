<?php

namespace App\Filament\Pages;

use App\Feature\Identity\Enums\OrganizationType;
use App\Models\Organization;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Filament\Facades\Filament;

class CreateOrganization extends RegisterTenant
{
    public static function getLabel(): string
    {
        return __('Create organization');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('type')
                ->label(__('doceus.organization.type'))
                ->options(collect(OrganizationType::cases())
                    ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                    ->toArray())
                ->required(),
            TextInput::make('name')
                ->label(__('doceus.organization.name'))
                ->required(),
        ]);
    }

    protected function handleRegistration(array $data): \Illuminate\Database\Eloquent\Model
    {
        $organization = Organization::create($data);

        Filament::auth()->user()
            ->practitioner
            ->organizations()
            ->attach($organization);

        return $organization;
    }
}
