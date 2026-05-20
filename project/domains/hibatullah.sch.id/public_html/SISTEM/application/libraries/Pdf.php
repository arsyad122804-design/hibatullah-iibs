<?php



defined('BASEPATH') or exit('No direct script access allowed');

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


use Dompdf\Options;

class Pdf
{

    public function generate($html, $filename = '', $paper = '', $orientation = '', $stream = TRUE)
    {

        $options = new Options();
        $options->set('isHtml5ParserEnabled', TRUE);
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->set_option("enable_php", true);
        $dompdf->set_option('defaultFont', 'sans-serif');
        $dompdf->set_option("fontHeightRatio", 1);

        $dompdf->loadHtml(html_entity_decode($html));
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();



        if ($stream) {
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
        } else {



            // return $dompdf->output();


            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
        }
    }
}
