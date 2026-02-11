<?php
namespace App\Job;

use \App\Model\Invoice as InvoiceModel;
use \App\Model\Shipping as ShippingModel;
use Carbon\Carbon;

class ImportLinkShippingsInvoices extends \App\Job\Import
{
    protected $source_file_pattern = '/asso_bonliv_fact_([0-9]{8})\.txt$/';
    protected $model = '\App\Model\ShippingInvoice';
    protected $compare = ['shipping_id', 'invoice_id'];

    protected $map = [
        'shipping_id' => 'numero_bon_livraison',
        'invoice_id' => 'numero_de_facture',
    ];

    protected function buildRow($row)
    {
        $shipping = ShippingModel::where('shipping_number', $row['numero_bon_livraison'])->first();
        if (!$shipping) {
            $this->message_log('ERROR', $row['numero_bon_livraison'] . ' / ' . $row['numero_de_facture'] . ' : the shipping does not exists');
            return false;
        }

        $invoice = InvoiceModel::where('document_number', $row['numero_de_facture'])->first();
        if (!$invoice) {
            $this->message_log('ERROR', $row['numero_bon_livraison'] . ' / ' . $row['numero_de_facture'] . ' : the invoice does not exists');
            return false;
        }

        $row['numero_bon_livraison'] = $shipping->id;
        $row['numero_de_facture'] = $invoice->id;

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // output
        $element = 'Shipping n°' . $item->shipping_id . ' links to Invoice n°' . $item->invoice_id;

        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }
}
