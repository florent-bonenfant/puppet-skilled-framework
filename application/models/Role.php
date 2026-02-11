<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    const ID_DEV = 'developer';
    const ID_ADMIN = 'administrator';
    const ID_MANAGER = 'manager';
    const ID_CUSTOMER = 'customer';

    const SLUG_DEV = 'role_developer';
    const SLUG_ADMIN = 'role_administrator';
    const SLUG_MANAGER = 'role_manager';
    const SLUG_CUSTOMER = 'role_customer';
    const SLUG_DELEGATE = 'role_delegate';

    const TYPE_DEFAULT = 'default';
    const TYPE_MODULES = 'modules';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

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

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany('App\Model\Users', 'users_roles')->withPivot('id');
    }

    public function permissions()
    {
        return $this->hasMany('App\Model\Permissions');
    }

    public function scopeDefault($query)
    {
        return $query->where('type', Role::TYPE_DEFAULT);
    }

    public function scopeSelectable($query)
    {
        return $query->where([
            ['slug', '!=', Role::SLUG_CUSTOMER],
            ['slug', '!=', Role::SLUG_DEV],
        ]);
    }

    /**
     * Get the role's resources.
     *
     * @param  string  $value
     * @return string
     */
    public function getResourcesSupportAttribute($value)
    {
        if (!$value) {
            return null;
        }
        return unserialize($value);
    }

    /**
     * Set the role's resources.
     *
     * @param  null|array  $value
     * @return string
     */
    public function setResourcesSupportAttribute($values)
    {
        if (is_array($values)) {
            $this->attributes['resources_support'] = serialize($values);
        } else {
            $this->attributes['resources_support'] = $values;
        }
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
        foreach ($this->content->translations as $translation) {
            foreach ($translations as $lang => $value) {
                if ($translation->local == $lang) {
                    $translation->title = $value;
                    $translation->save();
                }
            }
        }
    }
}
