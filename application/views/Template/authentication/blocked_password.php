<?php $preprendId = uniqid(); ?>

<div class="col text-center">
    <p><?= lang('authentication_blocked_password_text') ?></p>
</div>

<?= form_open($this->fetch('validator'), 'authentication/blocked_password', ['class' => 'forgot_password']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('authentication_title_blocked_password') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'username',
                'input_element' => 'form/input',
                'label' => 'lang:authentication_label_username',
                'id' =>  $preprendId . 'username'
            ]
        ) ?>
    </div>
</fieldset>
<div class="text-center">
    <button type='submit' class="btn btn-primary"><?= lang('authentication_label_forgot_submit') ?></button>
    <?= anchor('authentication/login', lang('authentication_label_back-to-login'), ['class' => 'btn btn-link']) ?>
</div>
