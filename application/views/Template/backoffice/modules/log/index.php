<?php
$filters = $this->fetch('filters');
$pager = $this->fetch('pager');
$pager_result = $pager->getResult();
$baseUrl = $this->fetch('base_url') ?: current_base_url();
$locations = $this->fetch('locations');

echo $this->element(
    'crud/global_actions',
    [
        'actions' => [
            [
                'uri' => 'backoffice/modules/log/export',
                'label' =>  '<i class="material-icons">import_export</i> ' .  lang('log_action_export'),
                'extra' => [
                    'title' => lang('log_action_export'),
                    'class' => 'btn btn-primary',
                ]
            ]
        ]
    ]
);
?>
<div class="card card-filter mb-4">
    <div class="card-header FilterHeader">
       <?= $pager_result['total'] ?> <?= lang('general_label_total_element') ?>
    </div>

    <div class="card-block">
        <?php $preprendId = uniqid(); ?>
        <form action="<?= site_url($baseUrl) ?>" method="get" accept-charset="utf-8" class="FilterForm">
            <!-- #SELECT FILTER -->
            <div class="form-group">
              <label class="form-control-label" for="<?= $preprendId ?>location"><?= lang('log_label_filter_module'); ?></label>
              <?php
                  $config_select = [
                      'name' => 'location',
                      'id'    => $preprendId . 'location',
                      'class' => 'form-control',
                  ];
                  $selected = (array) $filters->getValue('location');

                  if (count($selected) > 1) {
                      $config_select['multiple'] = 'multiple';
                  }

                  if (($error = form_error('location', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
                      $config_select['class'] .= ' form-control-danger';
                  }
                  ?>
                  <select <?= _attributes_to_string($config_select) ?>>
                       <option value="" <?= ((is_required_field('location')) ? 'disabled' : '')?>><?= lang('log_label_filter_select_all') ?></option>
                  <?php
                  foreach ($locations as $opt) :
                    $key = $opt->slug;
                  ?>
                      <option value="<?= html_escape($key) ?>" <?= set_select('location', $key, in_array($key, $selected)) ?> >
                      <?= lang_libelle($opt->title) ?>
                      </option>
                  <?php
                  endforeach;
                  ?>
                  </select>
                  <?= $error ?>
              </div>
            <!-- #END SELECT FILTER -->
            <div class="form-group">
                <label for="<?= $preprendId ?>customer_info" class="form-control-label"><?= lang('customer_label_filter_search'); ?></label><br />
                <input type="text" class="form-control" name="customer_info" id="<?= $preprendId ?>customer_info" value="<?= html_escape($filters->getValue('customer_info')) ?>">
            </div>
            <div class="form-group">
              <label class="form-label"><?= lang('customer_label_company'); ?></label><br/>
              <?= $this->element(
                  'form/checkbox_inline',
                  [
                      'name' => 'companies[]',
                      'default_value' => $filters->getValue('companies'),
                      'options' => array_pluck($this->fetch('companies'), 'name', 'id')
                  ]
              ) ?>
            </div>
            <div class="form-group">
              <label class="form-label"><?= lang('customer_label_family'); ?></label><br/>
              <?= $this->element(
                  'form/checkbox_inline',
                  [
                      'name' => 'families[]',
                      'default_value' => $filters->getValue('families'),
                      'options' => array_pluck($this->fetch('families'), 'name', 'id')
                  ]
              ) ?>
            </div>
            <!-- #DATE FILTERS -->
            <div class="form-group">
                <label class="form-control-label"><?= lang('log_label_filter_date'); ?></label><br />
                <div class="form-group-inline">
                    <label for="<?= $preprendId ?>date_before"><?= lang('log_label_filter_date_before'); ?></label>
                    <input <?= _attributes_to_string(['type' => 'text', 'name' => 'date_before', 'class' => 'form-control js-datepicker flatpickr-input', 'id' => $preprendId . 'date_before', 'placeholder' => lang('general_label_datepicker_format'), 'value' => $filters->getValue('date_before')])   ?> />
                </div>
                <div class="form-group-inline">
                    <label for="<?= $preprendId ?>date_after"><?= lang('log_label_filter_date_after'); ?></label>
                    <input <?= _attributes_to_string(['type' => 'text', 'name' => 'date_after', 'class' => 'form-control  js-datepicker flatpickr-input', 'id' => $preprendId . 'date_after', 'placeholder' => lang('general_label_datepicker_format'), 'value' => $filters->getValue('date_after')]) ?> />
                </div>
            </div>
            <!-- #END DATE FILTERS -->
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
       'pager'  => $pager,
       'displayed_fields' => [
            [
                'query_key' => 'created_at',
                'label' => 'lang:log_label_date',
                'header_class' => 'text-nowrap',
                'formater' => function ($item) {
                return date_format_complete($item->created_at);
                }
            ],
            [
                'query_key' => 'admin_id',
                'label' => 'lang:log_label_admin',
                'formater' => function ($item) {
                    return $item->admin->username ?? null;
                }
            ],
           [
               'query_key' => 'customer_id',
               'label' => 'lang:log_label_code'
           ],
           [
               'query_key' => 'customer',
               'label' => 'lang:customer_label_email',
               'formater' => function ($item) {
                   return $item->email ?: $item->customer->email ?? null;
               }
           ],
           [
               'query_key' => 'name',
               'label' => 'lang:customer_label_last-and-first-name',
               'formater' => function ($item) {
                   return $item->email ? html_escape($item->last_name . ' ' . $item->first_name) :  html_escape($item->customer->last_name . ' ' . $item->customer->first_name) ;
               }
           ],
           [
               'query_key' => 'city',
               'label' => 'lang:customer_label_city',
               'formater' => function ($item) {
                   return $item->email ? str_replace(' ', '&nbsp;', $item->city ?? null) : $item->customer->city ?? null;
               }
           ],
           [
               'query_key' => 'family',
               'label' => 'lang:customer_label_family',
               'formater' => function ($item) {
                   return $item->email ? str_replace(' ', '&nbsp;', $item->family->name ?? null) : $item->customer->family->name ?? null;
               }
           ],
           [
               'query_key' => 'company',
               'label' => 'lang:customer_label_company',
               'formater' => function ($item) {
                   return $item->email ? str_replace(' ', '&nbsp;', $item->company->name ?? null) : $item->customer->company->name ?? null;
               }
           ],
           [
               'query_key' => 'location',
               'label' => 'lang:log_label_module',
               'formater' => function ($item) use ($locations) {
                    foreach ($locations as $loc) {
                        if ($item->location_slug == $loc->slug) {
                            return $loc->title;
                        }
                    }
                    return '';
               }
           ],
        ],
    ]
);

$this->asset->enqueueStyle('flatpickr.css');
$this->asset->enqueueScript('locales.js');

