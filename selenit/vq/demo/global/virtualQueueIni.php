<?php 
//error_reporting(0);
ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

    class VirtualQueueIni{
        public static $mobile_create = false;
        public static $instancia = null;

        private $server = "";
        private $username = "selenit_root";
        private $password = "selenit5566";
        private $database = "selenit_produccion";

        private $mobile_Follow = 0;
        private $mobile_enterprisId = "";
        private $mobile_username = "";
        private $mobile_password = "";
        private $mobile_server_primary = "";
        private $mobile_server_secondary = "";
        private $mobile_server_display = "";

        private function __construct(){
        }

        public static function getInstance(){
            if (self::$instancia === null) {
                self::$instancia = new VirtualQueueIni();
            }
            return self::$instancia;
        }

        private function mobileCreate(){
            if(self::$mobile_create == false){
               $this->getMobileParam();
               self::$mobile_create = true;
            }
        }

        public function getMobileParam(){
            $link = new mysqli($this->getServer(), $this->getUsername(), $this->getPassword(), $this->getDatabase());

            $sql =  "SELECT par_nombre, par_valor  FROM parametro WHERE par_grupo = 2";
            $query = mysqli_query($link, $sql);
            while ($fila = mysqli_fetch_array($query)){
                $nombre = $fila["par_nombre"];
                $valor  = $fila["par_valor"];

                switch ($nombre) {
                case "mobile_server_primary":
                    $this->mobile_server_primary = $valor;
                    break;

                case "mobile_server_secondary":
                    $this->mobile_server_secondary = $valor;
                    break;
                
                case "mobile_server_display":
                    $this->mobile_server_display = $valor;
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

            mysqli_close($link);
        }

        public function getServer(){return $this->server;}
        public function getUsername(){return $this->username;}
        public function getPassword(){return $this->password;}
        public function getDatabase(){return $this->database;}

        public function getMobile_Follow(){$this->mobileCreate(); return $this->mobile_Follow;}
        public function getMobile_enterprisId(){$this->mobileCreate(); return $this->mobile_enterprisId;}
        public function getMobile_username(){$this->mobileCreate(); return $this->mobile_username;}
        public function getMobile_password(){$this->mobileCreate(); return $this->mobile_password;}

        public function getMobile_server_primary()  {$this->mobileCreate(); return $this->mobile_server_primary;}
        public function getMobile_server_secondary(){$this->mobileCreate(); return $this->mobile_server_secondary;}
        
        public function getMobile_server_display(){$this->mobileCreate(); return $this->mobile_server_display;}
    }
?>
