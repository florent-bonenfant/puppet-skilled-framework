<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;

    protected $table = 'shippings';

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

    public function carrier()
    {
        return $this->hasOne(ShippingCarrier::class, 'id', 'carrier_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }

    public function institut()
    {
        return $this->belongsTo('App\Model\Institut');
    }

    public function invoices()
    {
        return $this->belongsToMany('App\Model\Invoice', 'shippings_invoices')->using('App\Model\ShippingInvoice');
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

    public function documentPath()
    {
        return './' . config_item('data_document_path') . '/shippings/' . $this->file_name;
    }
}
