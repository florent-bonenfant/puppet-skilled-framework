<?php

namespace App\Controllers\Webservice;

use App\Model\ShippingSlips;
use App\Model\Shipping;

class Shipping_slip extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;
    /**
     * @api {get} /shipping_slip      Get all shipping_slips
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
            'resultContent' => $this->customer->shipping_slips()
                ->with(['institut', 'orders', 'customer'])
                ->get()
        ]);
    }

    /**
     * @api {get} /shipping_slip/{id}  Get one shipping_slip
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
        $res = $this->customer->shipping_slips()
            ->with(['institut', 'orders', 'customer'])
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
     * @api {get} /shipping_slip/{id}/file  Get one shipping_slip file
     * @apiName shippingDownloadOne
     * @apiGroup Invoice
     * @apiVersion 1
     *
     * @apiParam {id}       shipping_slip_id         Invoice ID
     *
     * @apiSuccess (200)    {result}       result       Selected shipping_slip
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function download_one($id = null)
    {
        if (!$res = $this->customer->shipping_slips()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'SHIPPING_NOT_FOUND'
            ]);
        }

        if (!$res->filename || !is_file(config_item('data_document_path') . '/shipping_slips/' . $res->filename)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'SHIPPING_FILE_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'filename' => $res->filename,
                'filedata' => base64_encode(file_get_contents(config_item('data_document_path') . '/shipping_slips/' . $res->filename))
            ]
        ]);
    }


    /**
     * @api {get} /shipping_slip/last/{limit}       Get last shippings. Number of shipping defined by limit
     * @apiName shippingLast
     * @apiGroup Shipping
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         shipping_slip list
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
        $res = $this->customer->shipping_slips()
            ->limit($limit)
            ->shippingBy('date', 'DESC');

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res->get()
        ]);
    }
}
