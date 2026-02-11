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
            <h2 class="card-header bg-inverse text-white"><?= lang('banner_add_label_h2') ?></h2>
            <div class="card-block">
                <?php
                $error = '';
                $class_wrapper = 'form-group';
                if (($error = form_error('company_id', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
                    $class_wrapper .= ' has-danger';
                }
                ?>
                <div class="<?= $class_wrapper ?>">
                    <?= $this->element(
                        'form/label',
                        [
                            'label' => 'lang:banner_add_label_company',
                            'field' => 'company_id',
                            'extra' => ['for' => $preprendId . 'company_id']
                        ]
                    ) ?>
                    <?= $this->element(
                        'form/radio',
                        [
                            'name' => 'company_id',
                            'default_value' => $item->company->id ?? null,
                            'options' => array_pluck($companies, 'name', 'id')
                        ]
                    ) ?>
                </div>

                <?= form_csrf_input() ?>
                <?php
                $error = form_error('contract', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>');
                ?>
                <div class="form-group <?= $error ? 'has-danger' : '' ?>">
                    <?php if ($item && $item->file_name) : ?>
                        <?= $this->element(
                            'form/label',
                            [
                                'label' => 'lang:banner_add_label_banner',
                            ]
                        ) ?>
                        <p>
                            <a href="<?= site_url('backoffice/configuration/banner/download/' . $item->getRouteKey()) ?>" target="_blank" class="btn btn-primary">
                                <i class="material-icons">file_download</i>
                                <?= $item->file_name ?>
                            </a>

                            <?php
                            if (!$item) : ?>
                                <?php if (route_is_accessible('backoffice/configuration/banner/delete_file/' . $this->fetch('item')->getRouteKey())) : ?>
                                    <?php
                                    $csrf = csrf_anchor(
                                        'backoffice/configuration/banner/delete_file/' . $this->fetch('item')->getRouteKey(),
                                        '<i class="material-icons">delete</i>',
                                        [
                                            'class' => 'btn btn-sm btn-danger',
                                            'title' => lang('general_action_delete'),
                                            'data-toggle' => "banner",
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
                            'label' => 'lang:banner_add_label_file',
                            'field' => 'file',
                            'extra' => ['for' => 'file']
                        ]
                    ) ?>
                    <?php
                    $info_input = [
                        'name'  => 'file',
                        'class' => 'form-control',
                        'id'    => 'file',
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