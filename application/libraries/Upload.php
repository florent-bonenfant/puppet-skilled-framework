<?php
namespace App\Library;

require_once BASEPATH . 'libraries/Upload.php';

class Upload extends \CI_Upload
{
    protected $field = '';

    /**
     * Make original Upload lib instances-driven
     * one instance for each file field
     *
     * @param string $field [file field name]
     * @param array  $config [original Upload configuration array]
    */
    public function __construct($field, $config = array())
    {
        $this->field = $field;
        parent::__construct($config);
    }

    /**
     * Return the current field name
     *
     * @return string
    */
    public function get_field_name()
    {
        return $this->field;
    }

    /**
     * Perform the file upload
     *
     * @param    string    $field
     * @return    bool
    */
    public function do_upload($field = null)
    {
        if (!$field) {
            $field = $this->field;
        }

         /*
          * Allows do_upload() to be called as intended originally
          * serves as a double check in case the developper misses to call check_upload()
          */
        if (!$this->file_temp && !$this->check_upload($field)) {
            return false;
        }

         /*
          * Move the file to the final destination
          * To deal with different server configurations
          * we'll attempt to use copy() first. If that fails
          * we'll use move_uploaded_file(). One of the two should
          * reliably work in most environments
          */
        if (! @copy($this->file_temp, $this->upload_path.$this->file_name)) {
            if (! @move_uploaded_file($this->file_temp, $this->upload_path.$this->file_name)) {
                $this->set_error('upload_destination_error', 'error');
                return false;
            }
        }

         /*
          * Set the finalized image dimensions
          * This sets the image width/height (assuming the
          * file was an image). We use this information
          * in the "data" function.
          */
         $this->set_image_properties($this->upload_path.$this->file_name);

         return true;
    }

    /**
     * Check if the upload file exists
     *
     * @return boolean
     */
    public function upload_file_exists($field = null)
    {
        if (!$field) {
            $field = $this->field;
        }
        return !empty($_FILES[$field]['name']);
    }

    /**
     * Check if the file matches the configuration
     *
     * @param  string $field
     * @return bool
    */
    public function check_upload($field = null)
    {
        if (!$field) {
            $field = $this->field;
        }

        // Is $_FILES[$field] set? If not, no reason to continue.
        if (isset($_FILES[$field])) {
            $_file = $_FILES[$field];
        } // Does the field name contain array notation?
        elseif (($c = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $field, $matches)) > 1) {
            $_file = $_FILES;
            for ($i = 0; $i < $c; $i++) {
            // We can't track numeric iterations, only full field names are accepted
                if (($field = trim($matches[0][$i], '[]')) === '' or ! isset($_file[$field])) {
                    $_file = null;
                    break;
                }

                $_file = $_file[$field];
            }
        }

        if (! isset($_file)) {
            $this->set_error('upload_no_file_selected', 'debug');
            return false;
        }

        // Is the upload path valid?
        if (! $this->validate_upload_path()) {
        // errors will already be set by validate_upload_path() so just return FALSE
            return false;
        }

        // Was the file able to be uploaded? If not, determine the reason why.
        if (! is_uploaded_file($_file['tmp_name'])) {
            $error = isset($_file['error']) ? $_file['error'] : 4;

            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                    $this->set_error('upload_file_exceeds_limit', 'info');
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $this->set_error('upload_file_exceeds_form_limit', 'info');
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $this->set_error('upload_file_partial', 'debug');
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $this->set_error('upload_no_file_selected', 'debug');
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $this->set_error('upload_no_temp_directory', 'error');
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $this->set_error('upload_unable_to_write_file', 'error');
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $this->set_error('upload_stopped_by_extension', 'debug');
                    break;
                default:
                    $this->set_error('upload_no_file_selected', 'debug');
                    break;
            }

            return false;
        }

        // Set the uploaded data as class variables
        $this->file_temp = $_file['tmp_name'];
        $this->file_size = $_file['size'];

        // Skip MIME type detection?
        if ($this->detect_mime !== false) {
            $this->_file_mime_type($_file);
        }

        $this->file_type = preg_replace('/^(.+?);.*$/', '\\1', $this->file_type);
        $this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
        $this->file_name = $this->_prep_filename($_file['name']);
        $this->file_ext     = $this->get_extension($this->file_name);
        $this->client_name = $this->file_name;

        // Is the file type allowed to be uploaded?
        if (! $this->is_allowed_filetype()) {
            $this->set_error('upload_invalid_filetype', 'debug');
            return false;
        }

        // if we're overriding, let's now make sure the new name and type is allowed
        if ($this->_file_name_override !== '') {
            $this->file_name = $this->_prep_filename($this->_file_name_override);

            // If no extension was provided in the file_name config item, use the uploaded one
            if (strpos($this->_file_name_override, '.') === false) {
                $this->file_name .= $this->file_ext;
            } else {
                // An extension was provided, let's have it!
                $this->file_ext    = $this->get_extension($this->_file_name_override);
            }

            if (! $this->is_allowed_filetype(true)) {
                $this->set_error('upload_invalid_filetype', 'debug');
                return false;
            }
        }

        // Convert the file size to kilobytes
        if ($this->file_size > 0) {
            $this->file_size = round($this->file_size/1024, 2);
        }

        // Is the file size within the allowed maximum?
        if (! $this->is_allowed_filesize()) {
            $this->set_error('upload_invalid_filesize', 'info');
            return false;
        }

        // Are the image dimensions within the allowed size?
        // Note: This can fail if the server has an open_basedir restriction.
        if (! $this->is_allowed_dimensions()) {
            $this->set_error('upload_invalid_dimensions', 'info');
            return false;
        }

        // Sanitize the file name for security
        $this->file_name = $this->_CI->security->sanitize_filename($this->file_name);

        // Truncate the file name if it's too long
        if ($this->max_filename > 0) {
            $this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);
        }

        // Remove white spaces in the name
        if ($this->remove_spaces === true) {
            $this->file_name = preg_replace('/\s+/', '_', $this->file_name);
        }

        if ($this->file_ext_tolower && ($ext_length = strlen($this->file_ext))) {
        // file_ext was previously lower-cased by a get_extension() call
            $this->file_name = substr($this->file_name, 0, -$ext_length).$this->file_ext;
        }

        /*
         * Validate the file name
         * This function appends an number onto the end of
         * the file if one with the same name already exists.
         * If it returns false there was a problem.
         */
        $this->orig_name = $this->file_name;
        if (false === ($this->file_name = $this->set_filename($this->upload_path, $this->file_name))) {
            return false;
        }

        /*
         * Run the file through the XSS hacking filter
         * This helps prevent malicious code from being
         * embedded within a file. Scripts can easily
         * be disguised as images or other file types.
         */
        if ($this->xss_clean && $this->do_xss_clean() === false) {
            $this->set_error('upload_unable_to_write_file', 'error');
            return false;
        }

        return true;
    }


    public function get_errors()
    {
        return $this->error_msg;
    }

    public static function get_max_size_upload()
    {
      $value = ini_get('upload_max_filesize');
      $unit = strtolower(substr($value, -1, 1));
      $value = (int) $value;
      switch ($unit) {
          case 'g':
              $value *= 1000;
              // no break (cumulative multiplier)
          case 'm':
              $value *= 1000;
              // no break (cumulative multiplier)
          case 'k':
              $value *= 1000;
      }
      return $value;
    }
}
