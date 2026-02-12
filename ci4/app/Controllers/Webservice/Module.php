<?php

namespace App\Controllers\Webservice;

use \App\Model\Module as ModuleModel;

class Module extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {get} /module  Get all the modules accessible for front
     * @apiName moduleAll
     * @apiGroup module
     * @apiVersion 1
     *
     * @apiSuccess (200)    {result}       result       Array of modules
     *
     */
    public function all()
    {
        $this->lang->load('webservice/module_lang.php', 'french');

        $module = new ModuleModel();
        $modules = $module->getFrontPermissionModules();

        $result = [];

        foreach ($modules as $k => $module) {
            $result[] = [
                'name' => lang($module->slug),
                'slug' => $module->slug,
                'front_permission' => $module->front_permission,
            ];
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $result,
        ]);
    }
}