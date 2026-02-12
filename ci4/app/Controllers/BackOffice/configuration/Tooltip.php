<?php

namespace App\Controllers\BackOffice\Configuration;

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;

class Tooltip extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'url'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.configuration.tooltip.view',
        'edit' => 'backoffice.configuration.tooltip.edit',
        'active_toggle' => 'backoffice.configuration.tooltip.edit',
    ];

    public function index()
    {
        $filters = new QueryFilter(
            [
                'filters' => [
                    'search' => function ($query, $value) {
                    },
                ],
                'save' => 'tooltip_filters',//Session key
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'save' => 'tooltip_pager',
                'unique_order_key' => 'slug'
            ]
        );

        $query = $this->contentService->getBaseQuery()
            ->distinct()
            ->where('type', 'tooltip');
        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
        ]);
    }

    public function edit($slug = null)
    {
        if (!$slug || !($item = $this->contentService->getContentInfo($slug)) || $item->type != 'tooltip') {
            redirect_referrer('backoffice/configuration/tooltip');
        }

        $languagesConfig = $this->config->item('multilingual', 'site_settings');
        $availables = $languagesConfig['available'];

        $validator = new FormValidation();
        $validator->set_rules(
            'active',
            'lang:tooltip_label_value_active',
            [
                'trim',
                'in_list[0,1]',
                'required'
            ]
        );
        foreach ($availables as $available) {
            $validator->set_rules(
                'content_'.$available['value'],
                'lang:tooltip_label_content',
                [
                    'trim',
                    'required'
                ]
            );
        }

        if (!$validator->run()) {
            $this->render([
                'validator' => $validator,
                'item' => $item,
                'availables_langagues' => $availables,
            ]);
        } else {
            $active = $validator->set_value('active');
            if ($active !== $item->active) {
                $this->contentService->active($item->slug, $active);
            }

            foreach ($availables as $available) {
                $this->contentService->setTranslation(
                    $item->slug,
                    $available['value'],
                    null,
                    $validator->set_value('content_'.$available['value']),
                    null
                );
            }

            $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/configuration/tooltip');
        }
    }

    public function active_toggle($slug = null)
    {
        if (!$slug || !($item = $this->contentService->getContentInfo($slug)) || $item->type != 'tooltip') {
            redirect_referrer('backoffice/configuration/tooltip');
        }
        $this->contentService->active($item->slug, ($item->active? 0 :1));
        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect_referrer('backoffice/configuration/tooltip');
    }
}
