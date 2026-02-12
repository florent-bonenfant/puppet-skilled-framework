<?php

namespace App\Controllers\Webservice;

class Cgv extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;
    /**
     * @api {get} /cgv      Get all cgv
     * @apiName cgvAll
     * @apiGroup Cgv
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Cgv list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $this->customer->cgvs
        ]);
    }

    /**
     * @api {get} /cgv/{id}  Get one cgv
     * @apiName cgvOne
     * @apiGroup Cgv
     * @apiVersion 1
     *
     * @apiParam {id}       cgv_id         Cgv ID
     *
     * @apiSuccess (200)    {result}       result       Selected cgv
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function one($id = null)
    {
        if (!$res = $this->customer->Cgv()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'CGV_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res
        ]);
    }

    /**
     * @api {get} /cgv/{id}/file  Get one cgv file
     * @apiName cgvDownloadOne
     * @apiGroup cgv
     * @apiVersion 1
     *
     * @apiParam {id}       cgv_id         Cgv ID
     *
     * @apiSuccess (200)    {result}       result       Document of Selected cgv
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function download_one($id = null)
    {
        if (!$res = $this->customer->Cgv()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'CGV_NOT_FOUND'
            ]);
        }

        if (!$res->document || !is_file(config_item('data_document_path').'/cgvs/'.$res->document)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'CGV_FILE_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'filename' => $res->document,
                'filedata' => base64_encode(file_get_contents(config_item('data_document_path').'/cgvs/'.$res->document))
            ]
        ]);
    }
}
