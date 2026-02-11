<?php
namespace App\Service\Export;

class ExportCustomer extends Export
{
    // Destination file name
    protected $dest_file = 'eone_client.txt';

    // Column delimiter
    protected $delimiter = '|';

    // Unique identifier position inside the destination file
    protected $id_pos = 0;

    // Map application column names to file column names
    protected $map = [
        'id' => 'Code client',
        'email' => 'Mail',
        'has_accepted_eula' => 'CGU acceptées'
    ];

    public function export($key, $data)
    {
        if (!is_file($filename = config_item('data_export_path').'/'.$this->dest_file)) {
            file_put_contents($filename, implode($this->delimiter, $this->map)."\r\n");
        }

        $this->exportLine($key, $data);
    }
}
