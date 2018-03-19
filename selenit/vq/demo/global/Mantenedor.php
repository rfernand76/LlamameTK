<?php 
    include("../global/virtualQueueIni.php");
    class Mantenedor {
        protected $link = null;

        public static function execute($c){
            
            $method = Mantenedor::getPostAndGet("method");
            $params = Mantenedor::getPostAndGet("params");
            $reflector = new ReflectionClass($c);
            $obj = $reflector->newInstance();
            $m = $reflector->getMethod($method); 
            $data = $m->invoke($obj, $params);
            return $data;
        }

        public static function getPostAndGet($name){
            
            $ret = $_POST[$name];
            if($ret == ""){
                $ret=$_GET[$name];
            }
            return $ret;
        }

        function getOrder(){
	        $sortname = isset($_POST['sortname']) ? $_POST['sortname'] : ''; 
	        $sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : ''; 
            $order = "";
            if($sortname != ''){
                $order = "order by $sortname $sortorder";
            }
            return $order;
        }

        function getLimit(){
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
	        $rp = isset($_POST['rp']) ? $_POST['rp'] : 10; 
            $inicio = ($page*$rp)-$rp;
            $fin=     ($inicio)+$rp;

            $limit = "limit $inicio, $fin";
            return $limit;
        }

        function count($s){
            $sql = "select count(1) c from (" .$s. ") a";

            $result = $this->query($sql);
            $fila = mysqli_fetch_array($query);
            $c = $fila["c"];

            return $c;
        }

        function close(){
            mysqli_close($this->link);
        }

        function connect(){
            if($this->link == null){
                $cfg = VirtualQueueIni::getInstance();
                $this->link = new mysqli($cfg->getServer(), $cfg->getUsername(), $cfg->getPassword(), $cfg->getDatabase());
            }
        }

        function query($sql){
            $query = mysqli_query($this->link, $sql);
            return $query;
        }

        function getParams(){
            $params = $params = Mantenedor::getPostAndGet("params");
            $parametros = null;
            if($params != ""){
                $parametros = json_decode($params);
            }
            return $parametros;
        }

        function create(){
            $rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
            $page = isset($_POST['page']) ? $_POST['page'] : 1; 


            $this->connect();

            $sql = $this->getSql();
            $sqlCount = $this->getSqlForReport();
            $total = $this->count($sqlCount);
            $query = $this->query($sql);

            $jsonData = array('status'=>'OK', 'page'=>$page,'total'=>$total,'rp'=>$rp,'rows'=>array());
            $num_fields=mysqli_field_count($this->link);

            while ($fila = mysqli_fetch_array($query))
            {
                $list = array();
                for($i=0; $i<$num_fields; $i++){
                    $v = $fila[$i];
                    array_push($list, $v);
                }
                
                $entry = array('cell' => $list); 
                $jsonData['rows'][] = $entry;
            }

            $this->close();
            echo json_encode($jsonData); 
        }


        function sqlAnd($parametros, $campo){
            $and = "";
            if($parametros->key == "dthoy"){
                $and = "AND $campo > CURRENT_DATE()";
            }else if($parametros->key == "dtayer"){
                $and = "AND $campo BETWEEN DATE_ADD(CURDATE(), INTERVAL -1 day) AND CURDATE()";
            }else if($parametros->key == "dtsemana"){
                $and = "AND $campo > DATE_ADD(CURDATE(), INTERVAL -7 day)";
            }else if($parametros->key == "dtmes"){
                $and = "AND $campo > DATE_ADD(CURDATE(), INTERVAL -30 day)";
            }else if($parametros->key == "dtrango"){
                $desde = $parametros->desde;
                $hasta = $parametros->hasta;
                $and = "AND $campo BETWEEN '$desde' AND '$hasta'";
            }
            return $and;
        }

        function exportToExcel(){
            $this->connect();

            $sql = $this->getSqlForReport();
            $result = $this->query($sql);
            $num_fields= mysqli_fetch_array($query);
            $jsonHeader = Mantenedor::getPostAndGet("jsonHeader");
            $parametros = json_decode($jsonHeader);
            
            $title = $parametros->title;
            if($title == ""){
                $title = "Reporte";
            }
            
            $xls = new Excel_XML('UTF-8', false, $title);
            
            $data = array();
            $encabezado = array($title);
            array_push($data, $encabezado);
            array_push($data,array());
            
            if($parametros->colModel != undefined && $parametros->colModel != null  && $parametros->colModel != ""){
                $titulos = array();
                foreach($parametros->colModel as $key => $value) {
                    array_push($titulos, $value->display);
                }
                array_push($data, $titulos);
            }

            while ($fila = mysqli_fetch_array($query))
            {
                $list = array();
                for($i=0; $i<$num_fields; $i++){
                    $v = $fila[$i];
                    array_push($list, $v);
                }
                array_push($data, $list);
            }

            $xls->addArray($data);
            $this->close();
            $xls->generateXML($title);
        }
        
        function getModelFromName($model, $name){
            $i = 0;
            $salir = false;
            
            while($i< count($model) && !$salir){
                if($model[$i]->name === $name){
                    return $model[$i];
                }
                $i++;
            }
        }
    }
?>
