<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite extends Pivot
{
    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'domain_name'
    ];
}
