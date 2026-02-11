<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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

    protected $casts = [
        'allow_email' => 'integer',
        'allow_notification' => 'integer',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    protected $nonRevisionable = [
        'session_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the roles record associated with the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Model\Role', 'users_roles')->using('App\\Model\\UsersRoles');
    }

    public function rolesDefault()
    {
        $relation = 'id';

        $instance = new Role();

        $foreignKey = $this->getForeignKey();

        $relatedKey = $instance->getForeignKey();

        $relation = new BelongsToMany(
            $instance->default(), $this, 'users_roles', $foreignKey, $relatedKey, $this->primaryKey, $relation
        );
        return $relation->using('App\\Model\\UsersRoles');
    }

    public function rolesModule()
    {
        $relation = 'id';

        $instance = new Role();

        $foreignKey = $this->getForeignKey();

        $relatedKey = $instance->getForeignKey();

        $relation = new BelongsToMany(
            $instance->where('type', Role::TYPE_MODULES), $this, 'users_roles', $foreignKey, $relatedKey, $this->primaryKey, $relation
        );
        return $relation->using('App\\Model\\UsersRoles');
    }

    public function customers()
    {
        return $this->belongsToMany('App\Model\Customer', 'users_roles')->withPivot('id');
    }

    public function scopeVisible($query)
    {
        return $query->where('visible', 1);
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getModulesAttribute()
    {
        $role = $this->rolesModule;
        return isset($role[0]) ? $role[0]->permissions : [];
    }

    public function saveModules($modules)
    {
        $modules = array_filter($modules);
        if (!empty($modules)) {
            // Create new role
            $role = new Role();
            $role->slug = Role::SLUG_MANAGER;
            $role->type = Role::TYPE_MODULES;
            $role->save();
            $this->roles()->attach($role->id);

            // Save module permissions
            foreach ($modules as $module) {
                $permission = new Permissions();
                $permission->role_id = $role->id;
                $permission->permission_name = $module;
                $permission->save();
            }
        }
    }

    public function saveDelegateModules($modules, $customer_id)
    {
        $modules[] = 'webservice.log';
        $modules = array_unique(array_filter($modules));
        if (!empty($modules)) {
            if (!$role = $this->roles()->wherePivot('customer_id', $customer_id)->where('slug', Role::SLUG_DELEGATE)->first()) {
                // Create new role
                $role = new Role();
                $role->slug = Role::SLUG_DELEGATE;
                $role->type = Role::TYPE_MODULES;
                $role->save();
                $this->roles()->attach($role->id, ['customer_id' => $customer_id]);
            }

            // Save module permissions
            foreach ($modules as $module) {
                if (Permissions::where('role_id', $role->id)->where('permission_name', $module)->first()) {
                    continue;
                }
                try {
                    $permission = new Permissions();
                    $permission->role_id = $role->id;
                    $permission->permission_name = $module;
                    $permission->save();
                } catch (\Exception $e) {
                    //
                }
            }
        }
    }

    /**
     * Set the user's email
     *
     * @param  string  $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['username'] = $value;
        $this->attributes['email'] = $value;
    }

    /**
     * Set the user's password
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Set the user's datetime format
     *
     * @param string $value
     * @return void
     */
    public function setDatetimeFormatAttribute($value)
    {
        $this->attributes['datetime_format'] = $value;
        $this->attributes['date_format'] = get_date_format_from_datetime_format($value);
    }

    /**
      * Validate a user against the given password.
      *
      * @param  string  $password
      * @return bool
      */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->attributes['password']);
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->username;
    }
}
