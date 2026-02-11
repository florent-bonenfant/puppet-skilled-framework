<?php
if (route_is_accessible('backoffice')) {
    echo $this->element(
        'crud/global_actions',
        [
            'actions' => [
                [
                    'uri' => 'backoffice/modules/furniture/sync',
                    'label' =>  '<i class="material-icons">import_export</i> ' .  lang('furniture_action_sync'),
                    'extra' => [
                        'title' => lang('furniture_action_sync'),
                        'class' => 'btn btn-primary',
                    ]
                ]
            ]
        ]
    );
}
?>

<?php
$filters = $this->fetch('filters');
$pager = $this->fetch('pager')->getResult();
$baseUrl = $this->fetch('base_url') ?: current_base_url();
?>
<div class="card card-filter mb-4">
    <div class="card-header FilterHeader">
       <?= $pager['total'] ?> <?= lang('general_label_total_element') ?>
    </div>

    <div class="card-block">
        <?php $preprendId = uniqid(); ?>
        <form action="<?= site_url($baseUrl) ?>" method="get" accept-charset="utf-8" class="FilterForm">
            <div class="form-group">
                <label for="<?= $preprendId ?>contract_number" class="form-label"><?= lang('furniture_label_filter_contract_number'); ?></label>
                <input type="text" class="form-control" name="contract_number" id="<?= $preprendId ?>contract_number" value="<?= html_escape($filters->getValue('contract_number')) ?>">
            </div>

            <div class="form-group">
                <label for="<?= $preprendId ?>product" class="form-label"><?= lang('furniture_label_filter_product'); ?></label>
                <input type="text" class="form-control" name="product" id="<?= $preprendId ?>product" value="<?= html_escape($filters->getValue('product')) ?>">
            </div>

            <div class="form-group">
                <label for="<?= $preprendId ?>customer" class="form-label"><?= lang('furniture_label_filter_customer'); ?></label>
                <input type="text" class="form-control" name="customer" id="<?= $preprendId ?>customer" value="<?= html_escape($filters->getValue('customer')) ?>">
            </div>

            <div class="form-actions">
                <button type='submit' value="<?= $filters->getFilterActionValue() ?>" name="<?= $filters->getActionName() ?>" class='btn btn-primary'>
                    <?= lang('general_action_filter') ?>
                </button>
                <?= anchor(
                    $baseUrl . '?'.$filters->getActionName().'='.$filters->getResetActionValue(),
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
               'query_key' => 'code',
               'label' => 'lang:furniture_label_code',
           ],
           [
               'query_key' => 'label',
               'label' => 'lang:furniture_label_label',
           ],
           [
               'query_key' => 'series',
               'label' => 'lang:furniture_label_series',
           ],
           [
               'query_key' => 'contract_number',
               'label' => 'lang:furniture_label_contract_number',
           ],
           [
               'query_key' => 'initial_date',
               'label' => 'lang:furniture_label_initial_date',
               'formater' => function ($item) {
                    if ($item->initial_date) {
                        return user_date_format($item->initial_date, false);
                    } else {
                        return '-';
                    }
               }
           ],
           [
               'query_key' => 'end_date',
               'label' => 'lang:furniture_label_end_date',
               'formater' => function ($item) {
                    if ($item->end_date) {
                        return user_date_format($item->end_date, false);
                    } else {
                        return '-';
                    }
               }
           ],
           [
               'query_key' => 'customer_id',
               'label' => 'lang:furniture_label_customer_id',
           ],
           [
               'query_key' => 'created_at',
               'label' => 'lang:furniture_label_created_at',
               'formater' => function ($item) {
                  return user_date_format($item->created_at, false);
               }
           ],
           [
               'query_key' => 'contract',
               'label' => 'lang:furniture_label_contract',
               'class' => 'table-actions',
               'formater' => function ($item) {
                    if ($item->file_name) {
                        return '<a href="' . site_url('backoffice/modules/furniture/download/' . $item->getRouteKey()) . '" class="btn-success btn btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="'.lang('general_action_download').'" target="_blank"><i class="material-icons">file_download</i></a>';
                    } else {
                        return '-';
                    }
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
);?>
