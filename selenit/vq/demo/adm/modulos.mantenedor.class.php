<?php 
    include("../global/Mantenedor.php");
	class MantenedorModulos extends Mantenedor{
        function getSqlForReport(){
            $sql = "
            select m.mod_codigo, m.mod_modulo, 
            IFNULL(CONCAT( IFNULL( u.usu_nombres,  '' ) ,  ' ', IFNULL( u.usu_paterno,  '' ) ,  ' ', IFNULL( u.usu_materno,  '' ) ),  '' )
            , m.usu_codigo, m.mod_ip 
            from modulo m LEFT JOIN usuario u
            on m.usu_codigo = u.usu_codigo";

            
            return $sql;
        }        

        function getSql(){
            $order = $this->getOrder();
            $limit = $this->getLimit();
 
            $sql = $this->getSqlForReport()." $order $limit";

            return $sql;
        }
        
        
        function get_list_user(){
            $this->connect();
            $value = $this->getPostAndGet("value");
            
            $sql = "select u.usu_codigo, 
                    IFNULL(CONCAT( IFNULL( u.usu_nombres,  '' ) ,  ' ', IFNULL( u.usu_paterno,  '' ) ,  ' ', IFNULL( u.usu_materno,  '' ) ),  '' ) nombre
                    from usuario u";
            
            
            $query = $this->query($sql);
            
            echo '<option value="-1">Seleccione...</option>';
            while ($fila = $fila = mysqli_fetch_array($query)){
                $selected = ($value === $fila['usu_codigo']? "selected":"");
                echo '<option '.$selected .' value="'.$fila['usu_codigo'].'">'.$fila['nombre'].'</option>';
	    }
            $this->close();
            
        }
        
        
        function delete(){
            $params = $this->getPostAndGet("params");
            $obj = json_decode($params);
            $list = $obj->list;

            $this->connect();
            
            $sql = "delete FROM modulo where mod_codigo in($list)";
            $this->query($sql);
            $errno   = mysqli_errno($this->link);
            $errdes  = mysqli_error($this->link);
            
            $this->close();

            if($errno == ""){
                echo '{"status": "OK"}';
            }else{
                echo '{"status": "ERROR", "errno": "'.$errno.'","errdes":"'.$errdes.'"}';
            }
        }
        
        function add(){
            $params = $this->getPostAndGet("params");
            $obj = json_decode($params);
            
            $mod_modulo = $this->getModelFromName($obj, "mod_modulo")->value;
            $usu_codigo = $this->getModelFromName($obj, "usu_codigo")->value;
            $mod_ip = $this->getModelFromName($obj, "mod_ip")->value;
                
            $this->connect();

            
                if($usu_codigo !== '-1' && $usu_codigo !== ''){
                    $sql = "INSERT INTO modulo (mod_modulo, usu_codigo, mod_ip) "
                            . "VALUES ('$mod_modulo', '$usu_codigo', '$mod_ip');";
                }else{
                    $sql = "INSERT INTO modulo (mod_modulo, usu_codigo, mod_ip) "
                            . "VALUES ('$mod_modulo', null, '$mod_ip');";
                }
            
            
            $this->query($sql);

            $errno   = mysqli_errno($this->link);
            $errdes  = mysqli_error($this->link);

            $this->close();
            if($errno == ""){
                echo '{"status": "OK"}';
            }else{
                echo '{"status": "ERROR", "errno": "'.$errno.'","errdes":"'.$sql.'"}';
            }
        }
        
        function update(){
            try {
                $params = $this->getPostAndGet("params");
                $obj = json_decode($params);

                $mod_codigo = $this->getModelFromName($obj, "mod_codigo")->value;
                $mod_modulo = $this->getModelFromName($obj, "mod_modulo")->value;
                $usu_codigo = $this->getModelFromName($obj, "usu_codigo")->value;
                $mod_ip = $this->getModelFromName($obj, "mod_ip")->value;
                
                $this->connect();

                $sql = "update modulo set "
                        . "mod_modulo = '$mod_modulo', ";
                
                if($usu_codigo !== '-1'){
                    $sql = $sql . "usu_codigo = '$usu_codigo', ";
                }else{
                    $sql = $sql . "usu_codigo = null, ";
                }
                
                $sql = $sql 
                        . "mod_ip = '$mod_ip' "
                        . "where mod_codigo = $mod_codigo";
                
                $this->query($sql);
                
                $errno   = mysqli_errno($this->link);
                $errdes  = mysqli_error($this->link);

                $this->close();
                
                if($errno == ""){
                    echo '{"status": "OK"}';
                }else{
                    echo '{"status": "ERROR", "errno": "'.$errno.'","errdes":"-->'.$sql.'"}';
                }
                
            } catch (Exception $e) {
                echo '{"status": "ERROR", "errno": "error","errdes":"'.$e->getMessage().'"}';
            }
        }
    }
    Mantenedor::execute("MantenedorModulos");
?>
