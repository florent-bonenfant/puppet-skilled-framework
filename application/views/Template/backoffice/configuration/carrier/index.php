<?php

$filters = $this->fetch('filters');
$error = $this->fetch('error');
$pager = $this->fetch('pager')->getResult();
$baseUrl = $this->fetch('base_url') ?: current_base_url();

if (route_is_accessible('backoffice.configuration.carrier')) {
    echo $this->element(
        'crud/global_actions',
        [
            'actions' => [
                [
                    'uri' => 'backoffice/configuration/carrier/add',
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
                <?= $this->element(
                    'form/block_input',
                    [
                        'name' => 'label',
                        'input_element' => 'form/input',
                        'label' => 'lang:carrier_label_name',
                        'id' => $preprendId . 'label',
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
                'query_key' => 'label',
                'label' => 'lang:carrier_label_name',
            ],
            [
                'query_key' => 'slug',
                'label' => 'lang:carrier_label_slug',
            ],
            [
                'query_key' => 'link',
                'label' => 'lang:carrier_label_link',
                'header_class' => 'text-nowrap',
                'formater' => function ($item) {
                    return $item->link;
                }
            ],
            [
                'query_key' => 'updated_at',
                'label' => 'lang:carrier_label_updated_at',
                'header_class' => 'text-nowrap',
                'formater' => function ($item) {
                    return user_date_format($item->updated_at, true);
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