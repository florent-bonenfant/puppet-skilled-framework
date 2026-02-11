<?php
$preprendId = uniqid();
$item = $this->fetch('item');
$lines = $item->lines;
?>
<div class="row">
    <div class="col-md-8">
        <section class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('order_label_info') ?></h2>
            <div class="card-block">
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:order_label_order_number',
                        'default_value' => $item->order_number,
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:order_label_quantity',
                        'default_value' => $item->quantity,
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:order_label_date',
                        'default_value' => user_date_format($item->date, false),
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:order_label_customer',
                        'default_value' => $item->customer_id . ($item->customer ? ' - ' . $item->customer->name : null),
                    ]
                ) ?>
                <?= $this->element(
                    'form/block_input',
                    [
                        'input_element' => 'form/info',
                        'label' => 'lang:order_label_company',
                        'default_value' => $item->company->name,
                    ]
                ) ?>
            </div>
        </section>
    </div>
</div>
<?php
  if (!empty($lines)) :
    ?>
    <h2 id="lines"><?= lang('order_label_lines') ?></h2>
    <div class="table-wrap mt-4 mb-4">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>
                        <?= lang_libelle('lang:order_label_product_number') ?>
                    </th>
                    <th>
                        <?= lang_libelle('lang:order_label_product_description') ?>
                    </th>
                    <th>
                        <?= lang_libelle('lang:order_label_product_quantity') ?>
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
                        <td><?= html_escape($l->quantity) ?></td>
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
