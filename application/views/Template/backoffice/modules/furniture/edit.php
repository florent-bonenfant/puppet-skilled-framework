<?php
$preprendId = uniqid();
$item = $this->fetch('item');
$error = $this->fetch('error');
?>
<div class="row">
    <div class="col-md-8">
        <section class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('furniture_label_info') ?></h2>
            <div class="card-block">
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:furniture_label_code',
                        'default_value' => $item->code,
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:furniture_label_label',
                        'default_value' => $item->label,
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:furniture_label_series',
                        'default_value' => $item->series,
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:furniture_label_contract_number',
                        'default_value' => $item->contract_number,
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:furniture_label_initial_date',
                        'default_value' => $item->initial_date ? user_date_format($item->initial_date, false) : '',
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:furniture_label_end_date',
                        'default_value' => $item->end_date ? user_date_format($item->end_date, false) : '',
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:furniture_label_customer_id',
                        'default_value' => $item->customer_id . ' - ' . $item->customer?->name,
                    ]
                ) ?>
            </div>
        </section>
        <section class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('furniture_label_attachment') ?></h2>
            <div class="card-block">
                <?php if ($item->file_name) : ?>
                <a href="<?= $item->documentPath() ?>" target="_blank" class="btn btn-primary">
                    <i class="material-icons">file_download</i>
                    <?= $item->file_name ?>
                </a>
                <?php else : ?>
                    <form method = "POST" action = "<?= current_url() ?>" enctype = "multipart/form-data">
                        <?= form_csrf_input() ?>
                        <div class="form-group <?= $error ? 'has-danger' : '' ?>">
                            <?= $this->element(
                                'form/label',
                                [
                                    'label' => 'lang:furniture_label_contract',
                                    'field' => 'contract',
                                    'extra' => ['for' => 'contract']
                                ]
                            ) ?>
                            <?php
                            $info_input = [
                                'name'  => 'contract',
                                'class' => 'form-control',
                                'id'    => 'contract',
                            ];
                        ?>
                            <input type='file' <?= _attributes_to_string($info_input) ?> />
                        <?php
                            if ($error) :
                                ?>
                                    <div class="form-control-feedback"><i class="material-icons">warning</i>
                                    <?= $error ?>
                                    </div>
                                <?php
                            endif;
                        ?>
                        </div>
                        <?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
                    </form>
                <?php endif ?>
            </div>
        </section>
    </div>
</div>