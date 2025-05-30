<?php

namespace App\Filament\Pages\Tenancy;

use App\Enums\FeatureEvent;
use App\Enums\OrganizationType;
use App\Enums\UserFeature;
use App\Models\Organization;
use App\Models\OrganizationUserFeature;
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
                Select::make('user_feature')
                    ->options(
                        collect(UserFeature::cases())->mapWithKeys(
                            fn ($case) => [$case->value => $case->label()]
                        )->toArray()
                    )
                    ->enum(UserFeature::class)
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
            OrganizationUserFeature::create([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'feature' => $data['user_feature'],
                'event' => FeatureEvent::GRANTED,
                'created_by' => $user->id,
            ]);

            // 3. Optionally: Set user's default org/role
            $user->update([
                'default_organization_id' => $organization->id,
                // To reference default user_feature, use org_id+user_id+user_feature, or just user_feature if user/org is unique
            ]);

            return $organization;
        });
    }
}
