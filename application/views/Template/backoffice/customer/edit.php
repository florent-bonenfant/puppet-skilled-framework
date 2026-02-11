<?php
$preprendId = uniqid();
$item = $this->fetch('item');
?>
<div class="row">
    <?= form_open($this->fetch('validator'), current_url(), [
        'class' => 'user_form col-md-8',
    ]) ?>
    <fieldset class="card mb-4">
        <h2 class="card-header bg-inverse text-white"><?= lang('customer_label_info_user') ?></h2>
        <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:customer_label_id',
                'default_value' => $item->id ?? null,
            ]
        ) ?>

        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:customer_label_last_name',
                'default_value' => $item->last_name ?? null,
            ]
        ) ?>

        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:customer_label_first_name',
                'default_value' => $item->first_name ?? null,
            ]
        ) ?>

        <?= $this->element(
            'form/block_input',
            [
                'name' => 'email',
                'input_element' => 'form/input',
                'label' => 'lang:user_label_email',
                'id' => $preprendId . 'email',
                'default_value' => $item->email ?? null,
            ]
        ) ?>
        </div>
    </fieldset>
    <fieldset class="card mb-4">
        <h2 class="card-header bg-inverse text-white"><?= lang('customer_label_info_customer') ?></h2>
        <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:customer_label_company',
                'default_value' => $item->company->name ?? null,
            ]
        ) ?>

        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:customer_label_family',
                'default_value' => $item->family->name ?? null,
            ]
        ) ?>

        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:customer_label_address',
                'default_value' => $item->fullAddress ?? null,
            ]
        ) ?>

        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:customer_label_created_at',
                'default_value' => user_date_format($item->created_at, true),
            ]
        ) ?>

        <?= $this->element(
            'form/block_input',
            [
                'input_element' => 'form/info',
                'label' => 'lang:customer_label_closing_date',
                'default_value' => $item->closing_date ? user_date_format($item->closing_date, true) : null,
            ]
        ) ?>
        </div>
        </fieldset>
        <fieldset class="card mb-4">
            <h2 class="card-header bg-inverse text-white"><?= lang('customer_label_info_customer') ?></h2>
            <div class="card-block">

            <?= $this->element(
                'crud/list',
                [
                'pager'  => $this->fetch('pager'),
                'base_url' => current_base_url() . '/' . $item->id,
                'displayed_fields' => [
                    [
                        'query_key' => 'username',
                        'label' => 'lang:user_label_username',
                    ],
                    [
                        'query_key' => 'name',
                        'label' => 'lang:user_label_last-and-first-name',
                        'formater' => function ($item) {
                                return html_escape($item->last_name . ' ' . $item->first_name);
                        }
                    ],
                    [
                        'query_key' => 'active',
                        'label' => 'lang:user_label_enable',
                        'class' => 'table-actions',
                        'formater' => function ($item) {
                                return $this->element('crud/active_action', ['item' => $item]);
                        }
                    ],
                    [
                        'label' => '',
                        'class' => 'table-actions',
                        'formater' => function ($customerUser) use ($item) {
                                return $this->block('list_actions_user', [
                                    'customer' => $item,
                                    'customerUser' => $customerUser,
                                ]);
                        }
                        ],
                    ],
                ]
            );?>

        </div>
        </fieldset>
    </fieldset>

    <?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
    </form>
    <aside class="col-md-4">
        <!-- @TODO
        <h3>Titre encart</h3>
        <p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Nullam id dolor id nibh ultricies vehicula ut id elit. Nullam quis risus eget urna mollis ornare vel eu leo. Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>
        -->
    </aside>
</div>
