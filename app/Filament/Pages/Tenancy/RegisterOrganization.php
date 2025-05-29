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
                            fn($case) => [$case->value => $case->label()]
                        )->toArray()
                    )
                    ->enum(OrganizationType::class)
                    ->required(),
                Select::make('role_type')
                    ->options(
                        collect(RoleType::cases())->mapWithKeys(
                            fn($case) => [$case->value => $case->label()]
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

            // 2. Create Role for this user and type (roles.id PK still required for user FK!)
            $role = Role::create([
                'user_id' => $user->id,
                'type'    => $data['role_type'],
            ]);

            // 3. Attach user to organization (organization_user pivot, no id)
            DB::table('organization_user')->insert([
                'organization_id' => $organization->id,
                'user_id'         => $user->id,
            ]);

            // 4. Attach role to organization (organization_role pivot, no id)
            DB::table('organization_role')->insert([
                'organization_id' => $organization->id,
                'role_id'         => $role->id,
            ]);

            // 5. Set user's default org and role (still UUID FKs on user table)
            $user->update([
                'default_organization_id' => $organization->id,
                'default_role_id' => $role->id,
            ]);

            return $organization;
        });
    }
}
