<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;
class Message extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;
    /**
     * @api {get} /message       Get all messages
     * @apiName messageAll
     * @apiGroup Message
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Message list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $this->customer->messages

        ]);
    }

    /**
     * @api {get} /message/last/{limit}       Get last messages. Number of message defined by limit
     * @apiName messageLast
     * @apiGroup Message
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Message list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function last($limit)
    {
        if (!is_numeric($limit)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'MESSAGE_NOT_FOUND'
            ]);
        }
        $res = $this->customer->Message()
                    ->where('publication_date', '<=', Carbon::now())
                    ->where(function($query) {
                        $query->where('end_publication_date', '>=', Carbon::now())
                              ->orWhere('end_publication_date', null);
                    })
                    ->limit($limit)
                    ->orderBy('publication_date', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('order', 'DESC');

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $res->get()
        ]);
    }
}
