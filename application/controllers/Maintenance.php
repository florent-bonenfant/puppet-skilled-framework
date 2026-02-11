<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;
use \App\Model\Maintenance as MaintenanceModel;

class Maintenance extends \App\Core\Controller\Webservice
{
    protected $isPublic = true;

    /**
     * @api {get} /maintenance/status Check if maintenance is ongoing
     * @apiName CheckMaintenance
     * @apiGroup Maintenance
     * @apiVersion 1.0.0
     *
     * @apiSuccess (200) {Boolean} isMaintenance Whether maintenance is ongoing
     * @apiSuccess (200) {String} message The maintenance message if ongoing
     */
    public function status()
    {
        $current_time = Carbon::now();
        $maintenance = MaintenanceModel::where(function ($query) use ($current_time) {
                $query->where('starts_on', '<=', $current_time)
                    ->orWhereNull('starts_on');
            })
            ->where(function ($query) use ($current_time) {
                $query->where('ends_on', '>=', $current_time)
                    ->orWhereNull('ends_on');
            })
            ->first();

        if ($maintenance) {
            $this->return(static::HTTP_OK, [
                'isMaintenance' => true,
                'message' => $maintenance->message,
                'starts_on' => $maintenance->starts_on,
                'ends_on' => $maintenance->ends_on,
            ]);
        } else {
            $this->return(static::HTTP_OK, [
                'isMaintenance' => false,
                'message' => 'No maintenance is currently ongoing.'
            ]);
        }
    }
}
