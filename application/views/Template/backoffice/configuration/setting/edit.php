<?php $preprendId = uniqid(); ?>
<?= form_open($this->fetch('validator'), current_url()) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('setting_label_fieldset-information') ?></h2>
    <div class="card-block">
    <?= $this->element(
        'form/block_input',
        [
            'name' => 'name',
            'input_element' => 'form/input',
            'label' => 'lang:setting_label_name',
            'id' => $preprendId . 'title',
            'default_value' => $this->fetch('item')->name,
            'extra' => [
                'readonly' => 'readonly',
            ]
        ]
    ) ?>
    <?= $this->element(
        'form/block_input',
        [
            'name' => 'value',
            'input_element' => 'form/input',
            'label' => 'lang:setting_label_value',
            'id' => $preprendId . 'value',
            'default_value' => $this->fetch('item')->value,
        ]
    ) ?>
    </div>
</fieldset>
    <?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
