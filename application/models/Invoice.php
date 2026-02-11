<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;

    protected $table = 'invoices';
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
    public $timestamps = false;
    protected $dates = ['date', 'created_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $trad_type = [
        'F2' => 'invoice_data_type_F2',
        'G2' => 'invoice_data_type_G2',
        'RA' => 'invoice_data_type_RA',
        'RF' => 'invoice_data_type_RF',
        'FV' => 'invoice_data_type_FV',
        'BV' => 'invoice_data_type_BV',
        'RE' => 'invoice_data_type_RE',
        'L2' => 'invoice_data_type_L2',
        '0S12' => 'invoice_data_type_0S12',
        'CO' => 'invoice_data_type_CO',
    ];

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

    public function lines()
    {
        return $this->hasMany('App\Model\InvoiceLine', 'invoice_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Model\Order', 'orders_invoices')->using('App\Model\OrderInvoice');
    }

    public function shippings()
    {
        return $this->belongsToMany('App\Model\Shipping', 'shippings_invoices')->using('App\Model\ShippingInvoice');
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
        return './' . config_item('data_document_path') . '/invoices/' . $this->file_name;
    }

    public function getLibelleDocumentType()
    {
        return lang($this->trad_type[$this->document_type]);
    }
}
