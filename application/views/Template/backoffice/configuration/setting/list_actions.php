<?= navigation_anchor(
    'backoffice/configuration/setting/edit/' . $this->fetch('item')->name,
    '<i class="material-icons">mode_edit</i>',
    [
        'class' => 'btn btn-sm btn-primary',
        'title' => lang('general_action_edit')
    ],
    true,
    false
) ?>
