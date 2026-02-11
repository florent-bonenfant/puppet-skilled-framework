<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;
    /**
     * @api {get} /order      Get all orders
     * @apiName orderAll
     * @apiGroup Order
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Order list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $this->customer->orders()
                                              ->with('lines')
                                              ->with([
                                                    'invoices' => function ($query) {
                                                        $query->with('shippings');
                                                    }
                                                ])
                                              ->get()
        ]);
    }

    /**
     * @api {get} /order/{id}  Get one order
     * @apiName orderOne
     * @apiGroup Order
     * @apiVersion 1
     *
     * @apiParam {id}       order_id         Order ID
     *
     * @apiSuccess (200)    {result}       result       Selected order
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function one($id)
    {
        $res = $this->customer->orders()
                              ->with('lines')
                              ->with([
                                    'invoices' => function ($query) {
                                        $query->with('shippings');
                                    }
                                ])
                              ->find($id);
        if (!$res) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'ORDER_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res
        ]);
    }


    /**
     * @api {get} /order/last/{limit}       Get last orders. Number of order defined by limit
     * @apiName orderLast
     * @apiGroup Order
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         order list
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
        $res = $this->customer->orders()
                    ->limit($limit)
                    ->orderBy('date', 'DESC');

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res->get()
        ]);
    }
}
