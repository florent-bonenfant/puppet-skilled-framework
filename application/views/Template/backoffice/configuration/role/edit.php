<?php $preprendId = uniqid(); ?>
<?= form_open($this->fetch('validator'), current_url()) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('role_label_general') ?></h2>
    <div class="card-block">
    <?php
    // get translations
    $translations = [];
    if (!empty($this->fetch('item')->content->translations)) {
        foreach ($this->fetch('item')->content->translations as $translation) {
            $translations[$translation->local] = $translation->title;
        }
    }

    foreach ($this->fetch('availables_langagues') as $lang) :
    $content = $translations[$lang['value']] ?? '';
    ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'name_' . $lang['value'],
                'input_element' => 'form/input',
                'label' => 'lang:role_label_name_' . $lang['value'],
                'id' => $preprendId . 'name_'.$lang['value'],
                'default_value' => $content,
            ]
        ) ?>
    <?php endforeach; ?>
    <?= $this->element(
        'form/block_input',
        [
            'name' => 'resources[]',
            'input_element' => 'form/checkbox_inline',
            'label' => 'lang:role_label_resources',
            'id' => $preprendId . 'resources',
            'options' => array_combine($this->fetch('resources'), $this->fetch('resources')),
            'default_value' => ($this->fetch('item')->resources_support ?: null)
        ]
    ) ?>
    </div>
</fieldset>
<?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
