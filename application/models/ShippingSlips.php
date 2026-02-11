<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingSlips extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shippings_slips';

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

    public $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'shippings_orders', 'entity_id')
            ->where('resource_type', self::class)
            ->withPivot('id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function institut()
    {
        return $this->belongsTo(Institut::class);
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
        return config_item('data_document_path') . '/shipping_slips/' . $this->filename;
    }
}
