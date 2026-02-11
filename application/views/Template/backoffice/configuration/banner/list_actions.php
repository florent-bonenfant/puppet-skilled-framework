
<?php
$item = $this->fetch('item');
$baseUrl = 'backoffice/configuration/banner/';
$disable = !$item->deleted_at;

if (!$item->deleted_at) :
    echo csrf_anchor(
        $baseUrl . '/active_toggle/' . $this->fetch('item')->getRouteKey(),
        '<i class="material-icons">lock_open</i>',
        [
            'class' => 'btn btn-sm btn-success' . (!$item->deleted_at ? ' disabled' : ''),
            'title' => lang('general_action_inactive'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
            'data-confirm' => lang('general_message_disable-confirm')
        ],
        false
    );
else :
    echo csrf_anchor(
        $baseUrl . '/active_toggle/' . $this->fetch('item')->getRouteKey(),
        '<i class="material-icons">lock</i>',
        [
            'class' => 'btn btn-sm btn-danger' . (!$item->deleted_at ? ' disabled' : ''),
            'title' => lang('general_action_active'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
            'data-confirm' => lang('general_message_enable-confirm')
        ],
        false
    );
endif;
echo csrf_anchor(
    $baseUrl . '/edit/' . $this->fetch('item')->getRouteKey(),
    '<i class="material-icons">edit</i>',
    [
        'class' => 'btn btn-sm btn-primary',
        'title' => lang('general_action_edit'),
        'data-toggle' => "banner",
        'data-placement' => 'top',
    ]
);
