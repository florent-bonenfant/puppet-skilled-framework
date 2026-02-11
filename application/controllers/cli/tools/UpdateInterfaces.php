<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \App\Model\Invoice as InvoiceModel;
use \App\Model\Order as OrderModel;
use \App\Model\Family as FamilyModel;
use \App\Service\Content\ContentModel;
use \App\Service\Content\ContentTranslationModel;

class UpdateInterfaces extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->invoiceType();
        $this->orderType();
    }

    public function families()
    {
        $uuid = new FamilyModel();

        FamilyModel::where('slug', 'REA')->update(['slug' => 'AF']);
        FamilyModel::where('slug', 'REF')->update(['slug' => 'FR']);
        FamilyModel::where('slug', 'REP')->update(['slug' => 'DE']);
        // New slug to new slug
        if (empty(FamilyModel::where('slug', 'EC')->get())) {
            FamilyModel::insert([
                'id' => $uuid->generateUuid(),
                'slug' => 'EC'
            ]);
        }

        // Metas
        if (empty(ContentModel::where('slug', 'AF')->get())) {
            ContentModel::insert([
                [
                    'slug'      => 'AF',
                    'type'      => 'family',
                    'title_key' => 'lang:AF',
                    'active'    => 1
                ],
                [
                    'slug'      => 'FR',
                    'type'      => 'family',
                    'title_key' => 'lang:FR',
                    'active'    => 1
                ],
                [
                    'slug'      => 'DE',
                    'type'      => 'family',
                    'title_key' => 'lang:DE',
                    'active'    => 1
                ],
                [
                    'slug'      => 'EC',
                    'type'      => 'family',
                    'title_key' => 'lang:EC',
                    'active'    => 1
                ],
            ]);

            ContentTranslationModel::insert([
                [
                    'content_slug'  => 'AF',
                    'local'         => 'french',
                    'title'         => 'AFFILIE',
                    'content'       => ''
                ],
                [
                    'content_slug'  => 'FR',
                    'local'         => 'french',
                    'title'         => 'FRANCHISE NATIONAL',
                    'content'       => ''
                ],
                [
                    'content_slug'  => 'DE',
                    'local'         => 'french',
                    'title'         => 'DEPOSITAIRE NATIONAL',
                    'content'       => ''
                ],
                [
                    'content_slug'  => 'EC',
                    'local'         => 'french',
                    'title'         => 'ECOLE',
                    'content'       => ''
                ],
            ]);
        }
    }

    /**
     * Update type of invoice for SAP
     */
    public function invoiceType()
    {
        InvoiceModel::where('document_type', 'G3')->update(['document_type' => 'L2']);
        InvoiceModel::where('document_type', 'F1')->update(['document_type' => 'BV']);
        InvoiceModel::where('document_type', 'F2')->update(['document_type' => 'RE']);
        InvoiceModel::where('document_type', 'RJ')
            ->orWhere('document_type', 'F6')
            ->orWhere('document_type', 'F8')
            ->update(['document_type' => 'G2']);
        InvoiceModel::where('document_type', 'RI')
            ->orWhere('document_type', 'G5')
            ->update(['document_type' => 'F2']);
        InvoiceModel::where('document_type', 'F5')->update(['document_type' => 'FV']);
    }

    /*
    * Update type of orders for SAP
    * /!\ Plusieurs code fusionné en un dans le fichier de transcodage qui n'ont pas le meme libellé
    */
    public function orderType() {
        OrderModel::where('order_type', 'A1')->update(['order_type' => 'RE']);
        OrderModel::where('order_type', 'A2')
            ->orWhere('order_type', 'A5')
            ->orWhere('order_type', 'A7')
            ->update(['order_type' => 'CR/YG1']);
        OrderModel::where('order_type', 'A8')->update(['order_type' => 'ZBV']);
        OrderModel::where('order_type', 'S1')->update(['order_type' => 'MV']);
        OrderModel::where('order_type', 'S4')
            ->orWhere('order_type', 'SC')
            ->update(['order_type' => 'BV']);
        OrderModel::where('order_type', 'S7')->update(['order_type' => 'KE']);
        OrderModel::where('order_type', 'S8')
            ->orWhere('order_type', 'SA')
            ->orWhere('order_type', 'SE')
            ->orWhere('order_type', 'SR')
            ->orWhere('order_type', 'SV')
            ->update(['order_type' => 'CS']);
        OrderModel::where('order_type', 'SG')->update(['order_type' => 'ZENS']);
        OrderModel::where('order_type', 'SH')->update(['order_type' => 'DR/YG4']);
        OrderModel::where('order_type', 'SL')->update(['order_type' => 'ZLAN']);
        OrderModel::where('order_type', 'SN')->update(['order_type' => 'ZDOT']);
        OrderModel::where('order_type', 'SO')->update(['order_type' => 'ZOUV']);
        OrderModel::where('order_type', 'SP')->update(['order_type' => 'ZPRO']);
    }
}
