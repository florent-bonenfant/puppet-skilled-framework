<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;
use Mpdf\Mpdf;

class Expired_date extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {get} /expired      Get all expireds
     * @apiName expiredAll
     * @apiGroup expired
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         expired list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $this->customer->company->expired_dates()->get()
        ]);
    }

    /**
     * @api {get} /expired/csv      Get all expireds
     * @apiName downloadExpiredCSV
     * @apiGroup expired
     * @apiVersion 1
     *
     * @apiSuccess (200)    {result}        result         expired list file to CSV
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function export_csv()
    {
        $this->lang->load('webservice/expirate_date.php', 'french');
        $data = $this->customer->company->expired_dates()->get();

        $csv = fopen('php://memory', 'w');
        fputcsv($csv, [lang('code_produit'), lang('numero_lot'), lang('libelle'), lang('date_peremption')], ',');

        foreach ($data as $obj) {
            $date = null;
            if ($obj->date_peremption) {
                $date = Carbon::createFromFormat('Y-m-d', $obj->date_peremption)->format('d/m/Y');
            }

            $line = [
                $obj->product_code,
                $obj->lot_number,
                $obj->libelle_fr,
                $date
            ];
            fputcsv($csv, $line, ',');
        }
        fseek($csv, 0);
        $csvContent = stream_get_contents($csv);
        fclose($csv);

        $csvBase64 = base64_encode($csvContent);

        // Construire la réponse JSON
        $response = [
            'resultContent' => [
                'filedata' => $csvBase64,
                'file_name' => 'date_expiration_lots_articles.csv'
            ]
        ];

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * @api {get} /expired/pdf      Get all expireds
     * @apiName downloadExpiredPDF
     * @apiGroup expired
     * @apiVersion 1
     *
     * @apiSuccess (200)    {result}        result         expired list file to PDF
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function export_pdf()
    {
        $this->lang->load('webservice/expirate_date.php', 'french');
        $data = $this->customer->company->expired_dates()->get();
        $mpdf = new Mpdf([
            'tempDir' => sys_get_temp_dir(),
            'default_font_size' => 9,
            'margin_top' => 3,
            'margin_right' => 2,
            'margin_bottom' => 5,
            'margin_left' => 2,
        ]);
        $mpdf->SetTitle(lang('pdf_name'));

        // Début du contenu HTML du PDF
        $html = '<h3 style="text-align:center;">Liste des Produits Expirés</h3>';
        $html .= '<table border="1" cellspacing="0" cellpadding="3" style="width:100%; border-collapse: collapse;">';
        $html .= '<thead><tr>';
        $html .= '<th style="background-color:#f2f2f2;">' . lang('code_produit') . '</th>';
        $html .= '<th style="background-color:#f2f2f2;">' . lang('numero_lot') . '</th>';
        $html .= '<th style="background-color:#f2f2f2;">' . lang('libelle') . '</th>';
        $html .= '<th style="background-color:#f2f2f2;">' . lang('date_peremption') . '</th>';
        $html .= '</tr></thead><tbody>';

        // Remplissage des données
        foreach ($data as $obj) {
            $date = null;
            if ($obj->date_peremption) {
                $date = Carbon::createFromFormat('Y-m-d', $obj->date_peremption)->format('d/m/Y');
            }
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($obj->product_code) . '</td>';
            $html .= '<td>' . htmlspecialchars($obj->lot_number) . '</td>';
            $html .= '<td>' . htmlspecialchars($obj->libelle_fr) . '</td>';
            $html .= '<td>' . $date . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        // Ajouter le HTML au PDF
        $mpdf->WriteHTML($html);

        // Génération du PDF en mémoire
        $pdfContent = $mpdf->Output('', 'S'); // 'S' retourne le PDF en tant que chaîne

        // Encodage en Base64
        $pdfBase64 = base64_encode($pdfContent);

        // Construire la réponse JSON
        $response = [
            'resultContent' => [
                'filedata' => $pdfBase64,
                'file_name' => 'date_expiration_lots_articles.pdf'
            ]
        ];

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
