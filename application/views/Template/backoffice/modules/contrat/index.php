<?php if (route_is_accessible('backoffice')) : ?>
    <div class="container-global-actions">
    <?= $this->element(
        'crud/global_actions',
        [
            'actions' => [
                [
                    'uri' => 'backoffice/modules/contrat/sync',
                    'label' =>  '<i class="material-icons">import_export</i> ' .  lang('contrat_action_sync'),
                    'extra' => [
                        'title' => lang('contrat_action_sync'),
                        'class' => 'btn btn-primary',
                    ]
                ]
            ]
        ]
    ); ?>
<?php endif; ?>
<?php if (route_is_accessible('backoffice/modules/contrat/add')) : ?>
    <?= $this->element(
        'crud/global_actions',
        [
            'actions' => [
                [
                    'uri' => 'backoffice/modules/contrat/add',
                    'label' =>  '<i class="material-icons">add</i> ' . lang('contrat_action_add'),
                    'extra' => [
                        'title' => lang('contrat_action_add'),
                        'class' => 'btn btn-primary',
                    ]
                ]
            ]
        ]
    ); ?>
    </div>
<?php endif; ?>

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
                <label for="<?= $preprendId ?>city" class="form-label"><?= lang('contrat_label_filter_city'); ?></label>
                <input type="text" class="form-control" name="city" id="<?= $preprendId ?>city" value="<?= html_escape($filters->getValue('city')) ?>">
            </div>

            <div class="form-group">
                <label for="<?= $preprendId ?>customer" class="form-label"><?= lang('contrat_label_filter_customer'); ?></label>
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
               'query_key' => 'original_file_name',
               'label' => 'lang:contrat_label_original_file_name',
           ],
           [
               'query_key' => 'city',
               'label' => 'lang:contrat_label_city',
           ],
           [
               'query_key' => 'customer_id',
               'label' => 'lang:contrat_label_customer_id',
           ],
           [
                'query_key' => 'company_id',
                'label' => 'lang:contrat_label_company_name',
                'formater' => function ($item) {
                    return $item->company->name;
                 }
            ],
           [
               'query_key' => 'created_at',
               'label' => 'lang:contrat_label_created_at',
               'formater' => function ($item) {
                  return user_date_format($item->created_at, false);
               }
           ],
           [
               'query_key' => 'contract',
               'label' => 'lang:contrat_label_contract',
               'class' => 'table-actions',
               'formater' => function ($item) {
                    if ($item->file_name) {
                        return '<a href="' . site_url('backoffice/modules/contrat/download/' . $item->getRouteKey()) . '" class="btn-success btn btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="'.lang('general_action_download').'" target="_blank"><i class="material-icons">file_download</i></a>';
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
