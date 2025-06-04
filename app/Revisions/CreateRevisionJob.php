<?php

namespace App\Revisions;

use App\Models\Revision;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateRevisionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected Model $model;
    protected ?int $userId;
    protected string $dispatchedAt;
    protected array $revisionData;

    /**
     * Create a new job instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  int|string|null  $userId
     * @param  string $dispatchedAt
     * @param  array $revisionData  // keys: attribute, value
     */
    public function __construct(Model $model, $userId = null, string $dispatchedAt, array $revisionData = [])
    {
        $this->model = $model;
        $this->userId = $userId;
        $this->dispatchedAt = $dispatchedAt;
        $this->revisionData = $revisionData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->revisionData as $attribute => $value) {
            Revision::create([
                'created_at'             => $this->dispatchedAt,
                'user_id'                => $this->userId,
                'revisionable_type'      => get_class($this->model),
                'revisionable_id'        => $this->model->getKey(),
                'revisionable_attribute' => $attribute,
                'data'                   => $value,
            ]);
        }
    }
}
