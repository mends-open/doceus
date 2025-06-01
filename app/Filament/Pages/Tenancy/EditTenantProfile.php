<?php

namespace App\Filament\Pages\Tenancy;

use App\Enums\FeatureEvent;
use App\Enums\UserFeature;
use App\Models\UserFeatureEvent;
use Filament\Pages\Tenancy\EditTenantProfile as BasePage;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EditTenantProfile extends BasePage
{

    public static function getLabel(): string
    {
        return 'Edit profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_feature')
                    ->label('User Feature')
                    ->options(
                        collect(UserFeature::cases())
                            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                            ->toArray()
                    )
                    ->enum(UserFeature::class)
                    ->required(),
                Select::make('feature_event')
                    ->label('Grant or Revoke')
                    ->options(
                        collect(FeatureEvent::cases())
                            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                            ->toArray()
                    )
                    ->enum(FeatureEvent::class)
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $organization = $this->tenant;

        Log::info(Arr::join([
            'feature'        => $this->data['user_feature'] ?? null,
            'event'          => $this->data['feature_event'] ?? null,
        ], ', '));

        // Persist the feature event
        UserFeatureEvent::create([
            'organization_id' => $organization->id,
            'user_id'        => auth()->id(),
            'feature'        => $this->data['user_feature'] ?? null,
            'event'          => $this->data['feature_event'] ?? null,
            'created_by'     => auth()->id(),
        ]);

        Notification::make()
            ->success()
            ->title('Feature event applied')
            ->body('The user feature event was submitted successfully.')
            ->send();
    }
}
