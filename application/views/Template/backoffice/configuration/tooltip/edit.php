<?php $preprendId = uniqid(); ?>
<?= form_open($this->fetch('validator'), current_url()) ?>
    <fieldset class="card mb-4">
        <h2 class="card-header bg-inverse text-white">><?= lang('tooltip_label_fieldset-information') ?></h2>
        <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'title_key',
                'input_element' => 'form/input',
                'label' => 'lang:tooltip_label_title',
                'id' => $preprendId . 'title',
                'extra' => [
                    'readonly' => 'readonly',
                    'value' => lang_libelle($this->fetch('item')->title_key),
                ]
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'active',
                'input_element' => 'form/radio_inline',
                'label' => 'lang:tooltip_label_active',
                'id' => $preprendId . 'active',
                'options' => [
                    '0' => lang('general_label_active-no'),
                    '1' => lang('general_label_active-yes'),
                ],
                'default_value' => $this->fetch('item')->active,
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
        <h2 class="card-header bg-inverse text-white"><?= lang('tooltip_label_'.$lang['value']) ?></h2>
        <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'content_'.$lang['value'],
                'input_element' => 'form/textarea',
                'label' => 'lang:tooltip_label_content',
                'id' => $preprendId . 'content_'.$lang['value'],
                'default_value' => $content,
                'extra' => [
                    'data-variables' => json_encode($variables)
                ]
            ]
        ) ?>
        </div>
    </fieldset>
<?php endforeach; ?>
    <?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
