<?php

namespace App\Revisions;

use App\Models\Revision;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Job to create a revision entry for a revisionable model.
 */
class CreateRevisionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * The revisionable model instance.
     */
    protected Model $revisionable;

    /**
     * Organization identifier.
     */
    protected ?int $organizationId;

    /**
     * User identifier.
     */
    protected ?int $userId;

    /**
     * Dispatched timestamp in 'Y-m-d H:i:s.u' format.
     */
    protected string $dispatchedAt;

    /**
     * Revision data attributes.
     */
    protected array $attributes;

    /**
     * Create a new job instance.
     *
     * @param Model $revisionable
     * @param string $dispatchedAt
     * @param array $attributes
     * @param int|null $organizationId
     * @param int|null $userId
     */
    public function __construct(
        Model  $revisionable,
        string $dispatchedAt,
        array  $attributes = [],
        ?int   $organizationId = null,
        ?int   $userId = null
    )
    {
        $this->revisionable = $revisionable;
        $this->organizationId = $organizationId;
        $this->userId = $userId;
        $this->dispatchedAt = $dispatchedAt;
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $revision = $this->makeRevision();
        $revision->revisionable()->associate($this->revisionable);
        $revision->save();
    }

    /**
     * Instantiates a Revision model with provided data.
     *
     * @return Revision
     */
    private function makeRevision(): Revision
    {
        return new Revision([
            'created_at' => $this->dispatchedAt,
            'organization_id' => $this->organizationId,
            'user_id' => $this->userId,
            'data' => $this->attributes,
        ]);
    }
}
