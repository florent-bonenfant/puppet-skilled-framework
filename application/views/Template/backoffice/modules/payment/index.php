<?php
$filters = $this->fetch('filters');
$pager = $this->fetch('pager')->getResult();
$baseUrl = $this->fetch('base_url') ?: current_base_url();
$states = $this->fetch('states');
?>

<?= $this->element(
    'crud/global_actions',
    [
        'actions' => [
            [
                'uri' => 'backoffice/modules/affiliation/add/',
                'label' =>  '<i class="material-icons">add</i> ' .  lang('general_action_add'),
                'extra' => [
                    'title' => lang('general_action_add'),
                    'class' => 'btn btn-primary',
                ]
            ]
        ]
    ]
);
?>

<div class="card card-filter mb-4">
    <div class="card-header FilterHeader">
        <?= $pager['total'] ?> <?= lang('general_label_total_element') ?>
    </div>

    <div class="card-block">
        <?php $preprendId = uniqid(); ?>
        <form action="<?= site_url($baseUrl) ?>" method="get" accept-charset="utf-8" class="FilterForm">
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'description',
                    'input_element' => 'form/input',
                    'label' => 'lang:payment_label_description',
                    'id' => $preprendId . 'description',
                    'default_value' => $filters->getValue('description'),
                ]
            ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'state',
                'input_element' => 'form/select',
                'label' => 'lang:payment_label_state',
                'id' => $preprendId . 'state',
                'options' => $states,
                'default_value' => $filters->getValue('state'),
            ]
        ) ?>
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'amount',
                    'input_element' => 'form/input',
                    'label' => 'lang:payment_label_amount',
                    'id' => $preprendId . 'amount',
                    'default_value' => $filters->getValue('amount'),
                ]
            ) ?>
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'stripe_id',
                    'input_element' => 'form/input',
                    'label' => 'lang:payment_label_stripe_id',
                    'id' => $preprendId . 'stripe_id',
                    'default_value' => $filters->getValue('stripe_id'),
                ]
            ) ?>
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'customer_id',
                    'input_element' => 'form/input',
                    'label' => 'lang:payment_label_customer_id',
                    'id' => $preprendId . 'customer_id',
                    'default_value' => $filters->getValue('customer_id'),
                ]
            ) ?>

            <div class="form-group">
                <?= $this->element(
                    'form/label',
                    [
                        'label' => 'lang:payment_label_mail_send',
                        'field' => 'mail_send[]',
                        'extra' => ['for' => $preprendId . 'mail_send']
                    ]
                ) ?>
                <?= $this->element(
                    'form/radio_inline',
                    [
                        'name' => 'mail_send',
                        'default_value' => ($filters->getValue('mail_send') ? '1' : '0'),
                        'options' => [
                            '1' => lang('general_yes'),
                            '0' => lang('general_no'),
                        ],
                    ]
                ) ?>
            </div>
            <div class="form-actions">
                <button type='submit' value="<?= $filters->getFilterActionValue() ?>" name="<?= $filters->getActionName() ?>" class='btn btn-primary'>
                    <?= lang('general_action_filter') ?>
                </button>
                <?= anchor(
                    $baseUrl . '?' . $filters->getActionName() . '=' . $filters->getResetActionValue(),
                    lang('general_action_reset_filters')
                ) ?>
            </div>
        </form>
    </div>
</div>

<?= $this->block(
    'list',
    [
        'pager'  => $this->fetch('pager'),
        'displayed_fields' => [
            [
                'query_key' => 'customer_id',
                'label' => 'lang:payment_label_customer_id',
            ],
            [
                'query_key' => 'amount',
                'label' => 'lang:payment_label_amount',
                'formater' => function ($item) {
                    return $item->amount . ' €';
                }
            ],
            [
                'query_key' => 'state',
                'label' => 'lang:payment_label_state',
                'formater' => function ($item) {
                    return lang('payment_stripe_label_' . $item->state);
                }
            ],
            [
                'query_key' => 'description',
                'label' => 'lang:payment_label_description',
            ],
            [
                'query_key' => 'mail_send',
                'label' => 'lang:payment_label_mail_send',
                'formater' => function ($item) {
                    return $item->mail_send ? lang('general_yes') : lang('general_no');
                }
            ],
            [
                'query_key' => 'stripe_id',
                'label' => 'lang:payment_label_stripe_id',
            ],
            [
                'query_key' => 'created_by',
                'label' => 'lang:payment_label_created_by',
                'formater' => function ($item) {
                    return $item->creator ? $item->creator->last_name . ' ' . $item->creator->first_name : null;
                }
            ],
            [
                'query_key' => 'created_at',
                'label' => 'lang:payment_label_created_at',
            ],
        ],
    ]
); ?>