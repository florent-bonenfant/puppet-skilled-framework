<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;

    protected $table = 'furnitures';

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
    protected $dates = ['initial_date', 'end_date', 'created_at'];

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

    public function affectedBy()
    {
        return [
            'App\Service\Secure\Resource\Customer' => function ($resource, $query) {
                $resources = $resource->getResources();
                $query->whereIn('customer_id', $resources);
            }
        ];
    }

    public function setFileNameAttribute($value)
    {
        if ($this->file_name && $this->file_name !== $value) {
            // Delete
            @unlink($this->documentPath());
        }
        $this->attributes['file_name'] = $value;
    }

    public function getUploadDir()
    {
        return './' . config_item('data_document_path') . '/furnitures/';
    }

    public function documentPath()
    {
        return  $this->getUploadDir() . $this->file_name;
    }

    public function __destruct()
    {
        if (!$this->exists && file_exists($this->documentPath())) {
            // Remove file
            @unlink($this->documentPath());
        }
    }
}
