<?php
$preprendId = uniqid();
$item = $this->fetch('item');

if ($item) :
?>
    <div class="wrap-contributor">
        <p><?= sprintf(lang('affiliation_contributor_add'), '<b>' . $item->creator->first_name . '</b>', '<b>' . $item->creator->last_name . '</b>', '<b>' . user_date_format($item->created_at, false) . '</b>') ?></p>
        <p><?= sprintf(lang('affiliation_contributor_edit'), '<b>' . $item->updator->first_name . '</b>', '<b>' . $item->updator->last_name . '</b>', '<b>' . user_date_format($item->updated_at, false) . '</b>') ?></p>
    </div>
<?php
endif;
?>
<?= form_open($this->fetch('validator'), current_url()) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('affiliation_label_content') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'title',
                'input_element' => 'form/input',
                'label' => 'lang:affiliation_label_title',
                'id' => $preprendId . 'title',
                'default_value' => $item->title ?? null,
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'link',
                'input_element' => 'form/input',
                'label' => 'lang:affiliation_label_link',
                'id' => $preprendId . 'link',
                'default_value' => $item->link ?? null,
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'display_start',
                'input_element' => 'form/datepicker',
                'label' => 'lang:affiliation_label_display_start',
                'id' => $preprendId . 'display_start',
                'default_value' => $item->display_start ?? null,
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'display_end',
                'input_element' => 'form/datepicker',
                'label' => 'lang:affiliation_label_display_end',
                'id' => $preprendId . 'display_end',
                'default_value' => $item->display_end ?? null,
            ]
        ) ?>
</fieldset>

<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('affiliation_label_public') ?></h2>
    <div class="card-block">
        <?php
        $error = '';
        $class_wrapper = 'form-group';
        if (($error = form_error('families[]', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
            $class_wrapper .= ' has-danger';
        }
        ?>
        <div class="<?= $class_wrapper ?>">
            <?php
            $default_values = [];
            if ($item) {
                foreach ($item->families as $fam) {
                    $default_values[] = $fam->id;
                }
            }
            ?>
            <?= $this->element(
                'form/label',
                [
                    'label' => 'lang:affiliation_label_families',
                    'field' => 'families[]',
                    'extra' => ['for' => $preprendId . 'families']
                ]
            ) ?>
            <?= $this->element(
                'form/checkbox',
                [
                    'name' => 'families[]',
                    'default_value' => $default_values,
                    'options' => array_pluck($this->fetch('families'), 'name', 'id')
                ]
            ) ?>
        </div>
    </div>
</fieldset>

<?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
<?php
$this->asset->enqueueScript('locales.js');
