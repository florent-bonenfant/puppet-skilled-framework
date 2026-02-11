<?php
if (route_is_accessible('backoffice')) {
  echo $this->element(
      'crud/global_actions',
      [
          'actions' => [
              [
                  'uri' => 'backoffice/customer/sync',
                  'label' =>  '<i class="material-icons">import_export</i> ' .  lang('customer_action_sync'),
                  'extra' => [
                      'title' => lang('customer_action_sync'),
                      'class' => 'btn btn-primary',
                  ]
              ]
          ]
      ]
  );
}
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
                <label for="<?= $preprendId ?>search" class="form-label"><?= lang('customer_label_filter_search'); ?></label>
                <input type="text" class="form-control" name="search" id="<?= $preprendId ?>search" value="<?= html_escape($filters->getValue('search')) ?>">
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
            <div class="form-group">
              <?= $this->element(
                  'form/label',
                  [
                      'label' => 'lang:customer_label_enable',
                      'field' => 'active[]',
                      'extra' => ['for' => $preprendId . 'active']
                  ]
              ) ?>
                <?= $this->element(
                  'form/radio_inline',
                  [
                    'name' => 'active',
                    'default_value' => ($filters->getValue('active') ? '1' : '0'),
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

<?= $this->element(
    'crud/list',
    [
       'pager'  => $this->fetch('pager'),
       'displayed_fields' => [
            [
                'query_key' => 'created_at',
                'label' => 'lang:customer_label_created_at',
                'header_class' => 'text-nowrap',
                'formater' => function ($item) {
                    return user_date_format($item->created_at ?? '', true);
                }
            ],
           [
               'query_key' => 'id',
               'label' => 'lang:customer_label_id',
           ],
           [
               'query_key' => 'email',
               'label' => 'lang:customer_label_email',
           ],
           [
               'query_key' => 'name',
               'label' => 'lang:customer_label_last-and-first-name',
               'formater' => function ($item) {
                   return html_escape($item->last_name . ' ' . $item->first_name);
               }
           ],
           [
               'query_key' => 'city',
               'label' => 'lang:customer_label_city',
               'formater' => function ($item) {
                   return str_replace(' ', '&nbsp;', $item->city ?? null);
               }
           ],
           [
               'query_key' => 'family',
               'label' => 'lang:customer_label_family',
               'formater' => function ($item) {
                   return str_replace(' ', '&nbsp;', $item->family->name ?? null);
               }
           ],
           [
               'query_key' => 'company',
               'label' => 'lang:customer_label_company',
               'formater' => function ($item) {
                   return str_replace(' ', '&nbsp;', $item->company->name);
               }
           ],
           [
               'query_key' => 'active',
               'label' => 'lang:customer_label_enable',
               'class' => 'table-actions',
               'formater' => function ($item) {
                   return $this->element('crud/active_action', [
                       'item' => $item,
                       'disabled' => !$item->email,
                   ]);
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

<?= $this->block('modal_password') ?>

<?php $this->asset->enqueueInlineScriptStart(); ?>
<script>
    $(function() {
        $('.modal-password').on('click', function(e) {
            e.preventDefault();
            let users = JSON.parse(decodeURIComponent($(this).data('users'))),
                id = e.currentTarget.id;

            $modal = $('.js-modal-password');
            function resetModal($modal) {
                // Initialisation
                $modal.find('input, select').removeClass('form-control-danger').val('');
                $modal.find('input, select').parent().removeClass('has-danger').val('');
                $modal.find('.form-control-feedback').remove();
                $modal.find('select[name=users]').empty();

                // Remplissage des valeurs
                users.map(user => {
                    $modal.find('select[name=users]').append('<option value="'+user.id+'">'+user.email+'</option>');
                });
            }

            resetModal($modal);
            $modal.modal('show');

            // Soumission
            $modal.find('button[type=submit]').on('click', function(eb) {
                eb.preventDefault();
                let that = $(this),
                    formData = {
                        password: $modal.find('input[name=password]').val(),
                        repeat_password: $modal.find('input[name=repeat_password]').val(),
                        users: $modal.find('select[name=users]').val(),
                        <?= get_instance()->security->get_csrf_token_name() ?>: '<?= html_escape(get_instance()->security->get_csrf_hash()) ?>'
                    };
                $.ajax(
                    $modal.find('form').attr('action'),
                    {
                        method: 'POST',
                        data: formData,
                        async: true,
                        headers: {'X-REFERER-URL': encodeURIComponent(location.href)}, // send referer as header
                    }
                    ).fail(function(xhr, status, error) {
                        resetModal($modal);
                        let data = xhr?.responseJSON;
                        for(var error in data) {
                            let input = error === 'users' ? 'select' : 'input';
                            $modal.find(input + '[name='+error+']').addClass('form-control-danger');
                            $modal.find(input + '[name='+error+']').parent().addClass('has-danger');
                            $modal.find(input + '[name='+error+']').parent().append('<div class="form-control-feedback">'+data[error]+'</div>');
                        }
                }).done(function(data, status, xhr) {
                    resetModal($modal);
                    $('.modal').modal('hide');
                });
            })
        });
    });
</script>
<?php $this->asset->enqueueInlineScriptEnd(); ?>