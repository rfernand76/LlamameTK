<?php 
    include("../global/report.php");

	class ReportFila extends Report{
        function getSqlForReport(){
            $parametros = $this->getParams();
            $and = $this->sqlAnd($parametros, 's.seg_fecha');
            
            $sql = "
            SELECT f.fil_codigo, f.fil_nombre, count( s.eje_codigo ) cal_atendidas
            FROM fila f LEFT JOIN v_seguimiento s ON f.fil_codigo = s.fil_codigo and s.seg_atendido = 2 $and
            GROUP BY f.fil_codigo, f.fil_nombre";

            return $sql;
        }        

        function getSql(){
            $order = $this->getOrder();
            $limit = $this->getLimit();
 
            $sql = $this->getSqlForReport()." $order $limit";

            return $sql;
        }

    }
    Report::execute("ReportFila");
?>



