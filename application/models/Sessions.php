<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;

    protected $table = 'sessions';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function scopeUserSessions($query, $user, $withoutData = true)
    {
        if (is_object($user)) {
            $user = $user->getKey();
        }

        // Récupération sur une semaine
        return $query->where('timestamp', '<', time() - (3600 * 24 * 7))
            ->where(function ($query) use ($user, $withoutData) {
                $query->where('data', 'LIKE', "%$user%");
                if ($withoutData) {
                    $query->orWhere('data', 'LIKE', '');
                }
            });
    }

    public function scopeOldSessions($query) {
        return $query->where('timestamp', '<', time() - (3600 * 24 * 7));
    }
}
