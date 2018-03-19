<?php 
    include("../global/report.php");

	class ReportFila extends Report{
        function getSqlForReport(){
            $parametros = $this->getParams();

            $andS = $this->sqlAnd($parametros, 's.seg_fecha');

            $sql = "
            SELECT 
               f.fil_nombre, s.seg_numero, u.usu_usuario
              ,SEC_TO_TIME(IFNULL(CASE WHEN s.seg_fecllamada -s.seg_fecha     >0 THEN (s.seg_fecllamada -s.seg_fecha)      ELSE 0 END, 0)) cal_tespera
              ,SEC_TO_TIME(IFNULL(CASE WHEN s.seg_fecatencion-s.seg_fecllamada>0 THEN (s.seg_fecatencion-s.seg_fecllamada) ELSE 0 END, 0)) cal_tllama
              ,SEC_TO_TIME(IFNULL(CASE WHEN s.seg_fecfinatencion-s.seg_fecatencion>0 THEN (s.seg_fecfinatencion-s.seg_fecatencion) ELSE 0 END, 0)) cal_tatencion
              ,s.seg_fecha, time(s.seg_fecllamada), time(s.seg_fecatencion), time(s.seg_fecfinatencion)
            FROM v_seguimiento s
                LEFT JOIN fila    f ON f.fil_codigo = s.fil_codigo 
                LEFT JOIN usuario u ON u.usu_codigo = s.eje_codigo 
            WHERE  1=1 $andS
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



