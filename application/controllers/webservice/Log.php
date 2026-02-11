<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \App\Model\Log as LogModel;
use \App\Model\User as UserModel;

class Log extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {post} /log  Create new log entry
     * @apiName logOne
     * @apiGroup Log
     * @apiVersion 1
     *
     * @apiSuccess (201)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Parameter error.
     */
    public function create_one()
    {
        if (!$slug = $this->input->post()['slug']) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'PARAMETER_ERROR'
            ]);
        }

        $log = new LogModel();
        $log->customer_id = $this->customer->id;
        $log->first_name = $this->customer->first_name;
        $log->last_name = $this->customer->last_name;
        $log->email = $this->customer->email;
        $log->city = $this->customer->city;
        $log->family_id = $this->customer->family_id;
        $log->company_id = $this->customer->company_id;
        $log->location_slug = $slug;
        if ($tokenAdmin = $this->input->post()['token_admin']) {
            $admin = UserModel::where('admin_token', $tokenAdmin)->first();
            $log->admin_id = $admin->getKey();
        }
        $log->save();

        $this->return(static::HTTP_CREATED, [
            'resultCode' => 'OK'
        ]);
    }
}
