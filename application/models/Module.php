<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'modules';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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
    public $timestamps = false;


    /**
     * Uses content model for translations
     */
    public function content()
    {
        return $this->belongsTo('App\Service\Content\ContentModel', 'title_key');
    }

    public function getNameAttribute()
    {
        if (!isset($this->content->translations)) {
            return null;
        }
        foreach ($this->content->translations as $translation) {
            if ($translation->local == config_item('language')) {
                return $translation->title;
            }
        }
        return null;
    }

    public function getFrontPermissionModules()
    {
        return $this->where('front_permission', '<>', '')->get(['slug', 'front_permission']);
    }
}
