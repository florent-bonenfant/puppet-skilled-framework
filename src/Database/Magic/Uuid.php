<?php

namespace Globalis\PuppetSkilled\Database\Magic;

use Ramsey\Uuid\Uuid as UuidGenerate;

trait Uuid
{

    /**
     * Boot the trait for a model.
     */
    protected static function bootUuidTrait()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = UuidGenerate::uuid4()->toString();
            }
        });
    }

    /**
     * Insert the given attributes and set the ID on the model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $attributes
     * @return void
     */
    protected function insertAndSetId(\Illuminate\Database\Eloquent\Builder $query, $attributes)
    {
        $id = UuidGenerate::uuid4()->toString();
        $attributes[$keyName = $this->getKeyName()] = $id;

        $query->insert($attributes);
        $this->setAttribute($keyName, $id);
    }

    /**
     * Generate UUID v4
     *
     * @param  boolean $trim
     * @return string
     */
    public function generateUuid()
    {
        $format = '%04x%04x-%04x-%04x-%04x-%04x%04x%04x';

        return sprintf(
            $format,
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    public function sync($ids)
    {
        if ($this->getKeyName() === 'id') {
            $this->syncWithPivotValues($ids, [ 'id' => Uuid::uuid4()->toString() ]);
        } else {
            $this->sync($ids);
        }
    }
}
