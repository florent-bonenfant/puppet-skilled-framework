<?php
$preprendId = uniqid();
$item = $this->fetch('item');
$error = $this->fetch('error');
$form_csrf = null;
$companies = $this->fetch('companies');
?>
<div class="row">
    <div class="col-md-8">

        <?= form_open($this->fetch('validator'), current_url(), [
            'enctype' => 'multipart/form-data',
        ]) ?>
        <section class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('contrat_label_info') ?></h2>
            <div class="card-block">
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'original_file_name',
                    'input_element' => 'form/input',
                    'label' => 'lang:contrat_label_original_file_name',
                    'default_value' => $item->original_file_name ?? null,
                ]
            ) ?>
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'city',
                    'input_element' => 'form/input',
                    'label' => 'lang:contrat_label_city',
                    'default_value' => $item->city ?? null,
                ]
            ) ?>
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'customer_id',
                    'input_element' => 'form/input',
                    'label' => 'lang:contrat_label_customer_id',
                    'default_value' => $item->customer_id ?? null,
                ]
            ) ?>
            <?php
                $error = '';
                $class_wrapper = 'form-group';
                if (($error = form_error('companies', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
                    $class_wrapper .= ' has-danger';
                }
            ?>
            <div class="<?= $class_wrapper ?>">
                <?= $this->element(
                    'form/label',
                    [
                        'label' => 'lang:message_label_companies',
                        'field' => 'companies',
                        'extra' => ['for' => $preprendId . 'companies']
                    ]
                ) ?>
                <?= $this->element(
                    'form/radio',
                    [
                        'name' => 'companies',
                        'default_value' => $item->company->id,
                        'options' => array_pluck($companies, 'name', 'id')
                    ]
                ) ?>
            </div>
            </div>
        </section>

        <section class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('contrat_label_attachment') ?></h2>
            <div class="card-block">
                <?= form_csrf_input() ?>
                <?php
                $error = form_error('contract', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>');
                ?>
                <div class="form-group <?= $error ? 'has-danger' : '' ?>">
                <?php if ($item && $item->file_name) : ?>
                <?= $this->element(
                    'form/label',
                    [
                        'label' => 'lang:contrat_label_existing_contract',
                    ]
                ) ?>
                <p>
                    <a href="<?= site_url('backoffice/modules/contrat/download/' . $item->getRouteKey()) ?>" target="_blank" class="btn btn-primary">
                        <i class="material-icons">file_download</i>
                        <?= $item->file_name ?>
                    </a>

                    <?php
                    if (!$item->isLocked()) : ?>
                        <?php if (route_is_accessible('backoffice/modules/contrat/delete_file/' . $this->fetch('item')->getRouteKey())) : ?>
                            <?php
                            $csrf = csrf_anchor(
                                'backoffice/modules/contrat/delete_file/' . $this->fetch('item')->getRouteKey(),
                                '<i class="material-icons">delete</i>',
                                [
                                    'class' => 'btn btn-sm btn-danger',
                                    'title' => lang('general_action_delete'),
                                    'data-toggle' => "tooltip",
                                    'data-placement' => 'top',
                                    'data-confirm' => lang('general_message_delete-confirm')
                                ],
                                true
                            );
                            $form_csrf = $csrf['form'];
                            echo $csrf['input'];
                            ?>
                        <?php else : ?>
                            <?= lang('general_message_already-lock') ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </p>
                <?php endif; ?>
                <?= $this->element(
                    'form/label',
                    [
                        'label' => 'lang:contrat_label_contract',
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
                <?php if ($error) : ?>
                    <?= $error ?>
                <?php endif; ?>
                </div>
                <?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
            </div>
        </section>
        </form>
        <?= $form_csrf ?>
    </div>
</div>