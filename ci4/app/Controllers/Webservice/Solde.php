<?php

namespace App\Controllers\Webservice;

class Solde extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {get} /solde
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Solde
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $result = $this->customer->soldes()
                                 ->where('company_id', '=', $this->customer->company_id)
                                 ->get(['amount']);

        if ($result) {
            $result = $result[0];
        }

        if (!$result) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'SOLDE_NOT_FOUND'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $result,
        ]);
    }
}