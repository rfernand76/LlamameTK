<?php 
    include("../global/report.php");

	class ReportFila extends Report{
        function getSqlForReport(){
            $parametros = $this->getParams();

            $andA = $this->sqlAnd($parametros, 'a.seg_fecha');
            $andl = $this->sqlAnd($parametros, 'l.seg_fecha');
            $andTL = $this->sqlAnd($parametros, 'tl.seg_fecha');
            $andTA = $this->sqlAnd($parametros, 'ta.seg_fecha');


            $sql = "
            SELECT e.usu_codigo, e.usu_usuario, 
                IFNULL(a.c , 0) cal_llamadas,
                IFNULL(l.c , 0) cal_atendidas,
                tl.c cal_tllamado,
                ta.c cal_tatencion
            FROM v_ejecutivo e 
            LEFT JOIN (select count(1) c, a.eje_codigo from v_seguimiento a 
                where a.seg_atendido = 2 $andA group by a.eje_codigo ) a ON e.usu_codigo = a.eje_codigo
            LEFT JOIN (select count(1) c, l.eje_codigo from v_seguimiento l 
                where l.seg_llamado = 1 $andl group by l.eje_codigo ) l ON e.usu_codigo = l.eje_codigo
            LEFT JOIN (select (TIMEDIFF((CASE WHEN seg_fecatencion >0 THEN (seg_fecatencion) ELSE CURRENT_TIMESTAMP() end), seg_fecllamada )) 
                c, tl.eje_codigo from v_seguimiento tl where tl.seg_llamado = 1 $andTL group by tl.eje_codigo) tl ON e.usu_codigo = tl.eje_codigo
            LEFT JOIN (select SEC_TO_TIME(AVG(seg_fecfinatencion - seg_fecatencion)) c, ta.eje_codigo from v_seguimiento ta
                where ta.seg_atendido = 2 $andTA group by ta.eje_codigo ) ta ON e.usu_codigo = ta.eje_codigo
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



