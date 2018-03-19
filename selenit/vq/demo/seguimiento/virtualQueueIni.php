<?php error_reporting(0);  class VirtualQueueIni{
        public static $mobile_create = false;
        public static $instancia = null;
        /*private $server = "";
        private $username = "selenit_root";
        private $password = "selenit5566";
        private $database = "selenit_produccion";*/
        
        private $server = "";
        private $username = "vqserver";
        private $password = "EU_CPQNDS.des02h7";
        private $database = "selenit_vqserver";
        private $mobile_server_secondary = "http://54.94.203.188/";

        //private $mobile_server_secondary = "http://localhost/selenit/vq/demo/seguimiento/";

        private function __construct(){
        }

        public static function getInstance(){
            if (self::$instancia === null) {
                self::$instancia = new VirtualQueueIni();
            }
            return self::$instancia;
        }

        public function getServer(){return $this->server;}
        public function getUsername(){return $this->username;}
        public function getPassword(){return $this->password;}
        public function getDatabase(){return $this->database;}        
        public function getMobile_server_secondary(){$this->mobileCreate(); return $this->mobile_server_secondary;}
        
        
        private function mobileCreate(){
            if(self::$mobile_create == false){
               $this->getMobileParam();
               self::$mobile_create = true;
            }
        }
        
        
        public function getMobileParam(){
            $IniLink = mysql_connect($this->server, $this->username, $this->password);
            $db_selected = mysql_select_db($this->database, $IniLink);
                       
            $sql =  "SELECT par_nombre, par_valor  FROM parametro WHERE par_grupo = 2";

            $result = mysql_query($sql, $IniLink);
            while ($fila = mysql_fetch_assoc($result)){
                $nombre = $fila["par_nombre"];
                $valor  = $fila["par_valor"];

                switch ($nombre) {
                case "mobile_server_primary":
                    $this->mobile_server_primary = $valor;
                    break;

                case "mobile_server_secondary":
                    $this->mobile_server_secondary = $valor;
                    break;

                case "mobile_enterprisId":
                    $this->mobile_enterprisId = $valor;
                    break;

                case "mobile_username":
                    $this->mobile_username = $valor;
                    break;

                case "mobile_password":
                    $this->mobile_password = $valor;
                    break;

                case "mobile_Follow":
                    $this->mobile_Follow = $valor;
                    break;
                }
            }

            mysql_close($IniLink);
        }
        
    }
?>
