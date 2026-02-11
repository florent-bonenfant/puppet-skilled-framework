<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Model\UsersRoles;
use App\Model\Users;

class Customer extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;

    protected $table = 'customers';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $keyType = 'string';

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

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function family()
    {
        return $this->belongsTo('App\Model\Family');
    }

    public function company()
    {
        return $this->belongsTo('App\Model\Company');
    }

    public function support()
    {
        return $this->belongsTo('App\Model\CustomerSupport');
    }

    public function invoices()
    {
        return $this->hasMany('App\Model\Invoice');
    }

    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

    public function shippings()
    {
        return $this->hasMany('App\Model\Shipping');
    }

    public function shipping_slips()
    {
        return $this->hasMany('App\Model\ShippingSlips');
    }

    public function shipping_trackings()
    {
        return $this->hasMany('App\Model\ShippingTrackings');
    }

    public function furnitures()
    {
        return $this->hasMany('App\Model\Furniture');
    }

    public function instituts()
    {
        return $this->hasMany('App\Model\Institut');
    }

    public function notifications()
    {
        return $this->hasMany('App\Service\Notification\Model');
    }

    public function soldes()
    {
        return $this->hasMany('App\Model\Solde');
    }

    public function contrats()
    {
        return $this->hasMany('App\Model\Contrat');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getCommercialConditionsAttribute()
    {
       return CommercialCondition::whereHas('companies', function ($query) {
            $query->where('company_id', $this->company_id);
        })
        ->whereHas('families', function ($query) {
            $query->where('family_id', $this->family_id);
        })
        ->orderBy('publication_date', 'DESC')
        ->get();
    }

    public function CommercialCondition()
    {
        return CommercialCondition::whereHas('companies', function ($query) {
           $query->where('company_id', $this->company_id);
       })
       ->whereHas('families', function ($query) {
           $query->where('family_id', $this->family_id);
       });
    }

    public function getCgvsAttribute()
    {
       return Cgv::whereHas('companies', function ($query) {
           $query->where('company_id', $this->company_id);
       })
       ->whereHas('families', function ($query) {
           $query->where('family_id', $this->family_id);
       })
       ->orderBy('publication_date', 'DESC')
       ->orderBy('created_at', 'DESC')
       ->get();
    }

    public function Cgv()
    {
        return Cgv::whereHas('companies', function ($query) {
           $query->where('company_id', $this->company_id);
       })
       ->whereHas('families', function ($query) {
           $query->where('family_id', $this->family_id);
       });
    }

    public function Application()
    {
        return Application::whereHas('families', function ($query) {
           $query->where('family_id', $this->family_id);
        });
    }

    public function Affiliation()
    {
        return Affiliation::whereHas('families', function ($query) {
           $query->where('family_id', $this->family_id);
        });
    }

    public function getMessagesAttribute()
    {
       return Message::whereHas('companies', function ($query) {
           $query->where('company_id', $this->company_id);
       })
       ->whereHas('families', function ($query) {
           $query->where('family_id', $this->family_id);
       })
       ->orderBy('publication_date', 'DESC')
       ->orderBy('created_at', 'DESC')
       ->orderBy('order', 'DESC')
       ->get();

    }

    public function Message()
    {
        return Message::whereHas('companies', function ($query) {
           $query->where('company_id', $this->company_id);
       })
       ->whereHas('families', function ($query) {
           $query->where('family_id', $this->family_id);
       });
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullAddressAttribute()
    {
        return implode(' ', [$this->address, $this->address2, $this->zip, $this->city]);
    }

    public function affectedBy()
    {
        return [
            'App\Service\Secure\Resource\Customer' => function ($resource, $query) {
                $resources = $resource->getResources();
                $query->whereIn('id', $resources);
            }
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class, (new UsersRoles)->getTable());
    }


    public function Banners()
    {
        return Banner::whereNull('deleted_at');
    }

    public function scopeIsNotClosed($query)
    {
        return $query->where("{$this->table}.active", 1)
            ->where(function ($query) {
                $query->whereNull('closing_date')
                ->orWhere('closing_date', '>=', Carbon::now());
            });
    }
    public function scopeIsNotRestricted($query)
    {
        return $query->where(function ($query) {
                $query->whereNull('restrict_access_date')
                ->orWhere('restrict_access_date', '>=', Carbon::now());
            });
    }

    public function getIsClosedAttribute()
    {
        return (!empty($this->closing_date) && Carbon::now()->gte($this->closing_date)) || $this->active === 0;
    }

    public function getIsRestrictedAttribute()
    {
        return (!empty($this->closing_date) && Carbon::now()->gte($this->restrict_access_date));
    }
}