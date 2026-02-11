<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Furniture extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;
    /**
     * @api {get} /furniture      Get all furnitures
     * @apiName furnitureAll
     * @apiGroup Furniture
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Furniture list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $this->return(200, [
            'resultCode' => 'OK',
            'resultContent' => $this->customer->furnitures()->get()
        ]);
    }

    /**
     * @api {get} /furniture/{id}/file  Get one furniture file
     * @apiName furnitureDownloadOne
     * @apiGroup Furniture
     * @apiVersion 1
     *
     * @apiParam {id}       furniture_id         Furniture ID
     *
     * @apiSuccess (200)    {result}       result       Selected furniture
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function download_one($id = null)
    {
        if (!$res = $this->customer->furnitures()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'FURNITURE_NOT_FOUND'
            ]);
        }

        if (!$res->file_name || !is_file(config_item('data_document_path').'/furnitures/'.$res->file_name)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'FURNITURE_FILE_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'filename' => $res->file_name,
                'filedata' => base64_encode(file_get_contents(config_item('data_document_path').'/furnitures/'.$res->file_name))
            ]
        ]);
    }
}
