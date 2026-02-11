<?php
    $ContentModel = $this->fetch('ContentModel');
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
                <label for="<?= $preprendId ?>content" class="form-label"><?= lang('page_label_filter_search'); ?></label>
                <input type="text" class="form-control" name="content" id="<?= $preprendId ?>content" value="<?= html_escape($filters->getValue('content')) ?>">
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
                'query_key' => 'title_key',
                'label' => 'lang:page_label_title',
            ],
            [
                'label' => '',
                'class' => 'table-actions',
                'formater' => function ($item) {
                    return $this->element('content_admin/list_actions', ['item' => $item]);
                }
            ],
        ],
    ]
); ?>
