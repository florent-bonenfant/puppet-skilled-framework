<?php $preprendId = uniqid(); ?>
<?= form_open($this->fetch('validator'), current_url()) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('email_label_fieldset-information') ?></h2>
    <div class="card-block">
    <?= $this->element(
        'form/block_input',
        [
            'name' => 'title_key',
            'input_element' => 'form/input',
            'label' => 'lang:email_label_libelle',
            'id' => $preprendId . 'title',
            'default_value' => $this->fetch('item')->title_key,
            'extra' => [
                'readonly' => 'readonly',
            ]
        ]
    ) ?>
    </div>
</fieldset>
<?php
foreach ($this->fetch('availables_langagues') as $lang) :
$variables = (isset($this->fetch('item')->variables) ? $this->fetch('item')->variables : []);
$content = (isset($this->fetch('item')->{$lang['value']}) ? $this->fetch('item')->{$lang['value']}->content : '');
$title = (isset($this->fetch('item')->{$lang['value']}) ? $this->fetch('item')->{$lang['value']}->title : '');
?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('email_label_'.$lang['value']) ?></h2>
    <div class="card-block">
    <?= $this->element(
        'form/block_input',
        [
            'name' => 'title_'.$lang['value'],
            'input_element' => 'form/input',
            'label' => 'lang:email_label_subject',
            'id' => $preprendId . 'title_'.$lang['value'],
            'default_value' => $title
        ]
    ) ?>

    <?= $this->element(
        'form/block_input',
        [
            'name' => 'content_'.$lang['value'],
            'input_element' => 'form/textarea',
            'label' => 'lang:email_label_content',
            'id' => $preprendId . 'content_'.$lang['value'],
            'default_value' => $content,
            'extra' => [
                'data-variables' => json_encode($variables)
            ]
        ]
    ) ?>
        <ul class='list-variable'>
            <?php foreach ($variables as $var) : ?>
                <li><span class="title-variable"><?= lang('general_wysiwyg_variable_' . $var) ?></span>{{<?= $var ?>}}</li>
            <?php endforeach; ?>
        </ul>
    </div>
</fieldset>
<?php endforeach; ?>
    <?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>