<?php
namespace App\Job;

use Carbon\Carbon;

class ImportSupport extends \App\Job\Import
{
    protected $source_file_pattern = '/representant_([0-9]{8})\.txt$/';
    protected $model = '\App\Model\CustomerSupport';

    protected $map = [
        'id'           => 'code',
        'name'         => 'nom_representant',
    ];
}
