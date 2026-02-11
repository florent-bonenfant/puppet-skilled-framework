<?php $preprendId = uniqid(); ?>
<?= form_open($this->fetch('validator'), current_url()) ?>
    <fieldset class="card mb-4">
        <h2 class="card-header bg-inverse text-white"><?= lang('page_label_fieldset-information') ?></h2>
        <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'title_key',
                'input_element' => 'form/input',
                'label' => 'lang:page_label_title',
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
$title = (isset($this->fetch('item')->{$lang['value']}) ? $this->fetch('item')->{$lang['value']}->title : '');
$content = (isset($this->fetch('item')->{$lang['value']}) ? $this->fetch('item')->{$lang['value']}->content : '');
$excerpt = (isset($this->fetch('item')->{$lang['value']}) ? $this->fetch('item')->{$lang['value']}->excerpt : '');
?>
    <fieldset>
        <h2 class="card-header bg-inverse text-white"><?= lang('page_label_'.$lang['value']) ?></h2>
        <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'title_'.$lang['value'],
                'input_element' => 'form/input',
                'label' => 'lang:page_label_title',
                'id' => $preprendId . 'title_'.$lang['value'],
                'default_value' => $title,
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'content_'.$lang['value'],
                'input_element' => 'form/wysiwyg',
                'label' => 'lang:page_label_content',
                'id' => $preprendId . 'content_'.$lang['value'],
                'default_value' => $content,
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'excerpt_'.$lang['value'],
                'input_element' => 'form/wysiwyg',
                'label' => 'lang:page_label_excerpt',
                'id' => $preprendId . 'excerpt_'.$lang['value'],
                'default_value' => $excerpt,
            ]
        ) ?>
        </div>
    </fieldset>
<?php endforeach; ?>
    <?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
