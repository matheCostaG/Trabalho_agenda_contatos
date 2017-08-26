<?php
  $conn = new mysqli("localhost", "root", "170s6612", "agenda");

    if($conn->connect_error){
      echo "<script> alert('erro ao conectar ao banco de dados');</script>";
    }

 ?>
