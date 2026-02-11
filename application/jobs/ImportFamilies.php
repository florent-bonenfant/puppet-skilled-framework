<?php
namespace App\Job;

class ImportFamilies extends \App\Job\Import
{
    protected $source_file_pattern = '/famille_client_([0-9]{8})\.txt$/';
    protected $model = '\App\Model\Family';
    protected $compare = 'slug';

    protected $map = [
        'slug'      => 'code',
    ];

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // save translations
        $item->saveTranslations([
            'french' => $row['libelle_famille_client'],
        ]);

        // output
        $element = $item->slug;
        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }
}
