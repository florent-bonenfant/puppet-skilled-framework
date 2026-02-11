<?php
namespace App\Job;

use \App\Model\Invoice as InvoiceModel;
use \App\Model\Order as OrderModel;
use \App\Model\Company as CompanyModel;
use Carbon\Carbon;

class ImportLinkOrdersInvoices extends \App\Job\Import
{
    protected $source_file_pattern = '/asso_boncde_fact_([0-9]{8})\.txt$/';
    protected $model = '\App\Model\OrderInvoice';
    protected $compare = ['order_id', 'invoice_id'];

    protected $map = [
        'order_id' => 'numero_de_commande',
        'invoice_id' => 'numero_de_facture',
    ];

    protected $companies = [];

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
        $order = OrderModel::where('order_number', $row['numero_de_commande'])
                            ->where('company_id', $this->companies[$row['societe']])
                            ->where('order_type', $row['type_de_commande'])
                            ->first();

        if (!$order) {
            $this->message_log('ERROR', $row['numero_de_commande'] . ' / ' . $row['numero_de_facture'] . ' : the order does not exists');
            return false;
        }

        $invoice = InvoiceModel::where('document_number', $row['numero_de_facture'])
                               ->where('company_id', $this->companies[$row['societe']])
                               ->where('document_type', $row['type_de_facture'])
                               ->first();

        if (!$invoice) {
            $this->message_log('ERROR', $row['numero_de_commande'] . ' / ' . $row['numero_de_facture'] . ' : the invoice does not exists');
            return false;
        }

        $row['numero_de_commande'] = $order->id;
        $row['numero_de_facture'] = $invoice->id;

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // output
        $element = 'Order n°' . $item->order_id . ' links to Invoice n°' . $item->invoice_id;

        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }
}
