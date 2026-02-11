<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApplicationLink extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    protected $table = 'applications_links';
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

    protected $dates = ['created_at', 'updated_at'];

    public function Application()
    {
        return $this->belongsTo('App\Model\Application');
    }

    public function Company()
    {
        return $this->belongsTo('App\Model\Company');
    }
}