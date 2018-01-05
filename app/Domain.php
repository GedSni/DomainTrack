<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Domain
 *
 * @property int $id
 * @property string $name
 * @property int|null $day_rank
 * @property int|null $day_diff
 * @property string|null $day_update_date
 * @property int|null $week_rank
 * @property int|null $week_diff
 * @property string|null $week_update_date
 * @property int|null $month_rank
 * @property int|null $month_diff
 * @property string|null $month_update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rank[] $rank
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereDayDiff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereDayRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereDayUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereMonthDiff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereMonthRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereMonthUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereWeekDiff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereWeekRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain whereWeekUpdateDate($value)
 * @mixin \Eloquent
 */
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
