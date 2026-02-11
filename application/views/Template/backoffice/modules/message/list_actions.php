<?php
    $item = $this->fetch('item');
    if (!$item->deleted_at) :
?>

    <?= anchor(
        'backoffice/modules/message/view/' . $item->getRouteKey(),
        '<i class="material-icons">pageview</i>',
        [
            'class' => 'btn btn-sm btn-primary',
            'title' => lang('general_action_view'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
        ],
        true,
        false
    ) ?>
    <?= anchor(
        'backoffice/modules/message/edit/' . $item->getRouteKey(),
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
    <?php if (route_is_accessible('backoffice/modules/message/delete/' . $item->getRouteKey())) : ?>
    <?= csrf_anchor(
        'backoffice/modules/message/delete/' . $item->getRouteKey(),
        '<i class="material-icons">delete</i>',
        [
            'class' => 'btn btn-sm btn-danger',
            'title' => lang('general_action_delete'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
            'data-confirm' => lang('general_message_delete-confirm')
        ]
    ) ?>
    <?php endif; ?>
<?php else :?>
    <?= csrf_anchor(
        'backoffice/modules/message/restore/' . $item->getRouteKey(),
        '<i class="material-icons">restore</i>',
        [
            'class' => 'btn btn-sm btn-danger',
            'title' => lang('general_action_restore'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
            'data-confirm' => lang('general_message_restore-confirm')
        ]
    ) ?>
<?php endif;
