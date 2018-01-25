<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = [
        'domain_id',
        'date',
        'rank'
    ];
    public function domain(){
        return $this->belongsTo('App\Domain');
    }

    public $timestamps = false;
}