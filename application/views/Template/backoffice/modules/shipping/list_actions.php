<?php if (route_is_accessible('backoffice/modules/shipping/view/' . $this->fetch('item')->document_number)) : ?>
<?= anchor(
    'backoffice/modules/shipping/view/' . $this->fetch('item')->id,
    '<i class="material-icons">pageview</i>',
    [
        'class' => 'btn btn-sm btn-primary',
        'title' => lang('general_action_view'),
        'data-toggle' => "tooltip",
        'data-placement' => 'top',
    ]
) ?>
<?php endif; ?>
<?php
$item = $this->fetch('item');
if (!$item->isLocked()) : ?>
<?php if (!empty($item->file_name) && route_is_accessible('backoffice/modules/shipping/delete/' . $this->fetch('item')->getRouteKey())) : ?>
<?= csrf_anchor(
    'backoffice/modules/shipping/delete/' . $this->fetch('item')->getRouteKey(),
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
<?php else : ?>
    <?= lang('general_message_already-lock') ?>
<?php endif;
