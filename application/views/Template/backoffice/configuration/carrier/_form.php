<?php
$preprendId = uniqid();
$item = $this->fetch('item');
$error = $this->fetch('error');
$form_csrf = null;

?>
<div class="row">
    <div class="col-md-8">

        <?= form_open($this->fetch('validator'), current_url()) ?>
        <section class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('carrier_add_label_h2') ?></h2>
            <div class="card-block">
                <?= form_csrf_input() ?>
                <?php
                $error = form_error('contract', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>');
                ?>
                <div class="form-group <?= $error ? 'has-danger' : '' ?>">
                    <?= $this->element(
                        'form/block_input',
                        [
                            'name' => 'label',
                            'input_element' => 'form/input',
                            'label' => 'lang:carrier_label_name',
                            'id' => $preprendId . 'label',
                            'default_value' => $item->label ?? null,
                        ]
                    ) ?>
                    <?= $this->element(
                        'form/block_input',
                        [
                            'name' => 'slug',
                            'input_element' => 'form/input',
                            'label' => 'lang:carrier_label_slug',
                            'id' => $preprendId . 'slug',
                            'default_value' => $item->slug ?? null,
                        ]
                    ) ?>
                    <?= $this->element(
                        'form/block_input',
                        [
                            'name' => 'link',
                            'input_element' => 'form/input',
                            'label' => 'lang:carrier_label_link',
                            'id' => $preprendId . 'link',
                            'default_value' => $item->link ?? null,
                        ]
                    ) ?>
                </div>
                <?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
            </div>
        </section>
        </form>
        <?= $form_csrf ?>
    </div>
</div>