<div class="modal fade js-modal-password" id="" role="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= lang('customer_title_modal') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url($this->fetch('base_url') . '/backoffice/user/password/') ?>" method="post" accept-charset="utf-8">
                    <?= form_csrf_input() ?>
                    <div class="card-block">
                        <?= $this->element(
                            'form/block_input',
                            [
                                'name' => 'users',
                                'input_element' => 'form/select',
                                'label' => 'lang:user_label_user_to_update',
                                'options' => []
                            ]
                        ) ?>
                        <?= $this->element(
                            'form/block_input',
                            [
                                'name' => 'password',
                                'input_element' => 'form/input',
                                'label' => 'lang:user_label_password',
                                'id' => 'password',
                                'extra' => [
                                    'type' => 'password',
                                    'autocomplete' => 'new-password'
                                ]
                            ]
                        ) ?>
                        <?= $this->element(
                            'form/block_input',
                            [
                                'name' => 'repeat_password',
                                'input_element' => 'form/input',
                                'label' => 'lang:user_label_repeat_password',
                                'id' => 'repeat_password',
                                'extra' => [
                                    'type' => 'password',
                                    'autocomplete' => 'new-password'
                                ]
                            ]
                        ) ?>
                    </div>
                    </fieldset>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('general_action_cancel') ?></button>
                        <button type="submit" class="btn btn-primary js-dialog-confirm" <?= _attributes_to_string($this->fetch('submit_button_attributes') ?? []) ?>>
                            <?= lang('general_action_save') ?? $this->fetch('confirm_label') ?? lang('general_action_confirm') ?>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>