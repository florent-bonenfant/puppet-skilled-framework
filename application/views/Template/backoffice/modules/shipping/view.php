<?php
$preprendId = uniqid();
$item = $this->fetch('item');
?>
<div class="row">
    <div class="col-md-8">
        <section class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('shipping_label_info') ?></h2>
            <div class="card-block">
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:shipping_label_shipping_number',
                        'default_value' => $item->shipping_number,
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:shipping_label_customer',
                        'default_value' => $item->customer_id . ($item->customer ? ' - ' . $item->customer->name : null),
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:shipping_label_institut',
                        'default_value' => $item->institut->name ?? "",
                    ]
                ) ?>
            </div>
        </section>
        <section class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('shipping_label_attachment') ?></h2>
            <div class="card-block">
                <?php if ($item->file_name) : ?>
                <a href="<?= site_url('backoffice/modules/shipping/download/' . $item->getRouteKey()) ?>" target="_blank" class="btn btn-primary">
                    <i class="material-icons">file_download</i>
                    <?= $item->file_name ?>
                </a>
                <?php else : ?>
                <?= lang('shipping_label_attachment_empty') ?>
                <?php endif ?>
            </div>
        </section>
    </div>
</div>
