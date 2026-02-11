<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;

class Commercial_condition extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;
    /**
     * @api {get} /commercial_condition    Get all commercial conditions
     * @apiName commercial_conditionAll
     * @apiGroup Commercial_condition
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         commercial conditions  list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        // dédoublonnage a effectuer
        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $this->customer->commercialConditions
        ]);
    }

    /**
     * @api {get} /commercial_condition/{id}  Get one commercial condition
     * @apiName commercial_conditionOne
     * @apiGroup Commercial_condition
     * @apiVersion 1
     *
     * @apiParam {id}       commercial_condition_id         Message ID
     *
     * @apiSuccess (200)    {result}       result       Selected commercial condition
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function one($id = null)
    {
        if (!$res = $this->customer->CommercialCondition()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'COMMERCIAL_CONDITION_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res
        ]);
    }

    /**
     * @api {get} /commercial_condition/{id}/file  Get one commercial condition file
     * @apiName commercial_conditionDownloadOne
     * @apiGroup Commercial_condition
     * @apiVersion 1
     *
     * @apiParam {id}       commercial_condition_id         CommercialCondition ID
     *
     * @apiSuccess (200)    {result}       result       Document of Selected commercial condition
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function download_one($id = null)
    {
        if (!$res = $this->customer->CommercialCondition()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'COMMERCIAL_CONDITION_NOT_FOUND'
            ]);
        }

        if (!$res->document || !is_file(config_item('data_document_path').'/commercial_conditions/'.$res->document)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'COMMERCIAL_CONDITION_FILE_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'filename' => $res->document,
                'filedata' => base64_encode(file_get_contents(config_item('data_document_path').'/commercial_conditions/'.$res->document))
            ]
        ]);
    }

    /**
     * @api {get} commercial_condition/all_current       Get current commercial condition
     * @apiName commercial_conditionAll_current
     * @apiGroup Commercial_condition
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         commercial condition list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all_current()
    {
        $res = $this->customer->CommercialCondition()
                    ->where('publication_date', '<=', Carbon::now())
                    ->where(function($query) {
                        $query->where('end_publication_date', '>=', Carbon::now())
                              ->orWhere('end_publication_date', null);
                    })
                    ->orderBy('publication_date', 'DESC');

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res->get()
        ]);
    }
}
