<?php

namespace App\Models;

use Illuminate\Support\Carbon;

/**
 * @property int $tag_id
 * @property int $taggable_id
 * @property string $taggable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Taggable extends BaseMorphPivot
{
    protected $table = 'taggables';

    public $incrementing = false;
}
