<?php
namespace App\Model\UserSign;

class Listener
{

    /**
     * Handle creating event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function creating($model)
    {
        $model->{$model->getCreatedByColumn()} = $this->getCurrentUserId();
        $model->{$model->getUpdatedByColumn()} = $this->getCurrentUserId();
    }

    /**
     * Handle updating event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function updating($model)
    {
        $model->{$model->getUpdatedByColumn()} = $this->getCurrentUserId();
    }

    protected function getCurrentUserId()
    {
        $user = app()->authenticationService->user();
        return  $user? $user->getKey() : null;
    }
}
