<?php
namespace App\Job;

use \App\Model\Institut as InstitutModel;
use Carbon\Carbon;

class ImportStatistics extends \App\Job\Import
{
    protected $source_file_pattern = '/statistiques_([0-9]{8})\.txt$/';
    protected $model = '\App\Model\Statistic';
    protected $compare = ['institut_id', 'year', 'month', 'code'];

    protected $map = [
        'institut_id' => 'code_institut',
        'year' => 'annee',
        'month' => 'mois',
        'code' => 'code_indicateur',
        'label' => 'libelle_indicateur',
        'value' => 'valeur',
        'average' => 'moyenne',
        'quartile' => 'quartile_sup',
    ];

    protected function buildRow($row)
    {
        $institut = InstitutModel::where('id', $row['code_institut'])->first();

        if (!$institut) {
            $this->message_log('ERROR', $row['code_institut'] . ' (code : ' . $row['code_indicateur'] . ') : the institute does not exists');
            return false;
        }

        $row['valeur'] = str_replace(',', '.', $row['valeur']);
        $row['moyenne'] = str_replace(',', '.', $row['moyenne']);
        $row['quartile_sup'] = str_replace(',', '.', $row['quartile_sup']);

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // output
        $element = 'Institut n°' . $item->institut_id . ' / Statistic code n°' . $item->code;

        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }
}
