<?= navigation_anchor(
    'backoffice/configuration/role/edit/' . $this->fetch('item')->getRouteKey(),
    '<i class="material-icons">mode_edit</i>',
    [
        'class' => 'btn btn-sm btn-primary',
        'title' => lang('general_action_edit')
    ],
    true,
    false
) ?>
