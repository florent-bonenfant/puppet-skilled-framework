<?php
    $preprendId = uniqid();
    $item = $this->fetch('item');
?>
<?= form_open($this->fetch('validator'), current_url(), ['class' => 'profile_form']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('profile_label_personal') ?></h2>
    <div class="card-block">

    <?= $this->element(
        'form/block_input',
        [
            'name' => 'first_last_name',
            'input_element' => 'form/info',
            'label' => 'lang:profile_label_first_last_name',
            'id' => $preprendId . 'first_last_name',
            'default_value' => $item->first_name . " " . $item->last_name
        ]
    ) ?>

    <?php
        $role = $item->roles()->default()->first();
        if ($role->slug === $this->fetch('role_slugs')['manager']) :
            $modules = $this->fetch('modules');
            ?>
                <label  class="form-control-label"><?= lang('profile_label_module'); ?></label>
                <p>
            <?php
                $module_names = [];
                foreach (array_pluck($modules, 'name', 'permission') as $k => $m) {
                    $module_names[$k] = $m->value;
                }
                $modules = [];
                foreach ($item->modules as $m) {
                    echo $module_names[$m->permission_name] . '<br/>';
                }
                ?>
                </p>
                <?php
        endif;
    ?>

    <?= $this->element(
        'form/block_input',
        [
            'name' => 'email',
            'input_element' => 'form/input',
            'label' => 'lang:profile_label_email',
            'id' => $preprendId . 'email',
            'default_value' => $item->email
        ]
    ) ?>

    </div>
</fieldset>

<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('profile_label_authentication') ?></h2>
    <div class="card-block">

        <?= $this->element(
            'form/block_input',
            [
                'name' => 'password',
                'input_element' => 'form/input',
                'label' => 'lang:profile_label_password',
                'id' => $preprendId . 'password',
                'default_value' => '',
                'extra' => [
                    'type' => 'password'
                ]
            ]
        ) ?>

        <p><?= lang('authentication_password_rules'); ?></p>

        <?= $this->element(
            'form/block_input',
            [
                'name' => 'password_confirm',
                'input_element' => 'form/input',
                'label' => 'lang:profile_label_password_confirm',
                'id' => $preprendId . 'password_confirm',
                'default_value' => '',
                'extra' => [
                    'type' => 'password'
                ]
            ]
        ) ?>
    </div>
</fieldset>
<?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
