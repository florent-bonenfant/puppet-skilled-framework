<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersDelegates extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_delegates';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
}
