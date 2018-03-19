<?php 
    class Service{
        private static $instancia;
        private $link;

        private function __construct(){
            $cfg = VirtualQueueIni::getInstance();
            $this->link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());
        }

        public static function getInstance(){
            @session_start();
            if (self::$instancia === null) {
                self::$instancia = new Service();
            }
            return self::$instancia;
        }


        public function isLoggin(){
            $usuario = $_SESSION['usuario'];
            $ret = !($usuario == "");
            return $ret;
        }

        public function getDato($sql, $campo){
            $query = mysqli_query($this->link, $sql);
            $fila = mysqli_fetch_array($query);
            $ret = $fila[$campo];
            return $ret;
        }

        public function estadisticasJornada($HORA_COMIENZO){
            $fechaJornada = $this->getJornada();
            $usu_codigo = $_SESSION['usu_codigo'];

            $ret = array();

            $sql = "select count(1) LLAMADOS from seguimiento a where eje_codigo = $usu_codigo";
            $ret["LLAMADOS"] = $this->getDato($sql, "LLAMADOS");

            $sql = "select count(1) ATENDIDOS from seguimiento a where a.seg_atendido = 2 and eje_codigo = $usu_codigo";
            $ret["ATENDIDOS"] = $this->getDato($sql, "ATENDIDOS");


            $sql = "select SEC_TO_TIME(AVG(TIMEDIFF((CASE WHEN seg_fecatencion >0 THEN (seg_fecatencion) ELSE CURRENT_TIMESTAMP() end),
                     seg_fecllamada ))) TIEMPO_PROMEDIO_ATENCION from seguimiento where seg_atendido = 2 and eje_codigo = $usu_codigo";
            $ret["TIEMPO_PROMEDIO_ATENCION"] = $this->getDato($sql, "TIEMPO_PROMEDIO_ATENCION");

            $sql = "SELECT count(1) PAUSAS_REALIZADAS FROM pausa WHERE eje_codigo = $usu_codigo and pau_inicio > '$fechaJornada' ";
            $ret["PAUSAS_REALIZADAS"] = $this->getDato($sql, "PAUSAS_REALIZADAS");

            $sql = "SELECT SEC_TO_TIME(IFNULL(sum((CASE WHEN pau_fin >0 THEN (pau_fin) ELSE CURRENT_TIMESTAMP() end) - pau_inicio), 0))
                    TIEMPO_TOTAL_PAUSADO  FROM pausa WHERE eje_codigo = $usu_codigo and pau_inicio > '$fechaJornada'";
            $ret["TIEMPO_TOTAL_PAUSADO"] = $this->getDato($sql, "TIEMPO_TOTAL_PAUSADO");

            //esta validcion es para evitar hacer una consulta inecesaria, ya que la hora de comienzo solo se debe consultar una vez.
            if($HORA_COMIENZO == ""){
                $HORA_COMIENZO = $this->getPrimerLLamadoJornada();
            }
            $ret["HORA_COMIENZO"] = $HORA_COMIENZO;

            return $ret;
        }

        public function getJornada(){
            $sql = "select min(jor_fecha) m from jornada";
            return $this->getDato($sql, "m");
        }

        public function getPrimerLLamadoJornada(){
            $usu_codigo = $_SESSION['usu_codigo'];

            $sql ="
            SELECT min(seg_fecllamada) seg_fecllamada 
            FROM seguimiento 
            WHERE eje_codigo = $usu_codigo";

		    return $this->getDato($sql, "seg_fecllamada");
        }
    }
?>
