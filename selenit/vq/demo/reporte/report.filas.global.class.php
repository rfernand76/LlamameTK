<?php include("../global/report.php");
	class ReportFila extends Report{
        function getSqlForReport(){
            $parametros = $this->getParams();

            $andS = $this->sqlAnd($parametros, 's.seg_fecha');
            $andA = $this->sqlAnd($parametros, 'a.seg_fecha');
            $andTE = $this->sqlAnd($parametros, 'te.seg_fecha');
            $andTA = $this->sqlAnd($parametros, 'ta.seg_fecha');

            $sql = "
            SELECT f.fil_codigo, f.fil_nombre, 
                IFNULL(s.c , 0) cal_solicitudes, 
                IFNULL(a.c , 0) cal_atendidas, 
                SEC_TO_TIME(IFNULL( te.c, 0)) cal_tespera, 
                SEC_TO_TIME(IFNULL( ta.c, 0)) cal_tatencion
            FROM fila f 
            LEFT JOIN (select count(1) c, s.fil_codigo from v_seguimiento s 
                where 1=1 $andS group by s.fil_codigo ) s ON f.fil_codigo = s.fil_codigo 
            LEFT JOIN (select count(1) c, a.fil_codigo from v_seguimiento a 
                where a.seg_atendido = 2 $andA group by a.fil_codigo ) a ON f.fil_codigo = a.fil_codigo
            LEFT JOIN (select AVG(seg_fecllamada - seg_fecha) c, te.fil_codigo from v_seguimiento te
                where te.seg_llamado > 0 $andTE group by te.fil_codigo ) te ON f.fil_codigo = te.fil_codigo
            LEFT JOIN (select AVG(seg_fecfinatencion - seg_fecatencion) c, ta.fil_codigo from v_seguimiento ta
                where ta.seg_atendido = 2 $andTA group by ta.fil_codigo ) ta ON f.fil_codigo = ta.fil_codigo
            ";

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
