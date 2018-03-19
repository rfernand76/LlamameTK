<?php
   $n=$_GET["n"];  
   $letra=$_GET["letra"];  
   $numero=$_GET["numero"];
   $nomFila=$_GET["nomFila"];
   $url=$_GET["url"];
   
   $a = explode(":", $numero);
?>

<div id="dialog" title="Ticket de atención">
  <p align="center" style="font-size: 30px;"><?php echo "$letra $a[0]"?></p></br>
  <p align="center" style="margin-top:-10px;"><?php echo "$nomFila"?></p></br>
  <h2 align="center">
      Utilice el siguiente enlace para seguimiento online</br>
     <img src="../global/temp/test.png?t=<?php echo $n?>" />
  </h2>
  <h2 align="center">
      O entre a <b><?php echo $url;?></b> y escriba el siguiente código <c class="container"><?php echo $a[1]?></c>
  </h2>
  
      
  </p>
</div>
