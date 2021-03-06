<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */
    // get the HTML
    ob_start();
    include(dirname(__FILE__).'/nuova_segnalazione.php');
    $content = ob_get_clean();
    // convert in PDF
    require_once(dirname(__FILE__).'/../vendor/html2pdf-master/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('test.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
