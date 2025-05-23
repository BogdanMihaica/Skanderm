<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends BaseModel
{
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function plan() : BelongsTo {
        return $this->belongsTo(Plan::class);
    }
}
