<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Model\Application as ApplicationModel;
use \App\Model\ApplicationFamily as ApplicationFamilyModel;
use \App\Model\ApplicationLink as ApplicationLinkModel;
use \App\Model\Family as FamilyModel;
use \App\Model\Company as CompanyModel;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid as Uuid;

class Application extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'url',
            'date',
            //'download'
        ],
        'language' => [
            'backoffice/application'
        ]
    ];

    protected $platforms = [
        'ios',
        'android',
    ];

    public function index()
    {
        $query = ApplicationModel::withTrashed()->with('families');
        $filters = new QueryFilter(
            [
                'filters' => [
                    'label' => function ($query, $value) {
                        $query->where('label', 'like', '%' . $value . '%');
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
                'save' => 'backoffice_modules_application_filters',
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'label' => 'label',
                ],
                'save' => 'backoffice_modules_application_pager',
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
        if ($this->input->method() !== 'post' || !$id ||  !($item = ApplicationModel::find($id))) {
            redirect_referrer('backoffice/modules/application');
        }
        $item->delete();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/application');
    }

    public function add()
    {
        $this->addOrEdit();
    }

    public function edit($id = null)
    {
        if (!$id || !($item = ApplicationModel::find($id))) {
            redirect_referrer('backoffice/modules/application');
        }

        $this->addOrEdit($item);
    }

    protected function addOrEdit(ApplicationModel $item = null)
    {
        // gets the companies
        $companies = CompanyModel::query()->get();
        $validator = $this->getValidator($item, $companies);

        $page_title = lang('application_breadcrumb_add');

        if ($item) {
            $this->breadcrumb['method'] = [
                'label' => sprintf(lang('application_breadcrumb_edit'), $item->label),
                'uri' => current_url(),
            ];
            $page_title = sprintf(lang('application_title_edit'), $item->label);
        }

        // custom links array is used to hydrate the custom links in form in edit mode
        // default values to init the form
        // they must be arrays, because the custom fields use arrays in validator
        // they are needed because the form fields need default values even if they are empty, otherwise it throws an error
        $custom_links = [];
        foreach ($companies as $company) {
            $company_name = $this->get_company_slug($company->name);
            $custom_links[$company_name] = [
                ['platform' => '', 'link' => ''],
            ];
        }

        if ($validator->run()) {

            // flash message
            $flashMessage = ($item ? 'lang:general_message_edit-success' : 'lang:general_message_add-success');

            $item = ($item ?: new ApplicationModel());
            $item->label = $validator->set_value('label');
            $item->save();

            // this array will contain the link that are already instrted in the database.
            // It is used to not insert duplicates
            $existing_links = [];

            // loops over existing links to update or delete them
            foreach ($item->links as $link) {
                $formatted_link_company_name = $this->get_company_slug($link->company->name);

                // if the link is a custom link, not for ios or android
                if (!in_array($link->platform, $this->platforms)) {
                    // it is deleted. This is normal, it will be reinserted later
                    $link->delete();
                    // we can skip to the next link
                    continue;
                }
                // regular links
                // the link field name
                $link_field_name = 'link_' . $link->platform . '_' . $formatted_link_company_name;
                // if the field has a value
                if (!empty($validator->set_value($link_field_name))) {
                    $link->link = $validator->set_value($link_field_name);
                    $link->save();
                    // puts the link name in an array to keep track of the fact that it has been treated
                    $existing_links[] = $link_field_name;
                    // if the field has no value, deletes the link
                } else {
                    $link->delete();
                }
            }

            // REGULAR LINKS
            // loops over the platforms and companies to check if a link needs to be created
            foreach ($this->platforms as $platform) {
                foreach ($companies as $company) {
                    // the link field name
                    $link_field_name = 'link_' . $platform . '_' . $this->get_company_slug($company->name);
                    // if this link has been updated, we can skip it, no need to create anything
                    if (in_array($link_field_name, $existing_links)) {
                        continue;
                    }
                    // gets the field value from the form
                    $link_value = $validator->set_value($link_field_name);
                    // if the field has a value
                    if (!empty($link_value)) {
                        // creates a link model, hydrates it and saves it
                        $link_item = new ApplicationLinkModel();

                        $link_item->application_id = $item->id;
                        $link_item->company_id     = $company->id;
                        $link_item->platform       = $platform;
                        $link_item->platform_label = lang('application_label_' . $platform);
                        $link_item->link           = $link_value;

                        $link_item->save();
                    }
                }
            }

            // CUSTOM LINKS
            // loops over the companies to analyze their custom links
            $post = $this->input->post();
            foreach ($companies as $key => $company) {
                $formatted_company_name = $this->get_company_slug($company->name);

                $key = 'custom_platforms_' . $formatted_company_name;
                foreach ($post as $key => $value) {
                    $regex = '/^custom_platforms_' . preg_quote($formatted_company_name) . '_(?P<i>\d+)$/';
                    if (!preg_match($regex, $key, $res)) {
                        continue;
                    }

                    $platforms_field_name   = 'custom_platforms_' . $formatted_company_name . '_' . $res['i'];
                    $links_field_name       = 'custom_links_' . $formatted_company_name . '_' . $res['i'];

                    // Gets the array values form the Form Validator
                    $platform_label = $validator->set_value($platforms_field_name);
                    $platform       = strtolower($platform_label);
                    $link_value     = $validator->set_value($links_field_name);

                    // if both arrays have values in them
                    if (empty($platform) || empty($link_value)) {
                        continue;
                    }

                    // tests if this platform/link pair has not been inserted already
                    foreach ($existing_links as $existing_link) {
                        // we're looking for arrays only at this point,
                        // because already inserted custom links exist as arrays in $existing_links
                        if (!is_array($existing_link)) {
                            continue;
                        }
                        if (($existing_link['platform'] === $platform) && ($existing_link['link'] === $link_value)) {
                            continue;
                        }
                    }

                    // creates a link model, hydrates it and saves it
                    $link_item = new ApplicationLinkModel();
                    $link_item->application_id = $item->id;
                    $link_item->company_id     = $company->id;
                    $link_item->platform       = $platform;
                    $link_item->platform_label = $platform_label;
                    $link_item->link           = $link_value;

                    $link_item->save();

                    // when a custom link is inserted, inserts it as an array in êxisting_links
                    // useful to not insert duplicates (when the platform/link pair already exists) in the database
                    if (!in_array($platform, $this->platforms)) {
                        $existing_links[] = ['link' => $link_value, 'platform' => $platform];
                    }
                }
            }

            $post_families = $validator->set_value('families[]');

            $id = Uuid::uuid4()->toString();
            $item->families()->sync($post_families);

            // redirect
            $this->flashMessage($flashMessage, 'lang:general_message_title-success', 'success');
            redirect('backoffice/modules/application/edit/' . $item->getRouteKey());
        }

        if ($item) {
            // hydrates application and custom links
            foreach ($item->links as $link) {
                $formatted_company_name = $this->get_company_slug($link->company->name);

                // regular links
                if (in_array($link->platform, $this->platforms)) {
                    $item->{'link_' . $link->platform . '_' . $formatted_company_name} = $link->link;
                } else {
                    $link_item = ['platform' => $link->platform_label, 'link' => $link->link];
                    // removes defautl value, not needed anymore
                    unset($custom_links[$formatted_company_name][0]);
                    // hydrates $custom_links to hydrate the form in edit mode
                    $custom_links[$formatted_company_name][] = $link_item;
                }
            }
        }

        $this->render([
            'validator'        => $validator,
            'item'             => $item,
            'families'         => FamilyModel::query()->get(),
            'companies'        => $companies,
            'page_title'       => $page_title,
            'platforms'        => $this->platforms,
            'custom_links'     => $custom_links,
        ]);
    }

    protected function getValidator($item, $companies)
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'label',
            'lang:application_label_label',
            [
                'trim',
                'required',
                'max_length[255]',
            ]
        );
        $validator->set_rules(
            'families[]',
            'lang:application_label_families',
            [
                'trim',
                'required'
            ]
        );

        $validator->set_rules(
            'custom_Guinot_links[]',
            'application_custom_links_label',
            [
                [
                    'is_valid_url',
                    [$this, 'is_valid_url'],
                ]
            ],
            [
                'is_valid_url' => 'L\'URL doit être valide',
            ]
        );

        $post = $this->input->post();
        foreach ($companies as $company) {
            $company_name = $this->get_company_slug($company->name);

            $total = 0;
            if (!empty($post)) {
                foreach (array_keys($post) as $key) {
                    $regex = '/^custom_platforms_' . preg_quote($company_name) . '_\d+$/';
                    if (preg_match($regex, $key)) {
                        $total++;
                    }
                }
            }

            for ($i = 0; $i < $total; $i++) {
                $validator->set_rules(
                    'custom_platforms_' . $company_name . '_' . $i,
                    'application_custom_platforms_label',
                    [
                        'trim',
                    ]
                );

                $validator->set_rules(
                    'custom_links_' . $company_name . '_' . $i,
                    'application_custom_links_label',
                    [
                        [
                            'is_valid_url',
                            [$this, 'is_valid_url'],
                        ]
                    ],
                    [
                        'is_valid_url' => 'L\'URL doit être valide',
                    ]
                );
            }
        }


        // url fields for each platform/company pair
        foreach ($this->platforms as $platform) {
            foreach ($companies as $company) {
                $validator->set_rules(
                    'link_' . $platform . '_' . $this->get_company_slug($company->name),
                    'lang:application_label_' . $platform . '_' . $this->get_company_slug($company->name),
                    [
                        [
                            'is_valid_url',
                            [$this, 'is_valid_url'],
                        ]
                    ],
                    [
                        'is_valid_url' => 'L\'URL doit être valide',
                    ]
                );
            }
        }

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
