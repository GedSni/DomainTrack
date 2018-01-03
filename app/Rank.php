<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = [
        'date',
        'value',
        'domain_id'
    ];
    public function domain(){
        return $this->belongsTo('App\Domain');
    }

    public $timestamps = false;
}