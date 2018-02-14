<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SocialFacebookAccount
 *
 * @property int $user_id
 * @property string $provider_user_id
 * @property string $provider
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SocialFacebookAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SocialFacebookAccount whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SocialFacebookAccount whereProviderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SocialFacebookAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SocialFacebookAccount whereUserId($value)
 * @mixin \Eloquent
 */
class SocialFacebookAccount extends Model
{
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}