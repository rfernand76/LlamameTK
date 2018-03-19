<?php 

class Mantenedor{
    private $tabla = '';
    public $titulo = '';
    public $method = 1;

    function Mantenedor($tabla){
        $this->tabla = $tabla;
    }

    function create(){
        $html = 
        "
        <script src='/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js'></script>
        <script src='/js/vui/dependence.js'></script>
        <script src='../js/selenit/MantenedorClass.js'></script>
        <script type='text/javascript'>
        $(window).load(function() {
            var parametros = {titulo:'$this->titulo', method:$this->method};
            var mantenedor = new Mantenedor();
            mantenedor.create();
        });
        </script>
        <div style='position:relative;'>
	        <div id='idMantenedor' class='ui-state-default ui-corner-all'>
	        </div>
        </div>
        ";
        echo $html;
    }
}

?>
