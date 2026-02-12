<?php

namespace App\Controllers\Webservice;

class Shipping extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;
    /**
     * @api {get} /shipping      Get all shippings
     * @apiName shippingAll
     * @apiGroup Shipping
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Shipping list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $this->customer->shippings()
                ->with([
                    'invoices' => function ($query) {
                        $query->with('orders');
                    },
                ])
                ->with('institut')
                ->get()
        ]);
    }

    /**
     * @api {get} /shipping/{id}  Get one shipping
     * @apiName shippingOne
     * @apiGroup Shipping
     * @apiVersion 1
     *
     * @apiParam {id}       shipping_id         Shipping ID
     *
     * @apiSuccess (200)    {result}       result       Selected shipping
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function one($id)
    {
        $res = $this->customer->shippings()
            ->with([
                'invoices' => function ($query) {
                    $query->with('orders');
                },
            ])
            ->with('institut')
            ->find($id);
        if (!$res) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'SHIPPING_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res
        ]);
    }

    /**
     * @api {get} /shipping/{id}/file  Get one shipping file
     * @apiName shippingDownloadOne
     * @apiGroup Invoice
     * @apiVersion 1
     *
     * @apiParam {id}       shipping_id         Invoice ID
     *
     * @apiSuccess (200)    {result}       result       Selected shipping
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function download_one($id = null)
    {
        if (!$res = $this->customer->shippings()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'SHIPPING_NOT_FOUND'
            ]);
        }

        if (!$res->file_name || !is_file(config_item('data_document_path') . '/shippings/' . $res->file_name)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'SHIPPING_FILE_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'filename' => $res->file_name,
                'filedata' => base64_encode(file_get_contents(config_item('data_document_path') . '/shippings/' . $res->file_name))
            ]
        ]);
    }


    /**
     * @api {get} /shipping/last/{limit}       Get last shippings. Number of shipping defined by limit
     * @apiName shippingLast
     * @apiGroup Shipping
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         shipping list
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
        $res = $this->customer->shippings()
            ->limit($limit)
            ->shippingBy('date', 'DESC');

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res->get()
        ]);
    }
}
