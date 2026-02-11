
<?php
$item = $this->fetch('item');
$baseUrl = 'backoffice/configuration/carrier/';

echo csrf_anchor(
    $baseUrl . '/edit/' . $this->fetch('item')->getRouteKey(),
    '<i class="material-icons">edit</i>',
    [
        'class' => 'btn btn-sm btn-primary',
        'title' => lang('general_action_edit'),
        'data-toggle' => "carrier",
        'data-placement' => 'top',
    ]
);
if (route_is_accessible($baseUrl . '/delete/' . $this->fetch('item')->getRouteKey())) :
    echo csrf_anchor(
        $baseUrl . '/delete/' . $this->fetch('item')->getRouteKey(),
        '<i class="material-icons">delete</i>',
        [
            'class' => 'btn btn-sm btn-danger',
            'title' => lang('general_action_delete'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
            'data-confirm' => lang('general_message_delete-confirm')
        ]
        );
endif;