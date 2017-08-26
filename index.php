<?php
 require_once 'includes/header.php';
 ?>
 <div class="container">
   <?php

   require_once 'includes/connection.php';

   $result = $conn->query("SELECT * FROM contatos");
   $i = 0;

   ?>
   <div class='row'>


  <?php
   while ($row = $result->fetch_assoc()){

        echo "<div class='col s4 m4'>";
        echo "<div class='card large z-depth-5 t-card' >";
        echo "<div class='card-image'>";
        echo "<img src='imagens/".$row['img_contato']."'>";
        echo "<span class='card-title'>".$row['nome']."</span>";
        echo "</div>";
        echo "<div class='card-content'>";
        $resultTelef = $conn->query("SELECT * FROM telefone WHERE idContato = '$row[id]'");
        while ($rowTelef = $resultTelef->fetch_assoc()){
        $i++;
        echo "<p><strong>Telefone".$i.": </strong>".$rowTelef['telefone']."</p>";
        }
        $i = 0;
        $resultEmail = $conn->query("SELECT * FROM email WHERE idContato = '$row[id]'");
        while ($rowEmail  = $resultEmail->fetch_assoc()){
        $i++;
        echo "<p><strong>E-mail".$i.": </strong>".$rowEmail['email']."</p>";
        }
        $i = 0;
        echo "<p><strong>Data de nascimento: </strong>".$row['data_nascimento']."</p>";
        echo "</div>";
        echo "<div class='card-action'>";
        echo "<a href='editar.php?id=".$row['id']."'>Editar</a>";
        echo "<a href='excluir.php?id=".$row['id']."'>Excluir</a>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

   }
   if(isset($_GET['deletado'])){
     if($_GET['deletado'] == 'sucesso'){
       echo '<script>alert("Deletado com sucesso")</script>';
     }
   }
    ?>
    </div>
  </div>
