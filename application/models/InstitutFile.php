<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InstitutFile extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'institut_files';

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


    public function institut()
    {
        return $this->belongsTo('App\Model\Institut');
    }
}
