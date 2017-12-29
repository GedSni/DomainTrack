<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = [
        'name',
        'day_rank',
        'day_diff',
        'day_update_date',
        'week_rank',
        'week_diff',
        'week_update_date',
        'month_rank',
        'month_diff',
        'month_update_date'
    ];
    public function rank(){
        return $this->hasMany('App\Rank');
    }
}
