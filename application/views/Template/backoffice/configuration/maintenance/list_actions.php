<?php
$item = $this->fetch('item');
$now = new DateTime(); ?>
    <?= navigation_anchor(
        'backoffice/configuration/maintenance/edit/' . $this->fetch('item')->getRouteKey(),
        '<i class="material-icons">mode_edit</i>',
        [
            'class' => 'btn btn-sm btn-primary',
            'title' => lang('general_action_edit'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
        ],
        true,
        false
    )?>
    <?= csrf_anchor(
        'backoffice/configuration/maintenance/delete/' . $this->fetch('item')->getRouteKey(),
        '<i class="material-icons">delete</i>',
        [
            'class' => 'btn btn-sm btn-danger',
            'title' => lang('general_action_delete'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
            'data-confirm' => lang('general_message_delete-confirm')
        ]
    )?>

