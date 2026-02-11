<?php
namespace App\Job;

use \App\Model\Company as CompanyModel;
use \App\Model\OrderLine as OrderLineModel;
use \App\Model\Customer as CustomerModel;
use Carbon\Carbon;
use \App\Model\Order as OrderModel;
use \Illuminate\Database\Query\Expression;


class ImportOrders extends \App\Job\Import
{
    protected $source_file_pattern = '/commandes_([0-9]{8})_([0-9]{6})\.txt$/';
    protected $model = '\App\Model\Order';
    protected $compare = ['customer_id', 'order_number'];

    protected $map = [
        'customer_id'           => 'client',
        'company_id'            => 'societe',
        'order_number'          => 'numero_de_commande',
        'order_type'            => 'type_de_commande',
        'date'                  => 'date',
    ];

    protected $dataInline = [];

    protected $companies = [];

    protected $orders_id = [];

    public function __construct()
    {
        $companiesKeys = [
            'Guinot'    => 'RG',
            'Mary Cohr' => 'MC',
        ];
        foreach (CompanyModel::all() as $item) {
            $key = $companiesKeys[$item->name];
            $this->companies[$key] = $item->id;
        }
    }

    protected function buildRow($row)
    {
        // verif existing customer
        $customer = CustomerModel::where('id', $row['client'])->first();
        if (!$customer) {
            $this->message_log('ERROR', 'Order n°' . $row['numero_de_commande'] . ' -> the customer does not exists');
            return false;
        }

        list($date, ) = explode('_', $row['date']);
        $row['date'] = new Carbon($date);

        $row['societe'] = $this->companies[$row['societe']];
        $row['created_at'] = Carbon::now();
        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // save order id to update quantity
        if (!in_array($item->id, $this->orders_id)) {
            $this->orders_id[] = $item->id;
        }

        // check if an order line already exists
        $orderLine = OrderLineModel::where([
            'number' => $row['code_produit'],
            'order_id' => $item->id
        ])->first();

        if ($orderLine) {
            $this->editOrderLine($orderLine, $row);
        } else {
            $row['order_id'] = $item->id;
            $this->addOrderLine($row);
        }

        if (!$isUpdate) {
            // create notification
            $notif = new \App\Service\Notification\Notification();
            $notif->send('notification_new_order', $item->customer_id);
        }

        if ($isUpdate) {
            $this->message_log('INFO', $item->order_number .' updated');
        } else {
            $this->message_log('INFO', $item->order_number .' added');
        }
    }

    protected function addOrderLine($row)
    {
        $orderLine = new OrderLineModel();
        $orderLine->number = $row['code_produit'];
        $orderLine->description = $row['description_du_produit'];
        $orderLine->order_id = $row['order_id'];
        $orderLine->created_at = Carbon::now();
        $orderLine->quantity = str_replace(',', '.', $row['quantite_commande']);
        $orderLine->save();
    }

    protected function editOrderLine($orderLine, $row)
    {
        $orderLine->number = $row['code_produit'];
        $orderLine->description = $row['description_du_produit'];
        $orderLine->quantity = str_replace(',', '.', $row['quantite_commande']);
        $orderLine->save();
    }

    public function handle()
    {
        if (parent::handle()) {
            $orderModel = new OrderModel();
            $sub_sql = OrderLineModel::selectRaw('SUM(quantity)')
                ->whereRaw('order_id = ' . $orderModel->getTable() . '.' . $orderModel->getKeyName())
                ->toSql();
            $orderModel->whereIn('id', $this->orders_id )
                ->update(['quantity' => new Expression('(' . $sub_sql . ')')]);
        }
    }
}
