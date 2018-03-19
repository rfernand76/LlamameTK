<?php 
    include("../global/Mantenedor.php");
        class Mensaje{
            public $name = "fila";
        }

	class MantenedorFilas extends Mantenedor{
        function getSqlForReport(){
            $sql = "
            SELECT fil_codigo, fil_nemo, fil_nombre from fila";

            return $sql;
        }        

        function getSql(){
            $order = $this->getOrder();
            $limit = $this->getLimit();
 
            $sql = $this->getSqlForReport()." $order $limit";

            return $sql;
        }
        
        
        function delete(){
            $params = $this->getPostAndGet("params");
            $obj = json_decode($params);
            $list = $obj->list;
            $listaNemo = "";
            $this->connect();
            
            $sql = "select fil_nemo from fila where fil_codigo in($list)";
            $result = $this->query($sql);
            
            while ($fila = mysqli_fetch_array($query)){
                $listaNemo = $listaNemo . $fila["fil_nemo"] . ",";
            }
            
            $sql = "DELETE FROM fila where fil_codigo in ($list)";
            $this->query($sql);
            $this->close();
            
            $listaNemo = substr($listaNemo, 0, strlen($listaNemo)-1);
            $datos = new Mensaje();
            $datos->message = "delete";
            $datos->valueList = $listaNemo;
            $this->notificaServer($datos);
            
            $errno    = mysqli_errno($con);
            $errdes   = mysqli_error($link);
            if($errno == ""){
                echo '{"status": "OK"}';
            }else{
                echo '{"status": "ERROR", "errno": "'.$errno.'","errdes":"'.$errdes.'"}';
            }
        }
        
        function add(){
            $params = $this->getPostAndGet("params");
            $obj = json_decode($params);
            
            $fil_nombre = $this->getModelFromName($obj, "fil_nombre")->value;
            $fil_nemo = $this->getModelFromName($obj, "fil_nemo")->value;
            
            $datos = new Mensaje();
            $datos->message = "add";
            $datos->fil_nemo = $fil_nemo;
            $datos->fil_nombre = $fil_nombre;
            $this->notificaServer($datos);
            
            $this->connect();
            $sql = "INSERT INTO fila (fil_nombre, fil_nemo, eje_modulo, fil_active, fil_ut, fil_ta) "
                    . "VALUES ('$fil_nombre', '$fil_nemo', '--', 1, 0, 0);";

                    echo $sql;


            $this->query($sql);
            $errno    = mysqli_errno($this->link);
            $errdes   = mysqli_error($this->link);

            $this->close();
            if($errno == ""){
                echo '{"status": "OK"}';
            }else{
                echo '{"status": "ERROR", "errno": "'.$errno.'","errdes":"'.$errdes.'"}';
            }
        }
        
        function update(){
            try {
                $params = $this->getPostAndGet("params");
                $obj = json_decode($params);

                $fil_nombre = $this->getModelFromName($obj, "fil_nombre")->value;
                $fil_nemo = $this->getModelFromName($obj, "fil_nemo")->value;
                $fil_codigo = $this->getModelFromName($obj, "fil_codigo")->value;

                $datos = new Mensaje();
                $datos->message = "update";
                $datos->fil_nemo = $fil_nemo;
                $datos->fil_nombre = $fil_nombre;
                $this->notificaServer($datos);
                
                $this->connect();

                $sql = "update fila set fil_nombre = '$fil_nombre', fil_nemo = '$fil_nemo' where fil_codigo = $fil_codigo";
                $this->query($sql);
                $this->close();
                
                $errno    = mysqli_errno($con);
                $errdes   = mysqli_error($link);

                $this->close();
                if($errno == ""){
                    echo '{"status": "OK"}';
                }else{
                    echo '{"status": "ERROR", "errno": "'.$errno.'","errdes":"'.$errdes.'"}';
                }
                
            } catch (Exception $e) {
                echo '{"status": "ERROR", "errno": "error","errdes":"'.$e->getMessage().'"}';
            }
        }
        
        function notificaServer($datos){
            
            try{
                $json = json_encode($datos);
                $cfg = VirtualQueueIni::getInstance();

                echo $cfg->getMobile_username();


                $datosExtras = "&usuario=".$cfg->getMobile_username().
                   "&password=".$cfg->getMobile_password().
                   "&enterprisId=".$cfg->getMobile_enterprisId();
                
                $url1 = $cfg->getMobile_server_secondary()."/actualizaParametro?data=".$json.$datosExtras;
                file_get_contents($url1, false);
            } catch (Exception $e) {
                
            }
        }

    }
    
    Mantenedor::execute("MantenedorFilas");
?>




