<?php

namespace App\Controllers\Webservice;

class Contrat extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {get} /contrat
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Solde
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $result = $this->customer->contrats()
                                 ->where('company_id', '=', $this->customer->company_id)
                                 ->with('company')
                                 ->get();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $result,
        ]);
    }

    /**
     * @api {get} /contrat/{id}/file  Get one contrat file
     * @apiName contratDownloadOne
     * @apiGroup contrat
     * @apiVersion 1
     *
     * @apiParam {id}       contrat_id         contrat ID
     *
     * @apiSuccess (200)    {result}       result       Selected contrat
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function download_one($id = null)
    {
        if (!$res = $this->customer->contrats()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'CONTRAT_NOT_FOUND'
            ]);
        }

        if (!$res->file_name || !is_file(config_item('data_document_path').'/contrats/'.$res->file_name)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'CONTRAT_FILE_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'file_name' => $res->file_name,
                'filedata' => base64_encode(file_get_contents(config_item('data_document_path').'/contrats/'.$res->file_name))
            ]
        ]);
    }
}
