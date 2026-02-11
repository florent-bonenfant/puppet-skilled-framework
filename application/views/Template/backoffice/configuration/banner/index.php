<?php

$filters = $this->fetch('filters');
$error = $this->fetch('error');
$pager = $this->fetch('pager')->getResult();
$baseUrl = $this->fetch('base_url') ?: current_base_url();

if (route_is_accessible('backoffice.configuration.banner')) {
    echo $this->element(
        'crud/global_actions',
        [
            'actions' => [
                [
                    'uri' => 'backoffice/configuration/banner/add',
                    'label' =>  '<i class="material-icons">add</i> ' . lang('general_action_submit_add'),
                    'extra' => [
                        'title' => lang('general_action_submit_add'),
                        'class' => 'btn btn-primary',
                    ]
                ]
            ]
        ]
    );
}

?>
<div class="card card-filter mb-4">
    <div class="card-header FilterHeader">
        <?= $pager['total'] ?> <?= lang('general_label_total_element') ?>
    </div>

    <div class="card-block">
        <?php $preprendId = uniqid(); ?>
        <form action="<?= site_url($baseUrl) ?>" method="get" accept-charset="utf-8" class="FilterForm">
            <div class="form-group">
                <label class="form-label"><?= lang('customer_label_company'); ?></label><br />
                <?= $this->element(
                    'form/checkbox_inline',
                    [
                        'name' => 'companies[]',
                        'default_value' => $filters->getValue('companies'),
                        'options' => array_pluck($this->fetch('companies'), 'name', 'id')
                    ]
                ) ?>
            </div>

            <div class="form-actions">
                <button type='submit' value="<?= $filters->getFilterActionValue() ?>" name="<?= $filters->getActionName() ?>" class='btn btn-primary'>
                    <?= lang('general_action_filter') ?>
                </button>
                <?= anchor(
                    $baseUrl . '?' . $filters->getActionName() . '=' . $filters->getResetActionValue(),
                    lang('general_action_reset_filters')
                ) ?>
            </div>
        </form>
    </div>
</div>

<?= $this->element(
    'crud/list',
    [
        'pager'  => $this->fetch('pager'),
        'displayed_fields' => [
            [
                'query_key' => 'banner',
                'label' => 'lang:banner_label_preview',
                'formater' => function ($item) {
                    if ($item->getBase64File()) {
                        return '<img
                            class="banner-preview"
                            src="data:' . $item->getBase64File() . '"
                            alt="' . lang('general_label_company_logo') . '"
                        >
                        ';
                    }
                    return null;
                }
            ],
            [
                'query_key' => 'company_id',
                'label' => 'lang:banner_label_company',
                'formater' => function ($item) {
                    return str_replace(' ', '&nbsp;', $item->company->name);
                }
            ],
            [
                'query_key' => 'created_at',
                'label' => 'lang:banner_label_date',
                'header_class' => 'text-nowrap',
                'formater' => function ($item) {
                    return user_date_format($item->created_at, true);
                }
            ],
            [
                'label' => '',
                'class' => 'table-actions',
                'formater' => function ($item) {
                    return $this->block('list_actions', ['item' => $item]);
                }
            ],
        ],
    ]
); ?>