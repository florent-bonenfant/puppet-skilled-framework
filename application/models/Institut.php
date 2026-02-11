<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Institut extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'instituts';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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

    public function times()
    {
        return $this->hasMany('App\Model\InstitutTime');
    }

    public function files()
    {
        return $this->hasMany('App\Model\InstitutFile');
    }

    public function statistics()
    {
        return $this->hasMany('App\Model\Statistic');
    }

    public function affectedBy()
    {
        return [
            'App\Service\Secure\Resource\Customer' => function ($resource, $query) {
                $resources = $resource->getResources();
                $query->whereIn('customer_id', $resources);
            }
        ];
    }
}
