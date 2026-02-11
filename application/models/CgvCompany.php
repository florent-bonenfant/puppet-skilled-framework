<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CgvCompany extends Pivot
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    protected $table = 'cgvs_companies';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
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
    public $timestamps = false;
    protected $dates = ['created_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo('App\Model\Company');
    }

    public function cgv()
    {
        return $this->belongsTo('App\Model\Cgv');
    }
}
