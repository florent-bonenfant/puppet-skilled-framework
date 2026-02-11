<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;

    protected $table = 'orders';
    // RI -> facture
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
    public $timestamps = true;
    protected $dates = ['date', 'created_at', 'updated_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }

    public function company()
    {
        return $this->belongsTo('App\Model\Company');
    }

    public function invoices()
    {
        return $this->belongsToMany('App\Model\Invoice', 'orders_invoices')->using('App\Model\OrderInvoice');
    }

    public function lines()
    {
        return $this->hasMany('App\Model\OrderLine', 'order_id', 'id');
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
