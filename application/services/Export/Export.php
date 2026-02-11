<?php
namespace App\Service\Export;

class Export extends \Globalis\PuppetSkilled\Service\Base
{
    protected $dest_file = '';
    protected $delimiter = '|';
    protected $map = [];

    protected function exportLine($id, $data)
    {
        // Get file content
        $file_content = @file_get_contents(config_item('data_export_path').'/'.$this->dest_file);

        // Convert file content to array
        $rows = preg_split('/\r\n|\n|\r/', trim($file_content));
        $rows = array_map(function ($row) {
            return explode($this->delimiter, $row);
        }, $rows);

        // Try to find an existing row
        if (($index = $this->findRow($rows, $id)) !== -1) {
            // Edit the found row
            $rows = $this->editRow($rows, $index, $data);
        } else {
            // Add a new row
            $rows = $this->addRow($rows, $id, $data);
        }

        // Convert back row array to plain text
        $new_file_content =  array_map(function ($row) {
            return implode($this->delimiter, $row)."\r\n";
        }, $rows);

        // Save new content
        file_put_contents(config_item('data_export_path').'/'.$this->dest_file, $new_file_content);
    }

    private function findRow($rows, $id)
    {
        $found = false;
        $i = 0;
        do {
            if ($rows[$i][$this->id_pos] == $id) {
                $found = true;
            } else {
                $i++;
            }
        } while (!$found && isset($rows[$i]));

        return ($found ? $i : -1);
    }

    private function addRow($rows, $id, $data)
    {
        $new_row = array_fill(0, count($rows[0]), '');
        $new_row[$this->id_pos] = $id;

        foreach ($data as $app_key => $value) {
            $file_key = $this->map[$app_key];
            if ($key_pos = array_search($file_key, $rows[0])) {
                $new_row[$key_pos] = $value;
            }
        }

        $rows[] = $new_row;

        return $rows;
    }

    private function editRow($rows, $index, $data)
    {
        foreach ($data as $app_key => $value) {
            if (isset($this->map[$app_key])) {
                $file_key = $this->map[$app_key];
                if ($key_pos = array_search($file_key, $rows[0])) {
                    $rows[$index][$key_pos] = $value;
                }
            }
        }

        return $rows;
    }
}
