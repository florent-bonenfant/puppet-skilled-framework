<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Model\ShippingCarrier as CarrierModel;


class Carrier extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'url',
            'date',
            'download'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.configuration.carrier.view',
        'edit' => 'backoffice.configuration.carrier.edit',
        'delete' => 'backoffice.configuration.carrier.delete',
        'active_toggle' => 'backoffice.configuration.carrier.edit',
        'upload' => 'backoffice.configuration.carrier.edit',
        'download' => 'backoffice.configuration.carrier.view'
    ];

    public function index()
    {
        $query = CarrierModel::query()->orderBy('label', 'asc');
        $filters = new QueryFilter(
            [
                'filters' => [
                    'label' => function ($query, $value) {
                        return $query->where('label', $value);
                    },
                ],
                'save' => 'carrier_filters',
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'save' => 'carrier_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
        ]);
    }

    protected function getValidator($item = null)
    {
        $validator = new FormValidation();

        $validator->set_rules(
            'label',
            'lang:carrier_label_name',
            [
                'trim',
                'max_length[255]',
                'required'
            ]
        );
        $validator->set_rules(
            'slug',
            'lang:carrier_label_slug',
            [
                'trim',
                'max_length[255]',
                'required'
            ]
        );
        $validator->set_rules(
            'link',
            'lang:carrier_label_link',
            [
                'trim',
                'required',
                [
                    'valid_url',
                    function ($value) {
                        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
                            return false;
                        }
                        return true;
                    }
                ]
            ]
        );

        return $validator;
    }


    public function add()
    {
        $validator = $this->getValidator();
        $this->save($validator);

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => lang('carrier_breadcrumb_add'),
            'uri' => current_url(),
        ];
        // alter page title
        $page_title = lang('carrier_title_add');
        // render
        $this->render([
            'validator'  => $validator,
            'error'      => isset($error) ? $error : '',
            'page_title' => $page_title
        ]);
    }

    public function edit($id = null)
    {
        if (!$id || !($item = CarrierModel::find($id))) {
            redirect_referrer('backoffice/configuration/carrier');
        }

        $validator = $this->getValidator($item);
        if (!empty($_POST)) {
            $this->save($validator, $item);
        }

        $this->render([
            'validator' => $validator,
            'item' => $item,
            'error'      => isset($error) ? $error : '',
        ]);
    }

    protected function save($validator, CarrierModel $carrier = null) {
        $carrier = ($carrier ?: new CarrierModel());

        if ($validator->run()) {
            $carrier->label = $validator->set_value('label');
            $carrier->slug = $validator->set_value('slug');
            $carrier->link = $validator->set_value('link');
            $carrier->save();

            $this->flashMessage('lang:general_message_add-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/configuration/carrier');
        }
    }

    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = CarrierModel::find($id))) {
            redirect_referrer('backoffice/configuration/carrier');
        }

        $item->delete();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/configuration/carrier');
    }
}
