<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Application extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {get} /application  Get all the applications for a given company
     * @apiName applicationAll
     * @apiGroup Application
     * @apiVersion 1
     *
     * @apiSuccess (200)    {result}       result       Array of applications
     *
     */
    public function all()
    {
        $applications = $this->customer->Application()->with([
            'links' => function ($query) {
                $query->where('company_id', $this->customer->company_id);
            }
        ])->get();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $applications,
        ]);
    }
}
