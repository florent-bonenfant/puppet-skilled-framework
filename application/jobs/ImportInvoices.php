<?php
namespace App\Job;

use \App\Model\Company as CompanyModel;
use \App\Model\InvoiceLine as InvoiceLineModel;
use \App\Model\Customer as CustomerModel;
use Carbon\Carbon;
use \App\Model\Invoice as InvoiceModel;
use \Illuminate\Database\Query\Expression;

class ImportInvoices extends \App\Job\Import
{
    protected $source_file_pattern = '/facture_([0-9]{8})\.txt$/';
    protected $document_dir_source = 'invoices';
    protected $model = '\App\Model\Invoice';
    protected $compare = ['customer_id', 'document_number'];

    protected $map = [
        'customer_id'           => 'client',
        'company_id'            => 'societe',
        'document_number'       => 'numero_de_document',
        'document_type'         => 'type_de_document',
        'file_name'             => 'nom_du_fichier_facture',
        'delivery_sheet'        => 'bon_de_livraison',
        'date'                  => 'date',
    ];

    protected $dataInline = [];

    protected $companies = [];

    protected $invoices_id = [];

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
        if ($row['nom_du_fichier_facture']) {
            // Check if the file can be found and copy it to the right directory, display an error otherwise
            if (is_file($source = config_item('data_import_path').'/'.$this->document_dir_source.'/'.$row['nom_du_fichier_facture'])) {
                if (!is_dir(config_item('data_document_path').'/invoices')) {
                    mkdir(config_item('data_document_path').'/invoices', 0777, true);
                }

                $new_name = sha1($row['nom_du_fichier_facture']).'.'.pathinfo($source)['extension'];
                if (!is_file($dest = config_item('data_document_path').'/invoices/'.$new_name)) {
                    if (file_exists($dest)) {
                        unlink($dest);
                    }
                }
                copy($source, $dest);

                $row['nom_du_fichier_facture'] = $new_name;
            } else {
                $this->message_log('WARNING',  $row['nom_du_fichier_facture'] . 'not found');
                $row['nom_du_fichier_facture'] = null;
            }
        }
        // verif existing customer
        $customer = CustomerModel::where('id', $row['client'])->first();
        if (!$customer) {
            $this->message_log('ERROR', 'document number ' . $row['numero_de_document'] . ' -> the customer does not exists');
            return false;
        }

        $row['date'] = new Carbon($row['date']);
        $row['societe'] = $this->companies[$row['societe']];
        $row['created_at'] = Carbon::now();
        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // output
        $element = $item->document_number . ' ' . $item->product_number;

        // save invoice id for update amount
        if (!in_array($item->id, $this->invoices_id)) {
            $this->invoices_id[] = $item->id;
        }

        // check if an invoice line already exists
        $invoiceLine = InvoiceLineModel::where([
            'number' => $row['code_produit'],
            'batch' => $row['numero_de_lot'],
            'invoice_id' => $item->id
        ])->first();

        if ($invoiceLine) {
            $this->editInvoiceLine($invoiceLine, $row);
        } else {
            $row['invoice_id'] = $item->id;
            $this->addInvoiceLine($row);
        }

        if (!$isUpdate) {
            // create notification
            $notif = new \App\Service\Notification\Notification();
            $notif->send('notification_new_invoice', $item->customer_id);
        }

        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }

    protected function addInvoiceLine($row)
    {
        $invoiceLine = new InvoiceLineModel();
        $invoiceLine->number = $row['code_produit'];
        $invoiceLine->description = $row['description_du_produit'];
        $invoiceLine->batch = $row['numero_de_lot'];
        $invoiceLine->invoice_id = $row['invoice_id'];
        $invoiceLine->created_at = Carbon::now();
        $invoiceLine->amount = str_replace(',', '.', $row['montant_ht']);
        $invoiceLine->amount_ttc = str_replace(',', '.', $row['montant_ttc']);
        $invoiceLine->save();
    }

    protected function editInvoiceLine($invoiceLine, $row)
    {
        $invoiceLine->number = $row['code_produit'];
        $invoiceLine->description = $row['description_du_produit'];
        $invoiceLine->batch = $row['numero_de_lot'];
        $invoiceLine->amount = str_replace(',', '.', $row['montant_ht']);
        $invoiceLine->amount_ttc = str_replace(',', '.', $row['montant_ttc']);
        $invoiceLine->save();
    }

    public function handle()
    {
        if (parent::handle()) {
            $invoiceModel = new InvoiceModel();

            $sub_sql_amount = InvoiceLineModel::selectRaw('SUM(amount)')
                              ->whereRaw('invoice_id = ' . $invoiceModel->getTable() . '.' . $invoiceModel->getKeyName())
                              ->toSql();

            $sub_sql_amount_ttc = InvoiceLineModel::selectRaw('SUM(amount_ttc)')
                                  ->whereRaw('invoice_id = ' . $invoiceModel->getTable() . '.' . $invoiceModel->getKeyName())
                                  ->toSql();

            $invoiceModel->whereIn('id', $this->invoices_id )
                         ->update([
                             'amount' => new Expression('(' . $sub_sql_amount . ')'),
                             'amount_ttc' => new Expression('(' . $sub_sql_amount_ttc . ')'),
                         ]);
        }
    }
}
