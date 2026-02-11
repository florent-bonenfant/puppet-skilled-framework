<?php
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
                <label for="<?=$preprendId?>number" class="form-label"><?=lang('shipping_tracking_label_filter_shipping_tracking_number');?></label>
                <input type="text" class="form-control" name="number" id="<?=$preprendId?>number" value="<?=html_escape($filters->getValue('number'))?>">
            </div>

            <div class="form-group">
                <label for="<?=$preprendId?>customer_id" class="form-label"><?=lang('shipping_tracking_label_filter_customer');?></label>
                <input type="text" class="form-control" name="customer_id" id="<?=$preprendId?>customer_id" value="<?=html_escape($filters->getValue('customer_id'))?>">
            </div>

            <div class="form-group">
                <label for="<?=$preprendId?>institut_id" class="form-label"><?=lang('shipping_tracking_label_filter_institut');?></label>
                <input type="text" class="form-control" name="institut_id" id="<?=$preprendId?>institut_id" value="<?=html_escape($filters->getValue('institut_id'))?>">
            </div>

            <?= $this->element(
            'form/block_input',
            [
                'name' => 'carrier_id',
                'input_element' => 'form/select',
                'label' => 'lang:shipping_tracking_label_filter_carrier',
                'id' => $preprendId . 'carrier_id',
                'options' => $this->fetch('carriers')[0],
                'default_value' => $filters->getValue('carrier_id'),
            ]
        ) ?>

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
                'label' => 'lang:shipping_tracking_label_number',
            ],
            [
                'query_key' => 'customer_id',
                'label' => 'lang:shipping_tracking_label_customer_id',
            ],
            [
                'query_key' => 'institut_id',
                'label' => 'lang:shipping_tracking_label_institut_id',
            ],
            [
                'query_key' => 'order',
                'label' => 'lang:shipping_tracking_label_order',
                'formater' => function ($item) {
                    if (!$item->orders) {
                        return null;
                    }
                    if (count($item->orders) === 1) {
                        return $item->orders[0]->order_number . " (".user_date_format($item->orders[0]->date, false).")";
                    }
                    $return = '<ul>';
                    foreach ($item->orders as $orders) {
                        $return .= "<li>$orders->order_number (".user_date_format($orders->date, false).")</li>";
                    }
                    $return .= '</ul>';
                    return $return;
                },
            ],
            [
                'query_key' => 'date',
                'label' => 'lang:shipping_tracking_label_date',
                'formater' => function ($item) {
                    return $item->date ? user_date_format($item->date, false) : null;
                },
            ],
            [
                'query_key' => 'carrier',
                'label' => 'lang:shipping_tracking_label_carrier',
                'formater' => function ($item) {
                    return $item->carrier->label ?: null;
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
