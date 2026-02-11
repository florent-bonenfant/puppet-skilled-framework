<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Model\UserSign\UserSign;

    protected $table = 'messages';

    //const CONTENT_TYPE = 'message';

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
        return $this->belongsToMany('App\Model\Company', 'messages_companies')->using('App\Model\MessageCompany');
    }

    public function families()
    {
        return $this->belongsToMany('App\Model\Family', 'messages_families')->using('App\Model\MessageFamily');
    }
}
