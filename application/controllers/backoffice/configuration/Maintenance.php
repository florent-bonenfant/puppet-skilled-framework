<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \App\Model\Maintenance as MaintenanceModel;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;

class Maintenance extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'date',
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.configuration.maintenance',
        'add' => 'backoffice.configuration.maintenance',
        'edit' => 'backoffice.configuration.maintenance',
        'delete' => 'backoffice.configuration.maintenance',
    ];

    public function index()
    {
        $query = MaintenanceModel::select("*")
            ->selectRaw("CASE
                    WHEN starts_on is null AND ends_on is null THEN 1
                    WHEN ends_on is null OR starts_on > NOW() THEN 2
                    WHEN starts_on is null AND ends_on > NOW() THEN 3
                    WHEN starts_on is null THEN 5
                    ELSE 4
                END AS ordering"
            );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'message' => 'message',
                    'ordering' => 'ordering',
                    'starts_on' => 'starts_on',
                    'ends_on' => 'ends_on',
                    'created_at' => 'created_at',
                ],
                'save' => 'backoffice_maintenance_pager',
                'unique_order_key' => 'ordering',
                'order' => 'ordering',
            ]
        );

        $filters = new QueryFilter(
            [
                'filters' => [
                    'message' => function ($query, $value) {
                        return $query->where('message', 'like', '%' . $value . '%');
                    },
                ],
                'save' => 'maintenance_filters',
            ]
        );

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
        ]);
    }

    public function add()
    {
        $this->addOrEdit();
    }

    public function edit($id = null)
    {
        $item = $this->getEditItem($id);

        $this->addOrEdit($item);
    }

    public function addOrEdit(MaintenanceModel $maintenance = null)
    {
        $validator = $this->getValidator();
        if ($validator->run()) {
            $startDate = null;

            if (!$startDate = get_input_datetime($this->input->post('starts_on'))) {
                $startDate = get_FR_input_datetime($this->input->post('starts_on'));
            }
            if (!$endDate = get_input_datetime($this->input->post('ends_on'))) {
                $endDate = get_FR_input_datetime($this->input->post('ends_on'));
            }

            $item = ($maintenance ?: new MaintenanceModel());
            $item->user_id = $this->authenticationService->user()->id;
            $item->message = $this->input->post('message');
            $item->starts_on = $startDate !== '' ? $startDate : null;
            $item->ends_on = $endDate !== '' ? $endDate : null;
            $item->save();

            $this->flashMessage('lang:maintenance_message_add-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/configuration/maintenance');
        } else {
            $this->render([
                'validator' => $validator,
                'item' => $maintenance,
            ]);
        }
    }

    public function delete($id)
    {
        $maintenance = MaintenanceModel::find($id);
        if ($maintenance) {
            $maintenance->delete();
            $this->flashMessage('lang:maintenance_message_delete-success', 'lang:general_message_title-success', 'success');
        } else {
            $this->flashMessage('lang:maintenance_message_notfound', 'lang:general_message_title-error', 'error');
        }
        redirect('backoffice/configuration/maintenance');
    }

    protected function getValidator($user = null)
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'message',
            'lang:maintenance_label_message',
            [
                'trim',
                'required',
            ]
        );
        $validator->set_rules(
            'starts_on',
            'lang:maintenance_label_start',
            [
                'trim',
                [
                    'valid_date',
                    function ($value) {
                        return (boolean) is_valid_input_FR_datetime($value) || is_valid_input_datetime($value);
                    },
                ],
            ]
        );
        $validator->set_rules(
            'ends_on',
            'lang:maintenance_label_end',
            [
                'trim',
                [
                    'valid_date',
                    function ($value) {
                        return (boolean) is_valid_input_FR_datetime($value) || is_valid_input_datetime($value);
                    },
                ]
            ]
        );

        return $validator;
    }

    protected function getEditItem($id)
    {
        if (!$id || !($item = MaintenanceModel::find($id))) {
            redirect_referrer('backoffice/configuration/maintenance');
        }
        return $item;
    }
}
