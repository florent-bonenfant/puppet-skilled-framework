<?php
    $filters = $this->fetch('filters');
    $pager = $this->fetch('pager');
    $pager_result = $pager->getResult();
    $baseUrl = $this->fetch('base_url') ?: current_base_url();
?>
<div class="card card-filter mb-4">
    <div class="card-header FilterHeader">
       <?= $pager_result['total'] ?> <?= lang('general_label_total_element') ?>
    </div>
    <div class="card-block">
        <?php $preprendId = uniqid(); ?>
        <form action="<?= site_url($baseUrl) ?>" method="get" accept-charset="utf-8" class="FilterForm">
            <div class="form-group">
                <label for="<?= $preprendId ?>name" class="form-label"><?= lang('setting_label_filter_search'); ?></label>
                <input type="text" class="form-control" name="name" id="<?= $preprendId ?>name" value="<?= html_escape($filters->getValue('name')) ?>">
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
                'query_key' => 'name',
                'label' => 'lang:setting_label_name'
            ],
            [
                'query_key' => 'value',
                'label' => 'lang:setting_label_value',
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
