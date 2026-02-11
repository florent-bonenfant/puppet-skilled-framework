<?php

namespace App\Model;

use \Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    const MAIL_SENT = 1;
    const MAIL_TO_SEND = 0;
    const LIMIT_ATTEMPT_FETCH_STATE = 10;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

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
    protected $hidden = [
        'stripe_id'
    ];


    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }

    public function creator()
    {
        return $this->belongsTo('App\Model\User', 'created_by');
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

    public function scopeCheckStatePayment($query)
    {
        $limitDate = Carbon::now()->subMinutes(2);
        return $query
            ->where('mail_send', self::MAIL_TO_SEND)
            ->where('attempts', '<', self::LIMIT_ATTEMPT_FETCH_STATE)
            ->where(function ($query) use ($limitDate) {
                // On retourne la ligne pour les premières requètes, sinon on attend
                $query->where('attempts', '<=', 1)
                    ->orWhere('updated_at', '<', $limitDate);
            });
    }
}
