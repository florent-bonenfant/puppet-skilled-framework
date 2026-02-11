<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ApplicationFamily extends Pivot
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    protected $table = 'application_families';
    protected $keyType = 'string';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = null;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
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

    public function family()
    {
        return $this->belongsTo('App\Model\Family');
    }

    public function Application()
    {
        return $this->belongsTo('App\Model\Application');
    }
}
