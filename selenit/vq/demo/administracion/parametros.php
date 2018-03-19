<?php
$per_nombre="ADMINISTRADOR";
include("../global/header.php");
if($login){?>
        <link rel="stylesheet" href="/js/vui/visualUI.css"/>
        <script src='/js/jquery-ui-1.9.1.custom/js/jquery-1.8.2.js'></script>
        <script src='/js/vui/dependence.js'></script>
        <script src='../js/selenit/MantenedorClass.js'></script>
        <script src='../js/selenit/menu.js'></script>
        <script type='text/javascript'>
        $(window).load(function() {
            menu();
        });
        </script>

        <div id='idMantenedor' >
Hola
        </div>
<?php }?>


<?php include("footer.php");?>

