<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Service\Settings\SettingsTable;

class Setting extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'url'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.configuration.setting.view',
        'edit' => 'backoffice.configuration.setting.edit',
    ];

    public function index()
    {
        $query = $this->settings->getTable()->getQuery();

        $filters = new QueryFilter(
            [
                'filters' => [
                    'name' => function ($query, $value) {
                        return $query->where('name', 'like', '%'.$value.'%');
                    },
                ],
                'save' => 'settings_filters',//Session key
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'name' => 'name',
                    'value' => 'value'
                ],
                'save' => 'settings_pager',
                'unique_order_key' => 'name'
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
        $settingsService = $this->settings;
        if (!$id ||  !($item = $settingsService->getTable()->retrieveById($id))) {
            redirect_referrer('backoffice/configuration/settings');
        }
        $validator = new FormValidation();
        $validator->set_rules(
            'value',
            'lang:setting_label_value',
            [
                'trim',
                'required'
            ]
        );

        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('setting_breadcrumb_edit'), $item->name),
            'uri' => current_url(),
        ];
        $page_title = sprintf(lang('setting_title_edit'), $item->name);

        if (!$validator->run()) {
            $this->render([
                'validator' => $validator,
                'item' => $item,
                'page_title' => $page_title
            ]);
        } else {
            $item->value = $validator->set_value('value');
            $settingsService->update($item->name, $item->value);
            $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/configuration/setting');
        }
    }
}
