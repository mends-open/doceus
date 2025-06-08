<?php

namespace App\Feature\Revision\Jobs;

use App\Feature\Revision\Models\Revision;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateRevision implements ShouldQueue
{
    use Dispatchable, Queueable;

    public array $revisionData;

    public ?Model $morphTarget;

    public function __construct(array $revisionData, ?Model $morphTarget = null)
    {
        $this->revisionData = $revisionData;
        $this->morphTarget = $morphTarget;
    }

    public function handle()
    {
        $revision = new Revision($this->revisionData);

        if ($this->morphTarget) {
            $revision->revisionable()->associate($this->morphTarget);
        }

        $revision->save();
    }
}
