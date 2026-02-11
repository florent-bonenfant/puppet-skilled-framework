<?php
$preprendId = uniqid();
$item = $this->fetch('item');
//var_dump($item->companies, $item->families);die;
?>
    <div class="wrap-contributor">
        <p><?= sprintf(lang('message_contributor_add'), '<b>' . $item->creator->first_name . '</b>', '<b>' . $item->creator->last_name . '</b>', '<b>' . user_date_format($item->created_at, false) . '</b>') ?></p>
        <p><?= sprintf(lang('message_contributor_edit'), '<b>' . $item->updator->first_name . '</b>', '<b>' . $item->updator->last_name . '</b>', '<b>' . user_date_format($item->updated_at, false) . '</b>') ?></p>
    </div>


<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('message_label_general') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:message_label_title',
                'default_value' => $item->title,
            ]
        ) ?>
        <?= $this->element(
            'form/label',
            [
                'label' => 'lang:message_label_content',
            ]
        ) ?>
        <?= $item->content ?>
    </div>
</fieldset>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('message_label_public') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/label',
            [
                'label' => 'lang:message_label_companies',
            ]
        ) ?>
        <p>
        <?php
        foreach ($item->companies as $c) {
            echo $c->name . "<br/>";
        }
        ?>
        </p>

        <?= $this->element(
            'form/label',
            [
                'label' => 'lang:message_label_families',
            ]
        ) ?>
        <p>
        <?php
        foreach ($item->families as $v) {
            echo $v->name . "<br/>";
        }
        ?>
        </p>
    </div>
</fieldset>

<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('message_label_publication') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:message_label_order',
                'default_value' => $item->order,
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:message_label_publication_date',
                'default_value' => $item->publication_date,
            ]
        ) ?>

        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:message_label_end_publication_date',
                'default_value' => $item->end_publication_date,
            ]
        ) ?>
    </div>
</fieldset>
<div class="text-center">
    <?= anchor(
        'backoffice/modules/message',
        lang('message_action_return'),
        [
            'class' => 'btn btn-primary',
            'title' => lang('message_action_return'),
            'data-toggle' => "tooltip",
            'data-placement' => 'center',
        ],
        true,
        false
    ) ?>
</div>