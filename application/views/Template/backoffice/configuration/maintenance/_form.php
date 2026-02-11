<?php
$preprendId = uniqid();
$item = $this->fetch('item');
?>
<?= form_open($this->fetch('validator'), current_url(), ['class' => 'maintenance_form']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('user_label_general') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'message',
                'input_element' => 'form/textarea',
                'label' => 'lang:maintenance_label_display_message',
                'id' => $preprendId . 'message',
                'default_value' => $item->message ?? null,
            ]
        ) ?>
        <div class="row">
            <div class="col-md-6">
                <?= $this->element(
                    'form/block_input',
                    [
                        'name' => 'starts_on',
                        'input_element' => 'form/datetimepicker',
                        'label' => 'lang:maintenance_label_start',
                        'id' => $preprendId . 'starts_on',
                        'default_value' => $item && $item->starts_on ? date_format(new DateTime($item->starts_on), "d/m/Y H:i") : null,                      'extra' => [
                            'placeholder' => "jj/mm/aaaa hh:mm"
                        ]
                    ]
                ) ?>
            </div>
            <div class="col-md-6">
                <?= $this->element(
                    'form/block_input',
                    [
                        'name' => 'ends_on',
                        'input_element' => 'form/datetimepicker',
                        'label' => 'lang:maintenance_label_end',
                        'id' => $preprendId . 'ends_on',
                        'default_value' => $item && $item->ends_on ? date_format(new DateTime($item->ends_on), "d/m/Y H:i") : null,
                        'extra' => [
                            'placeholder' => "jj/mm/aaaa hh:mm"
                        ]
                    ]
                ) ?>
            </div>
        </div>
        <div class="form-actions">
            <?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
        </div>
    </div>
</fieldset>
</form>