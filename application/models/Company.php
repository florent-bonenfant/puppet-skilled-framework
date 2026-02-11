<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

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

    public function customers()
    {
        return $this->hasMany('App\Model\Customer');
    }

    public function expired_dates()
    {
        return $this->hasMany('App\Model\ExpiredDate');
    }
}
