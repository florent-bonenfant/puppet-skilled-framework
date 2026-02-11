<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contrats';

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
    protected $dates = ['created_at', 'updated_at'];


    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }

    public function company()
    {
        return $this->belongsTo('App\Model\Company');
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
        return './' . config_item('data_document_path') . '/contrats/';
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
