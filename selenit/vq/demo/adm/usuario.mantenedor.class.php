<?php 
    include("../global/Mantenedor.php");
	class MantenedorUsuarios extends Mantenedor{
        function getSqlForReport(){
            $sql = "
            select usu_codigo, usu_usuario, usu_nombres, usu_paterno, usu_materno, usu_cargo, usu_correo, usu_telefono, usu_fecnacimiento from usuario";

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

            $this->connect();
            
            $sql = "delete FROM usuario where usu_codigo in($list)";
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
            
                $usu_usuario = $this->getModelFromName($obj, "usu_usuario")->value;
                $usu_nombres = $this->getModelFromName($obj, "usu_nombres")->value;
                $usu_paterno = $this->getModelFromName($obj, "usu_paterno")->value;
                $usu_materno = $this->getModelFromName($obj, "usu_materno")->value;
                $usu_cargo = $this->getModelFromName($obj, "usu_cargo")->value;
                $usu_correo = $this->getModelFromName($obj, "usu_correo")->value;
                $usu_telefono = $this->getModelFromName($obj, "usu_telefono")->value;
                $usu_fecnacimiento = $this->getModelFromName($obj, "usu_fecnacimiento")->value;

                if($usu_fecnacimiento == ''){
                    $usu_fecnacimiento = 'null';
                }else{
                    $usu_fecnacimiento = "'".$usu_fecnacimiento."'";
                }
                        
            $this->connect();
            $sql = "INSERT INTO usuario (usu_usuario, usu_nombres, usu_paterno, usu_materno, usu_cargo, usu_correo, usu_telefono, usu_fecnacimiento) "
                    . "VALUES ('$usu_usuario', '$usu_nombres', '$usu_paterno', '$usu_materno', '$usu_cargo', '$usu_correo', '$usu_telefono', $usu_fecnacimiento);";

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
        
        function update(){
            try {
                $params = $this->getPostAndGet("params");
                $obj = json_decode($params);

                $usu_codigo = $this->getModelFromName($obj, "usu_codigo")->value;
                $usu_usuario = $this->getModelFromName($obj, "usu_usuario")->value;
                $usu_nombres = $this->getModelFromName($obj, "usu_nombres")->value;
                $usu_paterno = $this->getModelFromName($obj, "usu_paterno")->value;
                $usu_materno = $this->getModelFromName($obj, "usu_materno")->value;
                $usu_cargo = $this->getModelFromName($obj, "usu_cargo")->value;
                $usu_correo = $this->getModelFromName($obj, "usu_correo")->value;
                $usu_telefono = $this->getModelFromName($obj, "usu_telefono")->value;
                $usu_fecnacimiento = $this->getModelFromName($obj, "usu_fecnacimiento")->value;

                if(trim($usu_fecnacimiento) == ''){
                    $usu_fecnacimiento = 'null';
                }else{
                    $usu_fecnacimiento = "'".$usu_fecnacimiento."'";
                }
                
                $this->connect();

                $sql = "update usuario set "
                        . "usu_usuario = '$usu_usuario', "
                        . "usu_nombres = '$usu_nombres', "
                        . "usu_paterno = '$usu_paterno', "
                        . "usu_materno = '$usu_materno', "
                        . "usu_cargo = '$usu_cargo', "
                        . "usu_correo = '$usu_correo', "
                        . "usu_telefono = '$usu_telefono', "
                        . "usu_fecnacimiento = $usu_fecnacimiento "
                        . "where usu_codigo = $usu_codigo";


                        echo $sql ;
                
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
    Mantenedor::execute("MantenedorUsuarios");
?>
