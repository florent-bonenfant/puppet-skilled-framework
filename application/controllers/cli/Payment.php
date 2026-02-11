<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \App\Model\Payment as PaymentModel;
use \Illuminate\Database\Query\Expression as Raw;

class Payment extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $payments = PaymentModel::CheckStatePayment()
            ->select('id')
            ->whereNotExists(function ($jobExist) {
                $jobExist->select('id')
                    ->from('jobs')
                    ->where('jobs.payload', 'LIKE', new Raw("(SELECT CONCAT('%',`payments`.`id`,'%'))"));
            })
            ->get();

        // Si le paiement match et qu'il n'est pas dans les jobs
        foreach ($payments as $payment) {
            $id = $payment->id;
            $job = new \App\Job\PaymentUpdate($id);
            $this->queueService->dispatch($job);
        }
    }
}
