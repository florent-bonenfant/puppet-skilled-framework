<?php
$filters = $this->fetch('filters');
$pager = $this->fetch('pager')->getResult();
$baseUrl = $this->fetch('base_url') ?: current_base_url();
$families = $this->fetch('families');
?>

<?= $this->element(
    'crud/global_actions',
    [
        'actions' => [
            [
                'uri' => 'backoffice/modules/application/add/',
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

<div class="card card-filter mb-4">
    <div class="card-header FilterHeader">
       <?= $pager['total'] ?> <?= lang('general_label_total_element') ?>
    </div>

    <div class="card-block">
        <?php $preprendId = uniqid(); ?>
        <form action="<?= site_url($baseUrl) ?>" method="get" accept-charset="utf-8" class="FilterForm">
            <div class="form-group">
                <label for="<?= $preprendId ?>label" class="form-label"><?= lang('application_label_filter_label'); ?></label>
                <input type="text" class="form-control" name="label" id="<?= $preprendId ?>label" value="<?= html_escape($filters->getValue('label')) ?>">
            </div>
            <div class="form-group">
              <label class="form-label"><?= lang('application_label_families'); ?></label><br/>
              <?= $this->element(
                  'form/checkbox_inline',
                  [
                      'name' => 'families[]',
                      'default_value' => $filters->getValue('families'),
                      'options' => array_pluck($families, 'name', 'id')
                  ]
              ) ?>
            </div>
            <div class="form-group">
              <label class="form-label"><?= lang('application_label_filter_show_deleted'); ?></label><br/>
                <?= $this->element(
                  'form/radio_inline',
                  [
                    'name' => 'deleted',
                    'default_value' => ($filters->getValue('deleted') ? '1' : '0'),
                    'options' => [
                        '1' => lang('general_yes'),
                        '0' => lang('general_no'),
                    ],
                  ]
                ) ?>
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

<?= $this->block(
    'list',
    [
       'pager'  => $this->fetch('pager'),
       'displayed_fields' => [
           [
               'query_key' => 'label',
               'label' => 'lang:application_label_label',
           ],
           [
               'query_key' => 'family',
               'label' => 'lang:application_label_families',
               'formater' => function ($item) {
                  foreach ($item->families as $fam) {
                    echo html_escape($fam->name) . '<br/>';
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