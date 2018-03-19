<?php 
    include("../global/report.php");

    class EstadisticasFilas extends Report{    
        function getSqlForReport(){
            $sql = "SELECT fil_nombre, fil_nemo, eje_modulo, fil_ut, fil_ta from fila";
            return $sql;
        } 

        function getSql(){
            $order = $this->getOrder();
            $limit = $this->getLimit();
 
            $sql = $this->getSqlForReport()." $order $limit";
            return $sql;
        }
    }
    Report::execute("EstadisticasFilas");
?>
