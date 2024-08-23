<?php
  $conec=mysqli_connect('localhost','root', 'rootroot', 'pasaportes');
  
  
  # Comprobar si existe registro
  
   if(!$conec){
     die("Connection failed: " . mysqli_connect_error());
   }else{
     echo "Conexion correcta";
 //mysqli_close($conec);
   }
?>