<?php

namespace App\Models;

class Tag extends BaseModel
{
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
