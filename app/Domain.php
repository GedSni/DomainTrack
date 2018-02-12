<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Domain
 *
 * @property int $id
 * @property string $name
 * @property int|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rank[] $rank
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Domain extends Model
{


    protected $primaryKey = 'name';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'status'
    ];

    public function rank()
    {
        return $this->hasMany('App\Rank');
    }

    public function favorited()
    {
        return (bool) Favorite::where('user_id', Auth::id())
            ->where('domain_name', $this->name)
            ->first();
    }
}
