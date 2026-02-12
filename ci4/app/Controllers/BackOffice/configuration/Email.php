<?php

namespace App\Controllers\BackOffice\Configuration;

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;

class Email extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'url'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.configuration.email.view',
        'edit' => 'backoffice.configuration.email.edit',
        'active_toggle' => 'backoffice.configuration.email.edit',
    ];

    public function index()
    {
        $filters = new QueryFilter(
            [
                'filters' => [
                    'content' => function ($query, $value) {
                        return $query->where('contents_translations.content', 'like', '%'.$value.'%')
                                     ->orWhere('contents_translations.title', 'like', '%'.$value.'%');
                    },
                ],
                'save' => 'email_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'save' => 'email_pager',
                'unique_order_key' => 'slug'
            ]
        );

        $query = $this->contentService->getBaseQuery()
            ->select(['contents.slug', 'contents.active', 'contents.title_key', 'contents_translations.local', 'contents_translations.content', 'contents_translations.title'])
            ->join('contents_translations as contents_translations', 'contents.slug', '=', 'contents_translations.content_slug')
            ->where('contents.type', 'email')
            ->where('contents_translations.local', config_item('language'));
        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
            'part' => 'email'
        ]);
    }

    public function edit($slug = null)
    {
        if (!$slug || !($item = $this->contentService->getContentInfo($slug)) || $item->type != 'email') {
            redirect_referrer('backoffice/configuration/email');
        }

        $languagesConfig = $this->config->item('multilingual', 'site_settings');
        $availables = $languagesConfig['available'];

        $validator = new FormValidation();
        foreach ($availables as $available) {
            $validator->set_rules(
                'title_'.$available['value'],
                'lang:email_label_subject',
                [
                    'trim',
                    'required'
                ]
            );
            $validator->set_rules(
                'content_'.$available['value'],
                'lang:email_label_content',
                [
                    'trim',
                    'required'
                ]
            );
        }

        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('email_breadcrumb_edit'), $item->title_key),
            'uri' => current_url(),
        ];
        $page_title = sprintf(lang('email_title_edit'), $item->title_key);

        if (!$validator->run()) {
            $this->render([
                'validator' => $validator,
                'item' => $item,
                'availables_langagues' => $availables,
                'page_title' => $page_title
            ]);
        } else {

            foreach ($availables as $available) {
                $this->contentService->setTranslation(
                    $item->slug,
                    $available['value'],
                    $validator->set_value('title_'.$available['value']),
                    $validator->set_value('content_'.$available['value'])
                );
            }

            $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/configuration/email');
        }
    }

    public function active_toggle($slug = null)
    {
        if (!$slug || !($item = $this->contentService->getContentInfo($slug)) || $item->type != 'email') {
            redirect_referrer('backoffice/configuration/email');
        }
        $this->contentService->active($item->slug, ($item->active? 0 :1));
        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect_referrer('backoffice/configuration/email');
    }
}
