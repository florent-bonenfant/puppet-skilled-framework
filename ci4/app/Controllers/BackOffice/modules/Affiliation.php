<?php

namespace App\Controllers\BackOffice\Modules;

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Model\Affiliation as AffiliationModel;
use \App\Model\Family as FamilyModel;
use Carbon\Carbon;

class Affiliation extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'url',
            'date',
        ],
        'language' => [
            'backoffice/affiliation'
        ]
    ];

    public function index()
    {
        $query = AffiliationModel::withTrashed()->with('families');
        $filters = new QueryFilter(
            [
                'filters' => [
                    'title' => function ($query, $value) {
                        $query->where('title', 'like', '%' . $value . '%');
                    },
                    'deleted' => function ($query, $value) {
                        if (!$value) {
                            $query->whereNull('deleted_at');
                        }
                    },
                    'families' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('families', function ($query) use ($value) {
                                return $query->whereIn('families.id', (array) $value);
                            });
                        }
                    },
                ],
                'default_filters' => [
                    'deleted' => 0
                ],
                'save' => 'backoffice_modules_affiliation_filters',
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'created_at' => 'created_at',
                    'title' => 'title',
                ],
                'order' => 'DESC',
                'save' => 'backoffice_modules_affiliation_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));

        $this->render([
            'filters' => $filters,
            'pager' => $pager,
            'families' => FamilyModel::query()->get(),
        ]);
    }

    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = AffiliationModel::find($id))) {
            redirect_referrer('backoffice/modules/affiliation');
        }
        $item->delete();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/affiliation');
    }

    public function restore($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = AffiliationModel::withTrashed()->find($id))) {
            redirect_referrer('backoffice/modules/affiliation');
        }

        $item->deleted_at = null;
        $item->save();
        $this->flashMessage('lang:general_message_restore-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/affiliation');
    }

    public function add()
    {
        $this->addOrEdit();
    }

    public function edit($id = null)
    {
        if (!$id || !($item = AffiliationModel::find($id))) {
            redirect_referrer('backoffice/modules/affiliation');
        }

        $this->addOrEdit($item);
    }

    protected function addOrEdit(AffiliationModel $item = null)
    {
        $validator = $this->getValidator();
        $page_title = lang('affiliation_breadcrumb_add');

        if ($item) {
            $this->breadcrumb['method'] = [
                'label' => sprintf(lang('affiliation_breadcrumb_edit'), $item->label),
                'uri' => current_url(),
            ];
            $page_title = sprintf(lang('affiliation_title_edit'), $item->label);
        }

        if ($validator->run()) {
            // flash message
            $flashMessage = ($item ? 'lang:general_message_edit-success' : 'lang:general_message_add-success');

            $item = ($item ?: new AffiliationModel());
            $item->title = $validator->set_value('title');
            $item->link = $validator->set_value('link');
            if (!empty($validator->set_value('display_start'))) {
                $item->display_start = (new Carbon($validator->set_value('display_start')))->format('Y-m-d');
            }
            if (!empty($validator->set_value('display_end'))) {
                $item->display_end = (new Carbon($validator->set_value('display_end')))->format('Y-m-d');
            }
            $item->save();

            $item->families()->sync($validator->set_value('families[]'));

            // redirect
            $this->flashMessage($flashMessage, 'lang:general_message_title-success', 'success');
            redirect('backoffice/modules/affiliation/edit/' . $item->getRouteKey());
        }

        $this->render([
            'validator'        => $validator,
            'item'             => $item,
            'families'         => FamilyModel::query()->get(),
            'page_title'       => $page_title,
        ]);
    }

    protected function getValidator()
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'title',
            'lang:affiliation_label_title',
            [
                'trim',
                'required',
                'max_length[255]',
            ]
        );
        $validator->set_rules(
            'link',
            'lang:affiliation_label_link',
            [
                'trim',
                'required',
                'max_length[255]',
                [
                    'is_valid_url',
                    [$this, 'is_valid_url'],
                ]
            ],
            [
                'is_valid_url' => 'L\'URL doit être valide',
            ]
        );
        $validator->set_rules(
            'families[]',
            'lang:affiliation_label_families',
            [
                'trim',
                'required'
            ]
        );

        $validator->set_rules(
            'display_start',
            'lang:affiliation_label_display_start',
            [
                'get_input_date'
            ]
        );

        $validator->set_rules(
            'display_end',
            'lang:affiliation_label_display_end',
            [
                'get_input_date',
                [
                    'date_gt_than',
                    function ($value) use ($validator) {
                        if (!empty($value)) {
                            $date = $validator->set_value('display_start');
                            if ($date instanceof Carbon && $date->gt($value)) {
                                return false;
                            }
                            return $value;
                        }
                        return null;
                    },
                ],
            ],
            [
                'date_gt_than' => sprintf(
                    lang('form_validation_date_greater_than'),
                    lang('affiliation_label_display_end'),
                    lang('affiliation_label_display_start')
                ),
            ]
        );

        return $validator;
    }

    public function is_valid_url($value)
    {
        // empty values are OK, the field isn't required
        if ($value == '') {
            return true;
        }
        if (filter_var($value, FILTER_VALIDATE_URL) !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function get_company_slug($name)
    {
        return strtolower(url_title($name, 'underscore'));
    }
}
