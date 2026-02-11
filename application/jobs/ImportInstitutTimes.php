<?php
namespace App\Job;

use \App\Model\Customer as CustomerModel;
use \App\Model\Institut as InstitutModel;
use \App\Model\InstitutTime as InstitutTimeModel;
use Carbon\Carbon;

class ImportInstitutTimes extends \App\Job\Import
{
    protected $source_file_pattern = '/horaires_(.*)\.txt$/';
    protected $model = '\App\Model\InstitutTimes';
    protected $compare = ['customer_id', 'name'];
    protected $custom_import = true;

    protected $map = [
        'customer_id' => 'code_client_livre',
        'name' => 'enseigne',
        'address' => 'adresse1',
        'address2' => 'adresse2',
        'postcode' => 'code_postal',
        'city' => 'ville',
    ];

    protected $day_endings = [
        1 => 'lu',
        'ma',
        'me',
        'je',
        've',
        'sa',
        'di',
    ];

    protected function buildRow($row)
    {
        $institut = InstitutModel::where('id', $row['code_client_livre'])->first();

        if (!$institut) {
            $this->message_log('ERROR', $row['code_client_livre'] . ' (enseigne : ' . $row['enseigne'] . ') : the institute does not exists');
            return false;
        }

        return $row;
    }


    protected function getItem($row)
    {
        return InstitutModel::where('id', $row['code_client_livre'])->first();
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // output
        $element = 'Customer n°' . $item->customer_id . ' / Institut name : ' . $item->name;

        // Delete everything
        $item->Times()->delete();

        foreach ($this->day_endings as $day_of_week => $ending) {
            $horaires = $row['horaires' . $ending];
            if ($horaires === 'ferme') {
                continue;
            }

            $times = explode(',', $horaires);
            foreach ($times as $time) {
                list($from, $to) = explode('-', $time);

                $institut_time = new InstitutTimeModel();
                $institut_time->institut_id = $item->id;
                $institut_time->day_of_week = $day_of_week;
                $institut_time->start_time = $from;
                $institut_time->end_time = $to;
                $institut_time->save();
            }
        }

        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }
}
