<?php
   $n=$_GET["n"];  
   $letra=$_GET["letra"];  
   $numero=$_GET["numero"];
   $nomFila=$_GET["nomFila"];
   $url=$_GET["url"];
   
   $a = explode(":", $numero);
?>

<div id="dialog" title="Ticket de atención">
  <p align="center" style="color:  #000000;font-size: 30px;"><?php echo "$letra $a[0]"?></p></br>
  <p align="center" style="color: #324957;  margin-top:-10px;"><?php echo "$nomFila"?></p></br>
  <p align="center">
      Utilice el siguiente enlace para seguimiento online</br>
     <img src="../global/temp/test.png?t=<?php echo $n?>" />
  </p>
  <p align="center" style="color: #324957;">
      O ingrese <c class="container"><?php echo $a[1]?></c> en
  </p>
  
  <p align="center" style="color: #324957">
      <?php echo $url;?>
  </p>
</div>
