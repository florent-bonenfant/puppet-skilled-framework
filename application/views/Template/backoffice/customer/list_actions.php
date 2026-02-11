<?php if (!$this->fetch('item')->isLocked()) : ?>
    <?php //var_dump(json_encode($this->fetch('item')->users()->get())) ?>
    <?php if (route_is_accessible('backoffice/customer/edit/' . $this->fetch('item')->getRouteKey())) : ?>
        <?= anchor(
            'backoffice/customer/edit/' . $this->fetch('item')->getRouteKey(),
            '<i class="material-icons">edit</i>',
            [
                'class' => 'btn btn-sm btn-primary',
                'title' => lang('general_action_edit'),
                'data-toggle' => "tooltip",
                'data-placement' => 'top',
            ]
        ) ?>

        <?php if (route_is_accessible('backoffice/customer/delete/' . $this->fetch('item')->getRouteKey()) . '#ci_profiler_session_data_modal') : ?>
            <?= csrf_anchor(
                'backoffice/customer/delete/' . $this->fetch('item')->getRouteKey(),
                '<i class="material-icons">settings</i>',
                [
                    'class' => 'btn btn-sm btn-primary modal-password',
                    'title' => lang('customer_message_edit_password'),
                    // 'data-toggle' => "modal",
                    // 'data-placement' => 'top',
                    // 'data-modal' => '<b>modal</b>',
                    // 'data-title' => '<b>title</b>',
                    // 'data-body' => '<b>body</b>',
                    'data-users' => urlencode(json_encode($this->fetch('item')->users)),
                    'id' =>  $this->fetch('item')->getRouteKey()
                ]
            ) ?>
            <?= csrf_anchor(
                'backoffice/customer/delete/' . $this->fetch('item')->getRouteKey(),
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
    <?php endif; ?>
<?php else : ?>
    <?= lang('general_message_already-lock') ?>
<?php endif; ?>
