<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banner extends \App\Core\Controller\Webservice
{
    protected $isPublic = true;

    /**
     * @api {get} /banner
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Solde
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $result = $this->customer->Banners()->get();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $result,
        ]);
    }

    /**
     * @api {get} /banner/file  Get the company banner
     * @apiName bannerDownloadAuto
     * @apiGroup banner
     * @apiVersion 1
     *
     * @apiSuccess (200)    {result}       result       Banner
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function download_auto()
    {
        $result = null;
        if ($this->customer) {
            $result = $this->customer->Banners()
            ->where('company_id', $this->customer->company_id)
            ->whereNull('deleted_at')
            ->first();
        }

        if (!$result) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'FILE_NOT_FOUND'
            ]);
        }

        if (!$result->file_name || !is_file(config_item('data_document_path') . '/banners/' . $result->file_name)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'FILE_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'file_name' => $result->file_name,
                'filedata' => base64_encode(file_get_contents(config_item('data_document_path') . '/banners/' . $result->file_name)),
                'mime' => $result->mime
            ]
        ]);
    }
}
