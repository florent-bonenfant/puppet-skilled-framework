<?php
if (route_is_accessible('backoffice')) {
    echo $this->element(
        'crud/global_actions',
        [
            'actions' => [
                [
                    'uri' => 'backoffice/modules/shipping_slips/sync',
                    'label' => '<i class="material-icons">import_export</i> ' . lang('shipping_action_sync'),
                    'extra' => [
                        'title' => lang('shipping_action_sync'),
                        'class' => 'btn btn-primary',
                    ],
                ],
            ],
        ]
    );
}
$filters = $this->fetch('filters');
$pager = $this->fetch('pager')->getResult();
$baseUrl = $this->fetch('base_url') ?: current_base_url();
?>
<div class="card card-filter mb-4">
    <div class="card-header FilterHeader">
       <?=$pager['total']?> <?=lang('general_label_total_element')?>
    </div>

    <div class="card-block">
        <?php $preprendId = uniqid();?>
        <form action="<?=site_url($baseUrl)?>" method="get" accept-charset="utf-8" class="FilterForm">
            <div class="form-group">
                <label for="<?=$preprendId?>number" class="form-label"><?=lang('shipping_slips_label_filter_shipping_slips_number');?></label>
                <input type="text" class="form-control" name="number" id="<?=$preprendId?>number" value="<?=html_escape($filters->getValue('number'))?>">
            </div>

            <div class="form-group">
                <label for="<?=$preprendId?>customer_id" class="form-label"><?=lang('shipping_slips_label_filter_customer');?></label>
                <input type="text" class="form-control" name="customer_id" id="<?=$preprendId?>customer_id" value="<?=html_escape($filters->getValue('customer_id'))?>">
            </div>

            <div class="form-actions">
                <button type='submit' value="<?=$filters->getFilterActionValue()?>" name="<?=$filters->getActionName()?>" class='btn btn-primary'>
                    <?=lang('general_action_filter')?>
                </button>
                <?=anchor(
    $baseUrl . '?' . $filters->getActionName() . '=' . $filters->getResetActionValue(),
    lang('general_action_reset_filters')
)?>
            </div>
        </form>
    </div>
</div>

<?=$this->element(
    'crud/list',
    [
        'pager' => $this->fetch('pager'),
        'displayed_fields' => [
            [
                'query_key' => 'number',
                'label' => 'lang:shipping_slips_label_number',
            ],
            [
                'query_key' => 'customer_id',
                'label' => 'lang:shipping_slips_label_customer_id',
            ],
            [
                'query_key' => 'institut_id',
                'label' => 'lang:shipping_slips_label_institut_id',
            ],
            [
                'query_key' => 'date',
                'label' => 'lang:shipping_slips_label_date',
                'formater' => function ($item) {
                    return $item->date ? user_date_format($item->date, false) : null;
                },
            ],
            [
                'label' => '',
                'class' => 'table-actions',
                'formater' => function ($item) {
                    return $this->block('list_actions', ['item' => $item]);
                },
            ],
        ],
    ]
);?>
