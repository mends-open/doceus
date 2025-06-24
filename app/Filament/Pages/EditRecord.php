<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Field;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord as BaseEditRecord;
use Filament\Schemas\Schema;
use Illuminate\Validation\ValidationException;
use Throwable;

class EditRecord extends BaseEditRecord
{
    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public function saveComponent(Field $component): void
    {
        $this->authorizeAccess();

        try {

            $this->beginDatabaseTransaction();

            $this->callHook('beforeValidate');

            $data = Schema::make($component->getLivewire())
                ->components([$component])
                ->model($component->getRecord())
                ->statePath($component->getContainer()->getStatePath())
                ->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeSave($data);

            $this->callHook('beforeSave');

            $this->handleRecordUpdate($component->getRecord(), $data);

            $this->callHook('afterSave');

            Notification::make();
        } catch (Throwable $e) {
            $this->rollBackDatabaseTransaction();
            throw $e;
        }

        $this->commitDatabaseTransaction();

    }
}
