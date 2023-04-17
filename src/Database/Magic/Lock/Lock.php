<?php
namespace Globalis\PuppetSkilled\Database\Magic\Lock;

use Carbon\Carbon;

class Lock extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locks';

    /**
     * Action executor user model.
     *
     * @var string
     */
    protected static $userModel;

    /**
     * Allow mass assignement.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'expired_at',
        'created_at',
    ];

    public $timestamps = false;

    protected $dates = ['expired_at', 'created_at'];

    /**
     * {@inheritdoc}
     */
    public static function boot()
    {
        parent::boot();

        // Make it read-only
        static::updating(function () {
            return false;
        });
    }

    /**
     * Revision belongs to User (action Executor).
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function executor()
    {
        return $this->belongsTo(static::$userModel, 'user_id');
    }

    /**
     * Lock morphs to models in locked_type.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function locked()
    {
        return $this->morphTo('locked', 'locked_type', 'locked_id');
    }

    public static function gc()
    {
        static::where('expired_at', '<', Carbon::now())->delete();
    }
}
