<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use \Illuminate\Database\Eloquent\Model;

class ShippingOrder extends Pivot
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    protected $table = 'shippings_orders';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
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
    protected $dates = ['created_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    // public function order()
    // {
    //     return $this->belongsTo('App\Model\Order');
    // }

    // public function orders()
    // {
    //     return $this->belongToMany('App\Model\Order');
    // }
    // public function trackings()
    // {
    //     return $this->morph
    // }
    // public function entities()
    // {
    //     return $this->morphTo();
    //     // return $this->belongsTo('App\Model\Invoice');
    // }
}
