<?php

namespace App\Filament\Pages\Tenancy;

use App\Enums\OrganizationType;
use App\Enums\RoleType;
use App\Models\Organization;
use App\Models\Role;
use Filament\Forms\Components\Select;
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
                Select::make('role_type')
                    ->options(
                        collect(RoleType::cases())->mapWithKeys(
                            fn ($case) => [$case->value => $case->label()]
                        )->toArray()
                    )
                    ->enum(RoleType::class)
                    ->required(),
            ]);
    }

    protected function handleRegistration(array $data): Organization
    {
        return DB::transaction(function () use ($data) {
            $user = auth()->user();

            // 1. Create Organization
            $organization = Organization::create([
                'type' => $data['type'],
            ]);

            // 2. Attach user to organization with role
            $organization->users()->attach($user->id, [
                'role_type' => $data['role_type'],
            ]);

            // 3. Optionally: Set user's default org/role
            $user->update([
                'default_organization_id' => $organization->id,
                // To reference default role, use org_id+user_id+role_type, or just role_type if user/org is unique
            ]);

            return $organization;
        });
    }
}
