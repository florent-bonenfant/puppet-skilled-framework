<?php
namespace App\Job;

use \App\Model\Company as CompanyModel;
use \App\Model\ExpiredDate as ExpiredDateModel;

class ImportExpiredDates extends \App\Job\Import
{
    protected $source_file_pattern = '/peremption_lot_article_([0-9]{8})\.txt$/';
    protected $document_dir_source = 'expired_dates';
    protected $model = '\App\Model\ExpiredDate';
    protected $compare = ['company_id', 'product_code', 'lot_number'];

    protected $map = [
        'company_id' => 'organisation_commerciale',
        'product_code' => 'code_produit',
        'lot_number' => 'numero_lot',
        'libelle_fr' => 'libelle_fr',
        'date_peremption' => 'date_peremption',
    ];

    protected $companies = [];

    public function __construct()
    {
        $companiesKeys = [
            'Guinot'    => '1000',
            'Mary Cohr' => '2000',
        ];
        foreach (CompanyModel::all() as $item) {
            $key = $companiesKeys[$item->name];
            $this->companies[$key] = $item->id;
        }
    }

    protected function buildRow($row)
    {
        if (!$row['organisation_commerciale']) {
            $this->message_log('ERROR', 'Organisation commerciale ' . $row['organisation_commerciale'] . ' inexistante');
            return false;
        }

        $row['organisation_commerciale'] = $this->companies[$row['organisation_commerciale']];

        if (!isset($row['date_peremption']) || empty($row['date_peremption']) || $row['date_peremption'] === 'null') {
            $row['date_peremption'] = null;
        }

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        if ($isUpdate) {
            $this->message_log('INFO', $item->product_code . '/' . $item->lot_number . ' updated');
        } else {
            $this->message_log('INFO', $item->product_code . '/' . $item->lot_number . ' added');
        }
    }

    public function before_set_data() {
        ExpiredDateModel::query()->delete();
    }
}
