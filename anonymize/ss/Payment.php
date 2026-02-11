<?php

use HideMe\Model;

class Payment extends Model
{
    protected $table = 'payments';
    public $timestamps = true;
    public $columns = [
        'description' => 'une desc'
    ];
    private $numOrder = 0;

    public function __construct()
    {
        parent::__construct();
        $this->columns['id'] = function () {
            return $this->faker->uuid();
        };
        $this->columns['stripe_id'] = function () {
            return 'stripe_' . str_pad(++$this->numOrder, 10, STR_PAD_LEFT);
        };
        $this->columns['state'] = function () {
            return $this->faker->randomElement([
                'requires_payment_method',
                'requires_confirmation',
                'requires_action',
                'processing',
                'succeeded',
                'payment_failed',
                'canceled',
                'incomplete_expiry',
            ]);
        };
        $this->columns['attempts'] = function () {
            return $this->faker->numberBetween(0, 100);
        };
    }
}
