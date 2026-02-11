<?php
namespace App\Job;

use ZipArchive;
use Carbon\Carbon;

class Import extends \Globalis\PuppetSkilled\Queue\Queueable
{
    protected $source_file_pattern = null;
    protected $source_file = '';
    protected $delimiter = '|';
    protected $map = [];
    protected $model = '';
    protected $compare = 'id';
    protected $log_flux = null;
    protected $custom_import = false;
    protected $ignore_fields = [];

    public function handle()
    {
        // initializing log flux
        $this->init_log();

        if (!is_null($this->source_file_pattern)) {
            $files = [];
            $valid = false;
            foreach (glob(config_item('data_import_path').'/*.txt') as $filename) {
                if (preg_match($this->source_file_pattern, $filename)) {
                    // fetch data
                    $data = @file_get_contents($filename);

                    $info = finfo_open(FILEINFO_MIME_ENCODING);
                    $type = finfo_buffer($info, file_get_contents($filename));
                    finfo_close($info);
                    if ($type !== 'UTF-8') {
                        $data = mb_convert_encoding($data, 'UTF-8', $type);
                    }

                    if (!empty($data) && !empty($this->map)) {
                        // function before insertion
                        $this->before_set_data();
                        // insert into database
                        $rows = preg_split('/\r\n|\n|\r/', trim($data));
                        $keys = $this->normalize_csv_header(str_getcsv(array_shift($rows), $this->delimiter));

                        $valid = $this->is_valid_header($keys);
                        if ($valid === true) {
                            foreach ($rows as $k => $row) {
                                $row = $this->buildRow(array_combine($keys, str_getcsv($row, $this->delimiter)));
                                if (!is_array($row)) {
                                    continue;
                                }

                                if ($this->custom_import) {
                                    $item = $this->getItem($row);
                                    if ($item === false) {
                                        $file = basename($filename);
                                        $this->message_log('ERROR', $file . ' : ' . 'no item found.');
                                    } else {
                                        $this->callback($item, false, $row);
                                    }
                                } else {
                                    // retrieve existing row or create new one
                                    $isUpdate = true;
                                    $query = $this->model::query();

                                    foreach ((array)$this->compare as $col) {
                                        $query->where($col, $row[$this->map[$col]]);
                                    }

                                    if (!($item = $query->first())) {
                                        $item = new $this->model();
                                        $isUpdate = false;
                                    }

                                    // inject data using the map
                                    foreach ($this->map as $col => $key) {
                                        if (!in_array($col, $this->ignore_fields)) {
                                            $item->{$col} = $row[$key];
                                        }
                                    }

                                    try {
                                        $item->save();
                                    } catch (\Exception $e) {
                                        $file = basename($filename);
                                        $this->message_log('ERROR', $file . ' : ' . 'error on data line '. $k . ' please check the file.');
                                    }

                                    $this->callback($item, $isUpdate, $row);
                                }

                            }

                            $files[] = $filename;
                        } else {
                            $file = basename($filename);
                            foreach ($valid as $col_err) {
                                $this->message_log('ERROR', $file . ' : ' . $col_err . ' missing, please correct the file\'s header');
                            }
                            return false;
                        }
                    }
                }
            }
            if (!empty($files) && $valid === true) {
                $archive = new ZipArchive();
                if (!is_dir(config_item('import_archive_path'))) {
                    mkdir(config_item('import_archive_path'), 0777, true);
                }
                if ($archive->open(config_item('import_archive_path').'/import_eone_'.date('Ymd').'.zip', ZipArchive::CREATE)) {
                    foreach ($files as $f) {
                        $archive->addFile($f, basename($f));
                    }
                    $archive->close();
                    foreach ($files as $f) {
                        unlink($f);
                    }
                }
            }
        }

        if ($this->log_flux) {
            fclose($this->log_flux);
            $this->log_flux = null;
        }

        return true;
    }

    protected function buildRow($row)
    {
        return $row;
    }

    protected function getItem($row)
    {
        return false;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // output
        $element = $item->id;
        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }

    private function normalize_csv_header($keys)
    {
        app()->load->helper('text_helper');
        $return = [];
        foreach ($keys as $k) {
            $k = trim($k);
            $k = convert_accented_characters($k);
            $k = str_replace('-', ' ', $k);
            $i = 0;
            $count = 0;
            while ($count !== 0 && $i < 3) { // delete double spaces
                $i++;
                $k = str_replace('  ', ' ', $k, $count);
            }
            $k = str_replace(' ', '_', $k);
            $return[] = strtolower($k);

        }
        return $return;
    }

    private function is_valid_header($keys)
    {
        $error = [];
        $valid_keys = array_values($this->map);
        foreach($valid_keys as $vk) {
            if (!in_array($vk, $keys)) {
                $error[] = $vk;
            }
        }
        if (empty($error)) {
            return true;
        } else {
            return $error;
        }
    }

    protected function init_log()
    {
        // initializing log
        $log_path = config_item('import_log_path');
        if ($log_path) {
            if ((file_exists($log_path) || mkdir($log_path, 0755, TRUE)) && is_really_writable($log_path) ) {
                $out = $log_path . '/log-'.date('Y-m-d').'.txt';
            } else {
                throw new \Exception('Error in import log path, please, check the config');die;
            }
        } else {
            $out = 'php://output';
        }

        $this->log_flux = fopen($out, 'a');
    }

    protected function message_log($type, $message)
    {
        $msg = Carbon::now() . ' - ' . $type . ' - ' . get_class($this) . ' : ' . $message .PHP_EOL;
        fputs($this->log_flux, $msg);
    }

    protected function before_set_data()
    {
        return false;
    }
}
