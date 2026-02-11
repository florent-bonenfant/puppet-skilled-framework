<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;
    /**
     * @api {get} /invoice      Get all invoices
     * @apiName invoiceAll
     * @apiGroup Invoice
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Invoices list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $this->customer->invoices()
                                              ->with('lines')
                                              ->with('shippings')
                                              ->with('orders')
                                              ->get()
        ]);
    }

    /**
     * @api {get} /invoice/{id}  Get one invoice
     * @apiName invoiceOne
     * @apiGroup Invoice
     * @apiVersion 1
     *
     * @apiParam {id}       invoice_id         Invoice ID
     *
     * @apiSuccess (200)    {result}       result       Selected invoice
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function one($id = null)
    {
        $res = $this->customer->invoices()
                              ->with('lines')
                              ->with('shippings')
                              ->with('orders')
                              ->find($id);

        if (!$res) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'INVOICE_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res
        ]);
    }

    /**
     * @api {get} /invoice/{id}/file  Get one invoice file
     * @apiName invoiceDownloadOne
     * @apiGroup Invoice
     * @apiVersion 1
     *
     * @apiParam {id}       invoice_id         Invoice ID
     *
     * @apiSuccess (200)    {result}       result       Selected invoice
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function download_one($id = null)
    {
        if (!$res = $this->customer->invoices()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'INVOICE_NOT_FOUND'
            ]);
        }

        if (!$res->file_name || !is_file(config_item('data_document_path').'/invoices/'.$res->file_name)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'INVOICE_FILE_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'filename' => $res->file_name,
                'filedata' => base64_encode(file_get_contents(config_item('data_document_path').'/invoices/'.$res->file_name))
            ]
        ]);
    }

    /**
     * @api {get} /invoice/last/{limit}       Get last invoices. Number of invoice defined by limit
     * @apiName invoiceLast
     * @apiGroup Invoice
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         invoice list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function last($limit)
    {
        if (!is_numeric($limit)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'INVOICE_NOT_FOUND'
            ]);
        }
        $res = $this->customer->invoices()
                    ->limit($limit)
                    ->orderBy('date', 'DESC');

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res->get()
        ]);
    }
}
