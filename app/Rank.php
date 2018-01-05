<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Rank
 *
 * @property int $id
 * @property int $domain_id
 * @property int|null $value
 * @property string|null $date
 * @property-read \App\Domain $domain
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank whereDomainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank whereValue($value)
 * @mixin \Eloquent
 */
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