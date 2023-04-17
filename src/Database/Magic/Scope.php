<?php
namespace Globalis\PuppetSkilled\Database\Magic;

interface Scope
{
    /**
     * Apply the scope to a given Magic query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Globalis\PuppetSkilled\Database\Magic\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);
}
