<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];
    public function rank(){
        return $this->hasMany('App\Rank');
    }
}
