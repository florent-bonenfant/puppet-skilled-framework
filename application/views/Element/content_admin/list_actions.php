<?= navigation_anchor(
    current_base_url() . '/edit/' . $this->fetch('item')->slug,
    '<i class="material-icons">mode_edit</i>',
    [
        'class' => 'btn btn-sm btn-primary',
        'title' => lang('general_action_edit'),
        'data-toggle' => "tooltip",
        'data-placement' => 'top',
    ],
    true,
    false
) ?>
