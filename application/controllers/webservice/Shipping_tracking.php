<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shipping_tracking extends \App\Core\Controller\Webservice
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
            'resultContent' => $this->customer->shipping_trackings()
                ->with(['institut', 'orders', 'customer', 'carrier'])
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
        $res = $this->customer->shipping_trackings()
            ->with(['institut', 'orders', 'customer', 'carrier'])
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
        $res = $this->customer->shipping_trackings()
            ->limit($limit)
            ->shippingBy('date', 'DESC');

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res->get()
        ]);
    }
}
