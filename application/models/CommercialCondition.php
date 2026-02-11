<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use \App\Library\Upload;

class CommercialCondition extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Model\UserSign\UserSign;

    protected $table = 'commercial_conditions';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
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
    public $timestamps = true;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'publication_date', 'end_publication_date'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function companies()
    {
        return $this->belongsToMany('App\Model\Company', 'commercial_conditions_companies')->using('App\Model\CommercialConditionCompany');
    }

    public function families()
    {
        return $this->belongsToMany('App\Model\Family', 'commercial_conditions_families')->using('App\Model\CommercialConditionFamily');
    }

    public function setDocumentAttribute($value)
    {
        if ($this->document && $this->document !== $value) {
            // Delete
            @unlink($this->documentPath());
        }
        $this->attributes['document'] = $value;
    }

    public static function getUploadDir()
    {
        $path = './'.config_item('data_document_path') . '/commercial_conditions';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }

    public function documentPath()
    {
        return  $this->getUploadDir() . '/' . $this->document;
    }

    public function __destruct()
    {
        if (!$this->exists && file_exists($this->documentPath())) {
            // Remove file
            @unlink($this->documentPath());
        }
    }
}
