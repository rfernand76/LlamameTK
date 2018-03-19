    <?php 
         error_reporting(E_ALL);
     ini_set('display_errors', 1);

    $printer="";
    $html = "<h1>Test de Impresion de Tickets $printer</h1>";
    $handle = printer_open();

    /*printer_write($enlace, $html);
    printer_close();*/

    echo $html;

    ?>


