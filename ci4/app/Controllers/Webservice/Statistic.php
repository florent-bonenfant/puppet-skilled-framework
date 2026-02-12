<?php

namespace App\Controllers\Webservice;

use \App\Model\Statistic as StatisticModel;
use App\Model\Institut as InstitutModel;

class Statistic extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {get} /statistic/{$year}/{$month}       Get all statistics for a given month of year
     * @apiName statisticMonth
     * @apiGroup Statistic
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Statistic list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function month($year, $month)
    {
        $stats = $this->customer->Instituts()
                                ->where('status', 0)
                                ->with([
                                    'statistics' => function ($query) use ($year, $month) {
                                        $query->where('year', $year)
                                            ->where('month', $month)
                                            ->orderBy('code', 'ASC');
                                    }
                                ])->get();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'year' => $year,
                'month' => $month,
                'instituts' => $stats,
            ],
        ]);
    }

    /**
     * @api {get} /statistic/last       Get all statistics for the most recent record
     * @apiName statisticLast
     * @apiGroup Statistic
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Statistic list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function last()
    {
        $institut = $this->customer->Instituts()->where('status', 0);
        if (empty($institut)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'STATISTICS_NOT_FOUND',
            ]);
        }

        $institut = $institut->first();
        if ($institut) {
            $institut = $institut->statistics()->first();
        }
        if (!empty($institut)) {
            $year = $institut->year;
            $month = $institut->month;
        } else {
            $year = date('Y');
            $month = date('m');
        }

        $stats = $this->customer->Instituts()
                                ->where('status', 0)
                                ->with([
                                    'statistics' => function ($query) use ($year, $month) {
                                        $query->where('year', $year)
                                            ->where('month', $month)
                                            ->orderBy('code', 'ASC');
                                    }
                                ])->get();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'year' => $year,
                'month' => $month,
                'instituts' => $stats,
            ]
        ]);
    }
}
