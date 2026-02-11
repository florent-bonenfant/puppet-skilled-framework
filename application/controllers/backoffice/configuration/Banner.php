<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Model\Banner as BannerModel;
use \App\Model\Company as CompanyModel;
use \App\Library\Upload;


class Banner extends \App\Core\Controller\BackOffice
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
        'index' => 'backoffice.configuration.banner.view',
        'edit' => 'backoffice.configuration.banner.edit',
        'active_toggle' => 'backoffice.configuration.banner.edit',
        'upload' => 'backoffice.configuration.banner.edit',
        'download' => 'backoffice.configuration.banner.view'
    ];

    public function index()
    {
        $query = BannerModel::query()->orderBy('deleted_at', 'desc');
        $filters = new QueryFilter(
            [
                'filters' => [
                    'companies' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereIn('company_id', $value);
                        }
                    },
                ],
                'save' => 'banner_filters',
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'save' => 'banner_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
            'companies' => \App\Model\Company::all(),
        ]);
    }

    /**
     * Delete the document of the banner
     *
     * @param  string $id furniture's id
     */
    public function delete_file($id = null)
    {
        if ($this->input->method() !== 'post' || !$id || !($item = BannerModel::find($id))) {
            redirect_referrer('backoffice/configuration/banner');
        }
        $item->file_name = null;
        if ($item->save()) {
            if (file_exists($item->getFilePath())) {
                unlink($item->getFilePath($item));
            }
        }
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/configuration/banner/edit/' . $id);
    }

    /**
     * Téléchargement de l'image
     *
     * @param     [strig]    $id    [$id description]
     *
     */
    public function download($id = null)
    {
        $item = BannerModel::find($id);
        force_download($item->getFilePath(), null);
    }

    protected function getValidator($item = null)
    {
        $validator = new FormValidation();

        $documentUploadConf = new Upload('file', [
            'upload_path' => config_item('data_document_path') . '/banners/',
            'allowed_types' => 'jpg|png|jpeg',
            'file_name' => sha1(uniqid()),
            'max_size' => 0
        ]);

        $validator->set_rules(
            'company_id',
            'lang:banner_add_label_company',
            [
                [
                    'valid_company_id',
                    function ($company_id) use ($item) {
                        if (!empty($item) && \App\Model\Company::find($item->company_id)) {
                            return true;
                        }
                        if (\App\Model\Company::find($company_id)) {
                            return true;
                        }
                        return false;
                    }
                ],
            ],
            [
                'valid_company_id' => 'La société doit être valide et correspondre à une société existante.',
            ]
        );

        $validator->set_rules(
            'file',
            'lang:banner_add_label_banner',
            [
                [
                    // Test valid file,
                    'valid_file',
                    function () use ($validator, $documentUploadConf) {

                        if (!$documentUploadConf->upload_file_exists()) {
                            return true;
                        }
                        if (!$documentUploadConf->check_upload()) {
                            $validator->add_error(lang('banner_error_document_format'), $documentUploadConf->get_field_name());
                            return true;
                        } else {
                            return $documentUploadConf;
                        }
                    }
                ]
            ]
        );
        return $validator;
    }

    public function add()
    {
        $validator = $this->getValidator();
        $user = $this->authenticationService->user();

        if ($validator->run()) {
            BannerModel::where('company_id', $validator->set_value('company_id'))->update(['deleted_at' => \Carbon\Carbon::now()]);
            $banner = new BannerModel();
            $banner->company_id = $validator->set_value('company_id');
            $banner->original_file_name = $validator->set_value('original_file_name');
            $banner->created_by = $user->id;
            $file = $validator->set_value('file');
            // executes the file upload of necessary, or deletes the file_name field if no file was chosen
            if ($file instanceof Upload) {
                $file->do_upload();
                $banner->file_name = $file->data('file_name');
                $banner->original_file_name = $file->data('client_name');
                $banner->mime = $file->data('file_type');
            }
            $banner->save();

            $this->flashMessage('lang:banner_message_add-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/configuration/banner');
        }

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => lang('banner_breadcrumb_add'),
            'uri' => current_url(),
        ];
        // alter page title
        $page_title = lang('banner_title_add');
        // render
        $this->render([
            'validator'  => $validator,
            'companies'  => CompanyModel::query()->get(),
            'error'      => isset($error) ? $error : '',
            'page_title' => $page_title
        ]);
    }

    public function edit($id = null)
    {
        if (!$id || !($item = BannerModel::find($id))) {
            redirect_referrer('backoffice/configuration/banner');
        }

        $validator = $this->getValidator($item);
        $user = $this->authenticationService->user();

        if (!empty($_POST) && $validator->run()) {
            BannerModel::where('company_id', $validator->set_value('company_id'))->update(['deleted_at' => \Carbon\Carbon::now()]);
            $banner = BannerModel::find($id);
            $banner->company_id = $validator->set_value('company_id');
            $banner->original_file_name = $validator->set_value('original_file_name');
            $banner->updated_by = $user->id;
            $banner->deleted_at = null;
            $file = $validator->set_value('file');
            // executes the file upload of necessary, or deletes the file_name field if no file was chosen
            if ($file instanceof Upload) {
                $file->do_upload();
                $banner->file_name = $file->data('file_name');
                $banner->original_file_name = $file->data('client_name');
                $banner->mime = $file->data('file_type');
            }
            $banner->save();

            $this->flashMessage('lang:banner_message_add-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/configuration/banner');
        }

        $this->render([
            'validator' => $validator,
            'item' => $item,
            'companies'  => CompanyModel::query()->get(),
            'error'      => isset($error) ? $error : '',
        ]);
    }

    public function active_toggle($id = null)
    {
        if (!$id || !($item = BannerModel::find($id))) {
            redirect_referrer('backoffice/configuration/banner');
        }

        BannerModel::where('company_id', $item->company_id)->update(['deleted_at' => \Carbon\Carbon::now()]);
        BannerModel::where('id', $id)->update(['deleted_at' => null]);
        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect_referrer('backoffice/configuration/banner');
    }
}
