<?= $this->element(
    'crud/global_actions',
    [
        'actions' => [
            [
                'uri' => 'backoffice/configuration/maintenance/add/',
                'label' =>  '<i class="material-icons">add</i> ' .  lang('general_action_add'),
                'extra' => [
                    'title' => lang('general_action_add'),
                    'class' => 'btn btn-primary',
                ]
            ]
        ]
    ]
);
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
                <?= $this->element(
                    'form/block_input',
                    [
                        'name' => 'message',
                        'input_element' => 'form/input',
                        'label' => 'lang:maintenance_label_filter_message',
                        'id' => $preprendId . 'message',
                    ]
                ) ?>
            </div>
                <!-- #DATE FILTERS -->
                <div class="form-group">
                    <label class="form-control-label"><?= lang('maintenance_label_filter_date'); ?></label><br />
                    <div class="form-group-inline">
                        <label
                            for="<?= $preprendId ?>date_before"><?= lang('maintenancelabel_filter_date_before'); ?></label>
                        <input <?= _attributes_to_string(['type' => 'text', 'name' => 'date_before', 'class' => 'form-control js-datepicker flatpickr-input', 'id' => $preprendId . 'date_before', 'placeholder' => lang('general_label_datepicker_format'), 'value' => $filters->getValue('date_before')]) ?> />
                    </div>
                    <div class="form-group-inline">
                        <label
                            for="<?= $preprendId ?>date_after"><?= lang('maintenance_label_filter_date_after'); ?></label>
                        <input <?= _attributes_to_string(['type' => 'text', 'name' => 'date_after', 'class' => 'form-control  js-datepicker flatpickr-input', 'id' => $preprendId . 'date_after', 'placeholder' => lang('general_label_datepicker_format'), 'value' => $filters->getValue('date_after')]) ?> />
                    </div>
                </div>
                <!-- #END DATE FILTERS -->

                <div class="form-actions">
                    <button type='submit' value="<?= $filters->getFilterActionValue() ?>"
                        name="<?= $filters->getActionName() ?>" class='btn btn-primary'>
                        <?= lang('general_action_filter') ?>
                    </button>
                    <?= anchor(
                        $baseUrl . '?' . $filters->getActionName() . '=' . $filters->getResetActionValue(),
                        lang('general_action_reset_filters')
                    ) ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Liste des maintenances existantes -->
<?= $this->element(
        'crud/list',
        [
        'pager'  => $this->fetch('pager'),
        'displayed_fields' => [
            [
                'query_key' => 'message',
                'label' => 'lang:maintenance_label_message',
            ],
            [
                'query_key' => 'starts_on',
                'label' => 'lang:maintenance_label_start',
                'formater' => function ($item) {
                    if ($item->starts_on !== null) {
                        return date_format(new DateTime($item->starts_on), "d/m/Y - H:i");
                    }
                }
            ],
            [
                'query_key' => 'ends_on',
                'label' => 'lang:maintenance_label_end',
                'formater' => function ($item) {
                    if ($item->ends_on !== null) {
                        return date_format(new DateTime($item->ends_on), "d/m/Y - H:i");
                    }
                }
            ],
            [
                'query_key' => 'status',
                'label' => 'lang:maintenance_label_status',
                'formater' => function ($item) {
                    $now = new DateTime();
                    if (($item->starts_on === null && $item->ends_on === null) ||
                    ($item->starts_on === null && $now <= new DateTime($item->ends_on)) ||
                    ($now >= new DateTime($item->starts_on) && $item->ends_on === null) ||
                    ($now >= new DateTime($item->starts_on) && $now <= new DateTime($item->ends_on))) {
                        return '<span>' . lang('maintenance_label_pending') . '</span>';
                    }
                    return '';
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
    ]);

    $this->asset->enqueueStyle('flatpickr.css');
    $this->asset->enqueueScript('locales.js');
?>
