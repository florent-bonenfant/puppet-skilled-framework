<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {get} /notification      Get all notifications
     * @apiName notificationAll
     * @apiGroup Notification
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Notification list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     */
    public function all()
    {
        $notifications = [];

        foreach ($this->customer->notifications()->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get() as $item) {
            $title = preg_replace(
                array_map(function ($e) {
                    return '/{{'.$e.'}}/';
                }, array_keys($item->data)),
                array_values($item->data),
                $item->contentTranslation->title->value
            );

            $content = preg_replace(
                array_map(function ($e) {
                    return '/{{'.$e.'}}/';
                }, array_keys($item->data)),
                array_values($item->data),
                $item->contentTranslation->content->value
            );

            $notifications[] = [
                'id' => $item->id,
                'customerId' => $item->customer_id,
                'title' => $title,
                'content' => $content,
                'date' => $item->created_at->format('Y-m-d H:i:s'),
                'read' => ($item->read == "1")
            ];
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $notifications
        ]);
    }

    /**
     * @api {get} /notification/{id}      Update notification
     * @apiName notificationEditOne
     * @apiGroup Notification
     * @apiVersion 1
     *
     * @apiParam {id}       id         Notification ID
     * @apiParam {read}     read       Is the notification read
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Bad request.
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Unknown notification.
     */
    public function edit_one($id)
    {
        if (!$this->input->post('read')) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'BAD_REQUEST'
            ]);
        }

        if (!$notification = $this->customer->notifications()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'UNKNOWN_NOTIFICATION'
            ]);
        }

        $notification->read = ($this->input->post('read') ? 1 : 0);
        $notification->save();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK'
        ]);
    }

    /**
     * @api {post} /notification/mark_all_as_read    Mark all notifications of 
     * current customer as read
     * @apiName notificationMarkAllAsRead
     * @apiGroup Notification
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Notification list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     */
    public function mark_all_as_read()
    {

        $notifications = $this->customer->notifications()->where('read', '=', 0)->get();

        foreach ($notifications as $notification) {
            $notification->read = 1;
            $notification->save();
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK'
        ]);
    }
}
