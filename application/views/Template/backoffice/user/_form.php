<?php
$preprendId = uniqid();
$item = $this->fetch('item');
$extra = $this->fetch('extra');
?>
<?= form_open($this->fetch('validator'), current_url(), ['class' => 'user_form']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('user_label_general') ?></h2>
    <div class="card-block">

    <?= $this->element(
        'form/block_input',
        [
            'name' => 'first_name',
            'input_element' => 'form/input',
            'label' => 'lang:user_label_first-name',
            'id' => $preprendId . 'first_name',
            'default_value' => $item->first_name ?? null,
        ]
    ) ?>

    <?= $this->element(
        'form/block_input',
        [
            'name' => 'last_name',
            'input_element' => 'form/input',
            'label' => 'lang:user_label_last-name',
            'id' => $preprendId . 'last_name',
            'default_value' => $item->last_name ?? null,
        ]
    ) ?>

    <?= $this->element(
        'form/block_input',
        [
            'name' => 'email',
            'input_element' => 'form/input',
            'label' => 'lang:user_label_email',
            'id' => $preprendId . 'email',
            'default_value' => $item->email ?? null,
        ]
    ) ?>
    </div>
</fieldset>

<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('user_label_change_password') ?></h2>
    <div class="card-block">
    <?= $this->element(
        'form/block_input',
        [
            'name' => 'password',
            'input_element' => 'form/input',
            'label' => 'lang:user_label_password',
            'id' => $preprendId . 'password',
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
            'id' => $preprendId . 'repeat_password',
            'extra' => [
                'type' => 'password',
                'autocomplete' => 'new-password'
            ]
        ]
    ) ?>
    </div>
</fieldset>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('user_label_permissions') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'role',
                'input_element' => 'form/select',
                'label' => 'lang:user_label_roles',
                'id' => $preprendId . 'roles',
                'options' => array_pluck($this->fetch('roles'), 'name', 'id'),
                'default_value' => ($item ? array_pluck($item->roles()->default()->get(), 'id') : []),
            ]
        ) ?>
        <div class="form-group form-group-modules">
            <?= $this->element(
                'form/label',
                [
                    'label' => 'lang:user_label_modules',
                    'field' => 'modules[]',
                    'extra' => ['for' => $preprendId . 'modules']
                ]
            ) ?>
            <?= $this->element(
                'form/checkbox',
                [
                    'name' => 'modules[]',
                    'default_value' => ($item ? array_pluck($item->modules, 'permission_name') : []),
                    'id' => $preprendId . 'modules',
                    'extra' => '',
                    'options' => array_pluck($this->fetch('modules'), 'name', 'permission')
                ]
            ) ?>
        <?php if ($this->fetch('help')) : ?>
            <small class="form-text text-muted"><?= lang_libelle($this->fetch('help')) ?></small>
        <?php endif; ?>
        </div>
    </div>
</fieldset>

<?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
<?php
$this->asset->enqueueInlineScriptStart();
?>
<script>
$(document).ready(function() {
    var preprendId = '<?= $preprendId ?>';
    var roleManager = '<?= $extra['role_manager'] ?>';
    switchAffRoles();
    $('#' + preprendId + 'roles').change(function() {
        switchAffRoles();
    });
    function switchAffRoles() {
        var $block = $('.form-group-modules');
        var $optionRole = $('#' + preprendId + 'roles option[value=' + roleManager + ']:selected');
        if ($optionRole.length != 0) {
            $block.css('display', 'block');
        } else {
            $block.css('display', 'none');
        }
    }
});
</script>
<?php $this->asset->enqueueInlineScriptEnd(); ?>
