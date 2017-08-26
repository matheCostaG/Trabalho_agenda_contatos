<?php

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    require_once 'includes/connection.php';

    if($conn->query("call excluir('$id')")){
      header('Location: index.php?deletado=sucesso');
    }else{
      header('Location: index.php');
    }
  }
 ?>
