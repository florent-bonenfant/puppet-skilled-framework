<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;

class Content_simple extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'url'
        ],
        'language' => [
            'backoffice/content_simple'
        ]
    ];

    protected $guards = [
        'index' => 'backoffice.configuration.content_simple.view',
        'edit' => 'backoffice.configuration.content_simple.edit',
        'active_toggle' => 'backoffice.configuration.content_simple.edit',
    ];

    public function index()
    {
        $filters = new QueryFilter(
            [
                'filters' => [
                    'content' => function ($query, $value) {
                        return $query->where('contents_translations.content', 'like', '%'.$value.'%');
                    },
                ],
                'save' => 'content_simple_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'save' => 'content_simple_pager',
                'unique_order_key' => 'slug'
            ]
        );

        $query = $this->contentService->getBaseQuery()
            ->select(['contents.slug', 'contents.active', 'contents.title_key', 'contents_translations.local', 'contents_translations.content', 'contents_translations.excerpt'])
            ->join('contents_translations as contents_translations', 'contents.slug', '=', 'contents_translations.content_slug')
            ->where('type', 'content_simple')
            ->where('contents_translations.local', config_item('language'));

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager
        ]);
    }

    public function edit($slug = null)
    {
        if (!$slug || !($item = $this->contentService->getContentInfo($slug)) || $item->type != 'content_simple') {
            redirect_referrer('backoffice/configuration/content_simple');
        }

        $languagesConfig = $this->config->item('multilingual', 'site_settings');
        $availables = $languagesConfig['available'];

        $validator = new FormValidation();
        foreach ($availables as $available) {
            $validator->set_rules(
                'content_'.$available['value'],
                'lang:content_simple_label_content',
                [
                    'trim',
                    'required'
                ]
            );
        }
        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('content_simple_breadcrumb_edit'), $item->title_key),
            'uri' => current_url(),
        ];
        $page_title = sprintf(lang('content_simple_title_edit'), $item->title_key);

        if (!$validator->run()) {
            $this->render([
                'validator' => $validator,
                'item' => $item,
                'availables_langagues' => $availables,
                'page_title' => $page_title
            ]);
        } else {
            $this->contentService->active($item->slug, 1);
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
            redirect('backoffice/configuration/content_simple');
        }
    }

    public function active_toggle($slug = null)
    {
        if (!$slug || !($item = $this->contentService->getContentInfo($slug)) || $item->type != 'content_simple') {
            redirect_referrer('backoffice/configuration/content_simple');
        }
        $this->contentService->active($item->slug, ($item->active? 0 :1));
        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect_referrer('backoffice/configuration/content_simple');
    }
}
