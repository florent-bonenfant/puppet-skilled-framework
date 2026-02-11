<?php
$filters = $this->fetch('filters');
$pager = $this->fetch('pager')->getResult();
$baseUrl = $this->fetch('base_url') ?: current_base_url();
$companies = $this->fetch('companies');
$families = $this->fetch('families');
?>

<?= $this->element(
    'crud/global_actions',
    [
        'actions' => [
            [
                'uri' => 'backoffice/modules/message/add/',
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
            <?= $this->element(
            'form/block_input',
                [
                    'name' => 'title',
                    'input_element' => 'form/input',
                    'label' => 'lang:message_label_filter_title',
                    'id' => $preprendId . 'title',
                    'default_value' => $item->title ?? null,
                ]
            ) ?>

            <div class="form-group">
              <?= $this->element(
                  'form/label',
                  [
                      'label' => 'lang:message_label_companies',
                      'field' => 'companies[]',
                      'extra' => ['for' => $preprendId . 'companies']
                  ]
              ) ?>
              <?= $this->element(
                'form/checkbox_inline',
                [
                    'name' => 'companies[]',
                    'default_value' => $filters->getValue('companies'),
                    'options' => array_pluck($companies, 'name', 'id')
                ]
              ) ?>
            </div>
            <div class="form-group">
              <?= $this->element(
                  'form/label',
                  [
                      'label' => 'lang:message_label_families',
                      'field' => 'families[]',
                      'extra' => ['for' => $preprendId . 'families']
                  ]
              ) ?>
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
              <?= $this->element(
                  'form/label',
                  [
                      'label' => 'lang:message_label_filter_show_deleted',
                      'field' => 'deleted[]',
                      'extra' => ['for' => $preprendId . 'deleted']
                  ]
              ) ?>
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
               'query_key' => 'title',
               'label' => 'lang:message_label_title',
           ],
           [
               'query_key' => 'company',
               'label' => 'lang:message_label_companies',
               'formater' => function ($item) {
                  foreach ($item->companies as $comp) {
                    echo html_escape($comp->name) . '<br/>';
                  }
               }
           ],
           [
               'query_key' => 'family',
               'label' => 'lang:message_label_families',
               'formater' => function ($item) {
                  foreach ($item->families as $fam) {
                    echo html_escape($fam->name) . '<br/>';
                  }
               }
           ],
           [
               'query_key' => 'order',
               'label' => 'lang:message_label_order',
           ],
           [
               'query_key' => 'publication_date',
               'label' => 'lang:message_label_publication_date',
               'formater' => function ($item) {
                  if ($item->publication_date) {
                      return user_date_format($item->publication_date, false);
                  }
               }
           ],
           [
               'query_key' => 'end_publication_date',
               'label' => 'lang:message_label_end_publication_date',
               'formater' => function ($item) {
                  if ($item->end_publication_date) {
                      return user_date_format($item->end_publication_date, false);
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
