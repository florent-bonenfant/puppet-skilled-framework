<?php
if (route_is_accessible('backoffice')) {
    echo $this->element(
        'crud/global_actions',
        [
            'actions' => [
                [
                    'uri' => 'backoffice/modules/order/sync',
                    'label' =>  '<i class="material-icons">import_export</i> ' .  lang('order_action_sync'),
                    'extra' => [
                        'title' => lang('order_action_sync'),
                        'class' => 'btn btn-primary',
                    ]
                ]
            ]
        ]
    );
}
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
                <label for="<?= $preprendId ?>order_number" class="form-label"><?= lang('order_label_filter_order_number'); ?></label>
                <input type="text" class="form-control" name="order_number" id="<?= $preprendId ?>order_number" value="<?= html_escape($filters->getValue('order_number')) ?>">
            </div>

            <div class="form-group">
                <label for="<?= $preprendId ?>customer_id" class="form-label"><?= lang('order_label_filter_customer'); ?></label>
                <input type="text" class="form-control" name="customer_id" id="<?= $preprendId ?>customer_id" value="<?= html_escape($filters->getValue('customer_id')) ?>">
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
               'query_key' => 'order_number',
               'label' => 'lang:order_label_order_number',
           ],

           [
               'query_key' => 'quantity',
               'label' => 'lang:order_label_quantity',
               'formater' => function ($item) {
                  return $item->quantity;
               }
           ],
           [
               'query_key' => 'date',
               'label' => 'lang:order_label_date',
               'formater' => function ($item) {
                   return user_date_format($item->date, false);
               }
           ],
           [
               'query_key' => 'customer_id',
               'label' => 'lang:order_label_customer_id',
           ],
           [
               'query_key' => 'created_at',
               'label' => 'lang:order_label_created_at',
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
);?>
