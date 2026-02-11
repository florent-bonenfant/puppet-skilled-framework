<?php
namespace App\Service\Notification;

use App\Service\Content\ContentTranslationModel;
use App\Service\Content\ContentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'read',
    ];

    public function getTitleAttribute()
    {
        return $this->contentTranslation->title->bind($this->data);
    }

    public function getContentAttribute()
    {
        return $this->contentTranslation->content->bind($this->data);
    }

    public function contentTranslation()
    {
        $foreignKey = 'content_slug';

        $instance = new ContentTranslationModel();

        $query = $instance->newQuery()->where('local', config_item('language'));

        $otherKey = 'content_slug';

        return new BelongsTo($query, $this, $foreignKey, $otherKey, 'content');
    }

    public function getDataAttribute($value)
    {
        return unserialize($value);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = serialize($value);
    }

    public function scopeSecure($query)
    {
        $query->where('user_id', app()->authenticationService->user()->getKey());
    }


    public function scopeUnRead($query)
    {
        $query->where('read', 0);
    }

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }
}
