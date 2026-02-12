<?php

namespace App\Controllers\BackOffice\Configuration;

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Model\Role as RoleModel;

class Role extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.configuration.role.view',
        'edit' => 'backoffice.configuration.role.edit',
    ];

    public function index()
    {
        $query = RoleModel::{"default"}();

        $filters = new QueryFilter(
            [
                'filters' => [
                    'search' => function ($query, $value) {
                    },
                ],
                'save' => 'backoffice_roles_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'name' => 'name',
                ],
                'save' => 'backoffice_roles_pager',
                'unique_order_key' => $query->getModel()->getKeyName(),
            ]
        );
        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
        ]);
    }

    public function edit($id = null)
    {
        $languagesConfig = $this->config->item('multilingual', 'site_settings');
        $languages = $languagesConfig['available'];

        if (!$id || !($item = RoleModel::find($id))) {
            redirect_referrer('backoffice/role');
        }
        $validator = new FormValidation();
        foreach ($languages as $lang) {
            $validator->set_rules('name_' . $lang['value'], 'lang:source_label_name_' . $lang['value'], 'trim|max_length[255]|required');
        }
        $validator->set_rules(
            'resources[]',
            'lang:role_label_capabilities',
            [
                'trim'
            ]
        );
        if (!$validator->run()) {
            $this->render([
                'validator' => $validator,
                'item' => $item,
                'resources' => $this->authenticationService->getResources(),
                'availables_langagues' => $languages,
            ]);
        } else {
            // save translations
            $translations = [];
            foreach ($languages as $lang) {
                $translations[$lang['value']] = $validator->set_value('name_' . $lang['value']);
            }
            $item->saveTranslations($translations);

            $item->resources_support = $validator->set_value('resources[]');
            $item->save();
            $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/configuration/role');
        }
    }
}
