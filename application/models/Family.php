<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    const CONTENT_TYPE = 'family';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'families';

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
    public $timestamps = false;

    public function customers()
    {
        return $this->hasMany('App\Model\Customer');
    }


    /**
     * Uses content model for translations
     */
    public function content()
    {
        return $this->belongsTo('App\Service\Content\ContentModel', 'slug');
    }

    public function getNameAttribute()
    {
        foreach ($this->content->translations as $translation) {
            if ($translation->local == config_item('language')) {
                return $translation->title;
            }
        }
        return null;
    }

    public function saveTranslations(array $translations = [])
    {
        if (isset($this->content->translations)) {
            // update translations
            foreach ($this->content->translations as $translation) {
                foreach ($translations as $lang => $value) {
                    if ($translation->local == $lang) {
                        $translation->title = $value;
                        $translation->save();
                    }
                }
            }
        } else {
            // insert translations
            $this->content_slug = $this->slug;

            $content = new \App\Service\Content\ContentModel();
            $content->slug = $this->content_slug;
            $content->type = $this::CONTENT_TYPE;
            $content->title_key = 'lang:' . $this->content_slug;
            $content->active = 1;
            $content->save();

            foreach ($translations as $lang => $value) {
                $translation = new \App\Service\Content\ContentTranslationModel();
                $translation->content_slug = $this->content_slug;
                $translation->local = $lang;
                $translation->title = $value;
                $translation->save();
            }
        }
    }
}
