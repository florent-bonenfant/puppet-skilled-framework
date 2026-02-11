<?php
$item = $this->fetch('item');
if (empty($item->file_name) && route_is_accessible('backoffice/modules/furniture/edit/' . $this->fetch('item')->document_number)) : ?>
<?= anchor(
    'backoffice/modules/furniture/edit/' . $this->fetch('item')->id,
    '<i class="material-icons">edit</i>',
    [
        'class' => 'btn btn-sm btn-primary',
        'title' => lang('general_action_edit'),
        'data-toggle' => "tooltip",
        'data-placement' => 'top',
    ]
) ?>
<?php endif; ?>
<?php
if (!$item->isLocked()) : ?>
<?php if (!empty($item->file_name) && route_is_accessible('backoffice/modules/furniture/delete/' . $this->fetch('item')->getRouteKey())) : ?>
<?= csrf_anchor(
    'backoffice/modules/furniture/delete/' . $this->fetch('item')->getRouteKey(),
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
