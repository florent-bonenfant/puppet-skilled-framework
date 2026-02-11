<?php
namespace App\Model\UserSign;

trait UserSign
{
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootUserSign()
    {
        static::observe(Listener::class);
    }

    public function creator()
    {
        return $this->belongsTo('App\Model\User', $this->getCreatedByColumn(), 'id');
    }

    public function updator()
    {
        return $this->belongsTo('App\Model\User', $this->getUpdatedByColumn(), 'id');
    }

    /**
     * Get the name of the "updated by" column.
     *
     * @return string
     */
    public function getUpdatedByColumn()
    {
        return defined('static::UPDATED_BY') ? static::UPDATED_BY : 'updated_by';
    }

    /**
     * Get the name of the "created by" column.
     *
     * @return string
     */
    public function getCreatedByColumn()
    {
        return defined('static::CREATED_BY') ? static::CREATED_BY : 'created_by';
    }
}
