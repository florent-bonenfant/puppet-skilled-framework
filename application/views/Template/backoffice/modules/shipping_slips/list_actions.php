<?php if (route_is_accessible('backoffice/modules/shipping/view/' . $this->fetch('item')->document_number)) : ?>
<?= anchor(
    'backoffice/modules/shipping_slips/download/' . $this->fetch('item')->id,
    '<i class="material-icons">pageview</i>',
    [
        'class' => 'btn btn-sm btn-primary',
        'title' => lang('general_action_view'),
        'data-toggle' => "tooltip",
        'data-placement' => 'top',
    ]
) ?>
<?php endif; ?>
