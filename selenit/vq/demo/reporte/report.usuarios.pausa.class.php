<?php 
    include("../global/report.php");

	class ReportFila extends Report{
        function getSqlForReport(){
            $parametros = $this->getParams();

            $andA = $this->sqlAnd($parametros, 'a.pau_inicio');
            $andl = $this->sqlAnd($parametros, 'l.pau_inicio');


            $sql = "
            SELECT e.usu_codigo, e.usu_usuario, 
                IFNULL(a.c , 0) cal_realizadas,
                SEC_TO_TIME(IFNULL(l.c , 0)) cal_tiempo
            FROM v_ejecutivo e 
            LEFT JOIN (select sum(1) c, a.eje_codigo from pausa a 
                where 1 $andA group by a.eje_codigo ) a ON e.usu_codigo = a.eje_codigo
            LEFT JOIN (select sum((CASE WHEN pau_fin >0 THEN (pau_fin) ELSE CURRENT_TIMESTAMP() end) - pau_inicio) c, l.eje_codigo from pausa l 
                where 1 $andl group by l.eje_codigo ) l ON e.usu_codigo = l.eje_codigo
            ";


            return $sql;
        }        

        function getSql(){
            $order = $this->getOrder();
            $limit = $this->getLimit();
 
            $sql = $this->getSqlForReport()." $order $limit";
//echo $sql;
            return $sql;
        }

    }
    Report::execute("ReportFila");
?>



