<?= $this->element(
    'crud/global_actions',
    [
        'actions' => [
            [
                'uri' => 'backoffice/user/add/',
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
                <label for="<?= $preprendId ?>search" class="form-label"><?= lang('user_label_filter_search'); ?></label>
                <input type="text" class="form-control" name="search" id="<?= $preprendId ?>search" value="<?= html_escape($filters->getValue('search')) ?>">
            </div>

            <div class="form-group">
                <label for="<?= $preprendId ?>role" class="form-label"><?= lang('user_label_roles'); ?></label>
                <select class="form-control" name="role" id="<?= $preprendId ?>role">
                <option value=""><?= lang('log_label_filter_select_all') ?></option>
                <?php foreach (array_pluck($this->fetch('roles'), 'name', 'id') as $role => $role_info) : ?>
                    <option value="<?= $this->fetch('role_slugs')[$role]; ?>" <?= ($filters->getValue('role') == $this->fetch('role_slugs')[$role] ? 'selected="selected"' : ''); ?>><?= $role_info->value; ?></option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
              <?= $this->element(
                  'form/label',
                  [
                      'label' => 'lang:user_label_enable',
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
<?php
$modules_names = [];
foreach (array_pluck($this->fetch('modules'), 'name', 'permission') as $k => $m) {
    $modules_names[$k] = $m->value;
}
?>
<?= $this->element(
    'crud/list',
    [
       'pager'  => $this->fetch('pager'),
       'displayed_fields' => [
           [
               'query_key' => 'username',
               'label' => 'lang:user_label_username',
           ],
           [
               'query_key' => 'name',
               'label' => 'lang:user_label_last-and-first-name',
               'formater' => function ($item) {
                    return html_escape($item->last_name . ' ' . $item->first_name);
               }
           ],
           [
               'query_key' => 'roles',
               'label' => 'lang:user_label_roles',
               'formater' => function ($item) {
                    $roles = [];
                    foreach ($item->rolesDefault as $role) {
                        $roles[] = $role->name;
                    }
                    return implode('<br>', $roles);
               }
           ],
           [
               'query_key' => 'modules',
               'label' => 'lang:user_label_modules',
               'formater' => function ($item) use ($modules_names) {

                    $role = $item->rolesDefault[0];

                    if ($role->slug === $this->fetch('role_slugs')['manager']) {
                        $modules = [];
                        foreach ($item->modules as $m) {
                            $modules[] = $modules_names[$m->permission_name];
                        }
                        return implode('<br>', $modules);
                    } else {
                        return lang('user_label_modules_all');
                    }
               }
           ],
           [
               'query_key' => 'active',
               'label' => 'lang:user_label_enable',
               'class' => 'table-actions',
               'formater' => function ($item) {
                    return $this->element('crud/active_action', ['item' => $item]);
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
