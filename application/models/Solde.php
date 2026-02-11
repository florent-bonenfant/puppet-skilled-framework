<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Solde extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'soldes';

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
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at',];


    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }

    public function company()
    {
        return $this->belongsTo('App\Model\Company');
    }
}
