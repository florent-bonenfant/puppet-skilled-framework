<?php
$preprendId = uniqid();
$item = $this->fetch('item');

if ($item) :
?>
    <div class="wrap-contributor">
        <p><?= sprintf(lang('message_contributor_add'), '<b>' . $item->creator->first_name . '</b>', '<b>' . $item->creator->last_name . '</b>', '<b>' . user_date_format($item->created_at, false) . '</b>') ?></p>
        <p><?= sprintf(lang('message_contributor_edit'), '<b>' . $item->updator->first_name . '</b>', '<b>' . $item->updator->last_name . '</b>', '<b>' . user_date_format($item->updated_at, false) . '</b>') ?></p>
    </div>
<?php
endif;

?>
<?= form_open($this->fetch('validator'), current_url()) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('message_label_general') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'title',
                'input_element' => 'form/input',
                'label' => 'lang:message_label_title',
                'id' => $preprendId . 'title',
                'default_value' => $item->title ?? null,
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'content',
                'input_element' => 'form/wysiwyg',
                'label' => 'lang:message_label_content',
                'id' => $preprendId . 'content',
                'default_value' => $item->content ?? null,
            ]
        ) ?>
    </div>
</fieldset>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('message_label_public') ?></h2>
    <div class="card-block">
        <?php
            $error = '';
            $class_wrapper = 'form-group';
            if (($error = form_error('companies[]', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
                $class_wrapper .= ' has-danger';
            }
        ?>
        <div class="<?= $class_wrapper ?>">
            <?php
                $default_values = [];
                if ($item) {
                    foreach ($item->companies as $com) {
                        $default_values[] = $com->id;
                    }
                }
            ?>
            <?= $this->element(
                'form/label',
                [
                    'label' => 'lang:message_label_companies',
                    'field' => 'companies[]',
                    'extra' => ['for' => $preprendId . 'companies']
                ]
            ) ?>
            <?= $this->element(
                'form/checkbox',
                [
                    'name' => 'companies[]',
                    'default_value' => $default_values,
                    'options' => array_pluck($this->fetch('companies'), 'name', 'id')
                ]
            ) ?>
        </div>
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
                    'label' => 'lang:message_label_families',
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

<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('message_label_publication') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'order',
                'input_element' => 'form/input',
                'label' => 'lang:message_label_order',
                'id' => $preprendId . 'order',
                'default_value' => $item->order ?? null,
            ]
        ) ?>
        <?php
            $error = '';
            $class_wrapper = 'form-group';
            $class_input = 'form-control js-datepicker flatpickr-input';
            if (($error = form_error('publication_date', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
                $class_wrapper .= ' has-danger';
                $class_input .= ' form-control-danger';
            }
            $value = set_value('publication_date', ($item ? $item->publication_date : null), false);
        ?>
        <div class=" <?= $class_wrapper ?>">
            <label class="form-control-label" for="<?= $preprendId ?>publication_date"><?= lang('message_label_publication_date'); ?> *</label>
            <input <?= _attributes_to_string(['type' => 'text', 'name' => 'publication_date', 'class' => $class_input, 'id' => $preprendId . 'publication_date', 'placeholder' => lang('general_label_datepicker_format'), 'value' => $value])   ?> />
            <?= $error ?>
        </div>
        <?php
            $error = '';
            $class_wrapper = 'form-group';
            $class_input = 'form-control js-datepicker flatpickr-input';
            if (($error = form_error('end_publication_date', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
                $class_wrapper .= ' has-danger';
                $class_input .= ' form-control-danger';
            }

            $value = set_value('end_publication_date', ($item ? $item->end_publication_date : null), false);

        ?>
        <div class=" <?= $class_wrapper ?>">
            <label class="form-control-label" for="<?= $preprendId ?>end_publication_date"><?= lang('message_label_end_publication_date'); ?></label>
            <input <?= _attributes_to_string(['type' => 'text', 'name' => 'end_publication_date', 'class' => $class_input, 'id' => $preprendId . 'end_publication_date', 'placeholder' => lang('general_label_datepicker_format'), 'value' => $value])   ?> />
            <?= $error ?>
        </div>
        <?php if (!$item): ?>
        <div class="form-group">
            <?= $this->element(
              'form/label',
                [
                  'label' => 'lang:message_label_send_notification',
                  'field' => 'send_notification',
                  'extra' => ['for' => $preprendId . 'send_notification']
                ]
            ) ?>
            <?= $this->element(
              'form/checkbox',
              [
                'name' => 'send_notification',
                'options' => [
                    '1' => lang('general_yes'),
                ],
              ]
            ) ?>
        </div>
        <?php endif; ?>
    </div>
</fieldset>

<?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
<?php
$this->asset->enqueueStyle('flatpickr.css');
$this->asset->enqueueScript('locales.js');