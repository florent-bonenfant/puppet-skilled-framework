<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    protected $table = 'maintenances';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $dates = ['created_at', 'start_on', 'end_on'];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }
}
