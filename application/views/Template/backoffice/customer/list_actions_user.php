<?php if (!$this->fetch('customerUser')->isLocked()) : ?>
    <?php if (route_is_accessible('backoffice/user/edit/' . $this->fetch('customerUser')->getRouteKey())) : ?>
    <?= anchor(
        'backoffice/user/edit/' . $this->fetch('customerUser')->getRouteKey(),

        '<i class="material-icons">edit</i>',
        [
            'class' => 'btn btn-sm btn-primary',
            'title' => lang('general_action_edit'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
        ]
    ) ?>
    <?php endif; ?>

    <?php if (route_is_accessible('backoffice/customer/unlink/' . $this->fetch('customerUser')->id . '/' . $this->fetch('customerUser')->getRouteKey())) : ?>
    <?= csrf_anchor(
        'backoffice/customer/unlink/' . $this->fetch('customer')->id . '/' . $this->fetch('customerUser')->getRouteKey(),
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
<?php endif; ?>
