<?php
$preprendId = uniqid();
$item = $this->fetch('item');
$lines = $item->lines;
?>
<div class="row">
    <div class="col-md-8">
        <section class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('invoice_label_info') ?></h2>
            <div class="card-block">
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:invoice_label_document_number',
                        'default_value' => $item->document_number,
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:invoice_label_amount',
                        'default_value' => $item->amount . ' €',
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:invoice_label_date',
                        'default_value' => user_date_format($item->date, false),
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:invoice_label_customer',
                        'default_value' => $item->customer_id . ($item->customer ? ' - ' . $item->customer->name : null),
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:invoice_label_company',
                        'default_value' => $item->company->name,
                    ]
                ) ?>
            </div>
        </section>
        <section class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('invoice_label_attachment') ?></h2>
            <div class="card-block">
                <?php if ($item->file_name) : ?> 
                <a href="<?= site_url('backoffice/modules/invoice/download/' . $item->getRouteKey()) ?>" target="_blank" class="btn btn-primary">
                    <i class="material-icons">file_download</i>
                    <?= $item->file_name ?>
                </a>
                <?php else : ?>
                <?= lang('invoice_label_attachment_empty') ?>
                <?php endif ?>
            </div>
        </section>
    </div>
</div>
<?php
  if (!empty($lines)) :
    ?>
    <h2 id="lines"><?= lang('invoice_label_lines') ?></h2>
    <div class="table-wrap mt-4 mb-4">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>
                        <?= lang_libelle('lang:invoice_label_product_number') ?>
                    </th>
                    <th>
                        <?= lang_libelle('lang:invoice_label_product_description') ?>
                    </th>
                    <th>
                        <?= lang_libelle('lang:invoice_label_batch') ?>
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($lines as $l) :
            ?>
                    <tr>
                        <td><?= html_escape($l->number) ?></td>
                        <td><?= html_escape($l->description) ?></td>
                        <td><?= html_escape($l->batch) ?></td>
                    </tr>
            <?php
                endforeach;
            ?>
            </tbody>
        </table>
    </div>
<?php
  endif;
?>
