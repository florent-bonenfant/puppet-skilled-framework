<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AffiliationFamily extends Pivot
{
    protected $table = 'affiliation_families';
    protected $keyType = 'string';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = false;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    public $incrementing = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    Public function affiliations()
    {
        return $this->belongsTo(Affiliation::class);
    }
}
