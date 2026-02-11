<?php
namespace App\Model;

use \Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Model\UserSign\UserSign;

    protected $table = 'applications';
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

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function families()
    {
        return $this->belongsToMany('App\Model\Family', 'applications_families')->using('App\Model\ApplicationFamily');
    }

    public function links()
    {
        return $this->hasMany('App\Model\ApplicationLink');
    }
}