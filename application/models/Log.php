<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $dates = ['created_at'];

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }

    public function admin()
    {
        return $this->belongsTo('App\Model\User', 'admin_id');
    }

    public function family()
    {
        return $this->belongsTo('App\Model\Family');
    }

    public function company()
    {
        return $this->belongsTo('App\Model\Company');
    }
}
