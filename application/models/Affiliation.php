<?php

namespace App\Model;

use \Illuminate\Database\Eloquent\Model;

class Affiliation extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Model\UserSign\UserSign;

    protected $table = 'affiliations';
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

    protected $dates = [
        'created_at',
        'updated_at',
        'display_start',
        'display_end'
    ];

    public function families()
    {
        return $this->belongsToMany(Family::class, 'affiliation_families')->using(AffiliationFamily::class);
    }
}
