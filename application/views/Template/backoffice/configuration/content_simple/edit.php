<?php $preprendId = uniqid(); ?>
<?= form_open($this->fetch('validator'), current_url()) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('content_simple_label_fieldset-information') ?></h2>
    <div class="card-block">
    <?= $this->element(
        'form/block_input',
        [
            'name' => 'title_key',
            'input_element' => 'form/input',
            'label' => 'lang:content_simple_label_title',
            'id' => $preprendId . 'title',
            'extra' => [
                'readonly' => 'readonly',
                'value' => $this->fetch('item')->title_key,
            ]
        ]
    ) ?>
    </div>
</fieldset>
<?php
foreach ($this->fetch('availables_langagues') as $lang) :
$variables = (isset($this->fetch('item')->variables) ? $this->fetch('item')->variables : []);
$content = (isset($this->fetch('item')->{$lang['value']}) ? $this->fetch('item')->{$lang['value']}->content : '');
?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('content_simple_label_'.$lang['value']) ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'content_'.$lang['value'],
                'input_element' => 'form/wysiwyg',
                'label' => 'lang:content_simple_label_content',
                'id' => $preprendId . 'content_'.$lang['value'],
                'default_value' => $content,
            ]
        ) ?>
    </div>
</fieldset>
<?php endforeach; ?>
    <?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
