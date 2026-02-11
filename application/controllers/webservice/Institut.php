<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;
use App\Model\Institut as InstitutModel;
use App\Model\InstitutTime as InstitutTimeModel;
use App\Model\InstitutFile as InstitutFileModel;

class Institut extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {get} /institut
     * @apiName statisticMonth
     * @apiGroup Statistic
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         Institut list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $this->customer->instituts()
                                              ->where('status', 0)
                                              ->with([
                                                  'times' => function ($query) {
                                                      $query->orderBy('day_of_week', 'ASC')
                                                            ->orderBy('start_time', 'ASC');
                                                  }
                                              ])
                                              ->with('files')
                                              ->get(),
        ]);
    }

    /**
     * @api {get} /institut/{id}
     * @apiName statisticMonth
     * @apiGroup Statistic
     * @apiVersion 1
     *
     * @apiParam {id}       institut_id         Institut ID
     *
     * @apiSuccess (200)    {array}        result         Institut
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function one($id)
    {
        if (!$res = $this->customer->instituts()->where('status', 0)->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'INSTITUT_NOT_FOUND'
            ]);
        }

        $result = $this->customer->instituts()
                                 ->where('status', 0)
                                 ->with([
                                     'times' => function ($query) {
                                         $query->orderBy('day_of_week', 'ASC')
                                             ->orderBy('start_time', 'ASC');
                                     },
                                 ])
                                 ->with('files')
                                 ->find($id);

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $result,
        ]);
    }

    /**
     * @api {post} /institut/{id}  Update institut informations
     * @apiName institutUpdate
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {id}           institut_id         Institut ID
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Bad request.
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     */
    public function edit_one($id)
    {
        if (!$res = $this->customer->instituts()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'INSTITUT_NOT_FOUND'
            ]);
        }

        InstitutTimeModel::where('institut_id', $id)->delete();

        $time_table = $this->input->post();

        for ($i = 1; $i <= 7; $i++) {
            $morning_start = $time_table[$i . '_morning_start'] ?? '';
            $morning_end = $time_table[$i . '_morning_end'] ?? '';
            $afternoon_start = $time_table[$i . '_afternoon_start'] ?? '';
            $afternoon_end = $time_table[$i . '_afternoon_end'] ?? '';

            if (empty($morning_start) && empty($afternoon_start)) {
                continue;
            }

            if (empty($morning_end) && empty($afternoon_start)) {
                $time = new InstitutTimeModel();
                $time->institut_id = $id;
                $time->day_of_week = $i;
                $time->start_time = $morning_start;
                $time->end_time = $afternoon_end;
                $time->save();
            } else {
                if (!empty($morning_start) && !empty($morning_end)) {
                    $time_morning = new InstitutTimeModel();
                    $time_morning->institut_id = $id;
                    $time_morning->day_of_week = $i;
                    $time_morning->start_time = $morning_start;
                    $time_morning->end_time = $morning_end;
                    $time_morning->save();
                }

                if (!empty($afternoon_start) && !empty($afternoon_end)) {
                    $time_afternoon = new InstitutTimeModel();
                    $time_afternoon->institut_id = $id;
                    $time_afternoon->day_of_week = $i;
                    $time_afternoon->start_time = $afternoon_start;
                    $time_afternoon->end_time = $afternoon_end;
                    $time_afternoon->save();
                }
            }
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
        ]);
    }


    /**
     * @api {get} /institut/{id}/file  Retrieves the files from an institut
     * @apiName institutFileGet
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {id}           institut_id         Institut ID
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Bad request.
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Institut not found.
     */
    public function get_files($id)
    {
        if (!$res = $this->customer->instituts()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'INSTITUT_NOT_FOUND'
            ]);
        }


        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
        ]);
    }

    /**
     * @api {get} /institut/{id}/file/{file_id}  Retrieves the file content from an institut
     * @apiName institutFileGet
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {id}           institut_id         Institut ID
     * @apiParam {file_id}      file_id             File ID
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     * @apiSuccess (200)    {string}      resultContent      base64 content of the file
     *
     * @apiError (Error 4xx) {400}  error   Bad request.
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Institut not found.
     * @apiError (Error 4xx) {404}  error   File  not found.
     */
    public function get_file($id, $file_id)
    {
        if (!$institut = $this->customer->instituts()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'INSTITUT_NOT_FOUND'
            ]);
        }

        $file = $institut->files()->where('id', $file_id)->first();
        if (!$file) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'FILE_NOT_FOUND'
            ]);
        }

        $file_path = config_item('data_instituts_picture') . '/' . $file->filename;
        $file->data = 'data:' . mime_content_type($file_path) . ';base64,' . base64_encode(file_get_contents($file_path));

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $file,
        ]);
    }

    /**
     * @api {post} /institut/{id}/file  Adds a file to an institut
     * @apiName institutFileAdd
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {id}           institut_id         Institut ID
     * @apiParam {file}         file                Binary file
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Bad request.
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     */
    public function upload_file($id)
    {
        if (!$res = $this->customer->instituts()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'INSTITUT_NOT_FOUND'
            ]);
        }

        // Creates the directories if needed
        $path = config_item('data_instituts_picture');
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // Load the upload library : only images, in our custom path
        $this->load->library('upload', [
            'upload_path'   => $path,
            'allowed_types' => 'jpg|png|jpeg',
            'encrypt_name'  => true
        ]);

        if (empty($_FILES)) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'INSTITUT_NO_FILE',
            ]);
        }

        if (!$this->upload->do_upload('file')) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'INSTITUT_UPLOAD_ERROR',
            ]);
        }

        $file_data = $this->upload->data();
        $file = new InstitutFileModel();
        $file->institut_id = $id;
        $file->filename = $file_data['raw_name'] . $file_data['file_ext'];
        $file->save();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $file,
        ]);
    }


    /**
     * @api {delete} /institut/{id}/file/{file_id}  Retrieves the file content from an institut
     * @apiName institutFileDelete
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {id}           institut_id         Institut ID
     * @apiParam {file_id}      file_id             File ID
     *
     * @apiSuccess (204)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Bad request.
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Institut not found.
     * @apiError (Error 4xx) {404}  error   File  not found.
     */
    public function delete_file($id, $file_id)
    {
        if (!$institut = $this->customer->instituts()->find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'INSTITUT_NOT_FOUND'
            ]);
        }

        $file = $institut->files()->where('id', $file_id)->first();
        if (!$file) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'FILE_NOT_FOUND'
            ]);
        }

        unlink(config_item('data_instituts_picture') . '/' . $file->filename);
        $file->delete();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
        ]);
    }
}