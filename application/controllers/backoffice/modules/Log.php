<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \App\Model\Log as LogModel;
use \App\Model\Company as CompanyModel;
use \App\Model\Family as FamilyModel;

class Log extends \App\Core\Controller\BackOffice
{

    protected $autoload = [
        'helper' => [
            'form',
            'date'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.modules.log.view',
        'export' => 'backoffice.modules.log.view',
    ];

    public function index()
    {
        $query =  LogModel::query()->with('customer');
        $filters = new QueryFilter(
            [
                'filters' => [
                    'location' => function ($query, $value) {
                        return $query->where('location_slug', 'like', $value);
                    },
                    'date_before' => function ($query, $value) {
                        return $query->where('created_at', '>=', $value);
                    },
                    'date_after' => function ($query, $value) {
                        return $query->where('created_at', '<=', $value);
                    },
                    'customer_info' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('customer', function($query) use ($value)
                                {
                                return $query->where('customers.id', 'like', $value.'%')
                                    ->orWhere('customers.last_name', 'like', $value.'%')
                                    ->orWhere('customers.first_name', 'like', $value.'%')
                                    ->orWhere('customers.city', 'like', $value.'%')
                                    ->orWhere('customers.email', 'like', $value.'%');
                                });
                        }
                    },
                    'families' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('customer', function($query) use ($value)
                                {
                                return $query->whereIn('customers.family_id', $value);
                                });
                        }
                    },
                    'companies' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('customer', function($query) use ($value)
                                {
                                return $query->whereIn('customers.company_id', $value);
                                });
                        }
                    },
                ],
                'save' => 'backoffice_modules_logs_filters',
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'created_at' => 'created_at',
                ],
                'save' => 'backoffice_modules_furnitures_pager',
                'unique_order_key' => 'created_at'
            ]
        );

        // get data for select filter
        $query_locations = $this->contentService->getBaseQuery()
            ->select(['contents.slug', 'contents.title_key', 'contents_translations.local', 'contents_translations.title'])
            ->join('contents_translations as contents_translations', 'contents.slug', '=', 'contents_translations.content_slug')
            ->where('contents.type', 'location')
            ->where('contents_translations.local', config_item('language'))
            ->orderBy('contents_translations.title', 'ASC');

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
            'locations' => $query_locations->get(),
            'companies' => CompanyModel::all(),
            'families' => FamilyModel::all(),
        ]);
    }

    public function export()
    {
        $query =  LogModel::query()->with('customer', 'admin')->orderBy('created_at', 'DESC');
        $filters = new QueryFilter(
            [
                'filters' => [
                    'location' => function ($query, $value) {
                        return $query->where('location_slug', 'like', $value);
                    },
                    'date_before' => function ($query, $value) {
                        return $query->where('created_at', '>=', $value);
                    },
                    'date_after' => function ($query, $value) {
                        return $query->where('created_at', '<=', $value);
                    },
                    'customer_info' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('customer', function($query) use ($value)
                                {
                                return $query->where('customers.id', 'like', $value.'%')
                                    ->orWhere('customers.last_name', 'like', $value.'%')
                                    ->orWhere('customers.first_name', 'like', $value.'%')
                                    ->orWhere('customers.city', 'like', $value.'%')
                                    ->orWhere('customers.email', 'like', $value.'%');
                                });
                        }
                    },
                    'families' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('customer', function($query) use ($value)
                                {
                                return $query->whereIn('customers.family_id', $value);
                                });
                        }
                    },
                    'companies' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('customer', function($query) use ($value)
                                {
                                return $query->whereIn('customers.company_id', $value);
                                });
                        }
                    },
                ],
                'save' => 'backoffice_modules_logs_filters',
            ]
        );
        $query = $filters->run($query)->limit(10000);
        $data = $filters->run($query)->get();

        if (empty($data)) {
            redirect_referrer('backoffice/modules/log');
        }

        $translations = $this->contentService->getBaseQuery()
            ->select(['contents.slug', 'contents.title_key', 'contents_translations.local', 'contents_translations.title'])
            ->join('contents_translations as contents_translations', 'contents.slug', '=', 'contents_translations.content_slug')
            ->where('contents.type', 'location')
            ->where('contents_translations.local', config_item('language'))
            ->orderBy('contents_translations.title', 'ASC')
            ->get();

        $locations = [];
        foreach ($translations as $t) {
           $locations[$t->slug] = $t->title;
        }

        $csv = fopen('php://memory', 'w');
        fputcsv($csv, ['CODE_CLIENT','NOM_CLIENT','PRENOM_CLIENT','VILLE_CLIENT','EMAIL_CLIENT', 'MODULE', 'DATE_EVENEMENT'], ',');
        foreach ($data as $obj) {
            $line = [
                $obj->customer_id,
                $obj->customer->last_name,
                $obj->customer->first_name,
                $obj->customer->city,
                $obj->customer->email,
                (isset($locations[$obj->location_slug]) ? $locations[$obj->location_slug] : '???'),
                date_format_complete($obj->created_at)
            ];
            fputcsv($csv, $line, ',');
        }
        fseek($csv, 0);
        $this->output->set_content_type('text/csv','utf-8');
        $this->output->set_header('Content-Disposition: attachment; filename="log_' . date('d-m-Y') . '.csv";');
        $this->output->enable_profiler(false);
        $this->output->set_output(stream_get_contents($csv));
        fclose($csv);
        unset($csv);
        $this->output->_display();
        exit();
    }
}
