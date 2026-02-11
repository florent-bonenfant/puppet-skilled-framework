<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;

class Affiliation extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {get} /affiliation  Get all the affiliations for a given company
     * @apiName affiliationAll
     * @apiGroup Affiliation
     * @apiVersion 1
     *
     * @apiSuccess (200)    {result}       result       Array of affiliations
     *
     */
    public function all()
    {
        $affiliations = $this->customer
            ->Affiliation()
            ->where('display_start', '<=', Carbon::now())
            ->where(function ($query) {
                $query->where('display_end', '>=', Carbon::now())
                    ->orWhere('display_end', null);
            })
            ->get();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $affiliations,
        ]);
    }
}
