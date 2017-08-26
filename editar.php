<?php
  require_once 'includes/header.php';

  if(isset($_GET['id'])){
    require_once 'includes/connection.php';
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM contatos WHERE id = $id");
    $row = $result->fetch_assoc();

    $resultTelef = $conn->query("SELECT * FROM telefone WHERE idContato = $id");

    $resultEmail = $conn->query("SELECT * FROM email WHERE idContato = $id");
    $i= 0;
  }else{
    header('Location: index.php');
  }

  ?>

     <h5 class="center-align">EDITAR CONTATO</h5>
     <div class="container">
       <div class="row">
       <form class="col s12" method="post" enctype="multipart/form-data">
         <div class="row">
           <div class="col s3">
             <h5>Foto do Contato</h5>
             <img class="responsive-img circle" src="imagens/user.png">
             <input type="file" name="photo_profile" />
           </div>
         </div>
         <div class="row">
           <div class="input-field col s6">
             <i class="material-icons prefix">account_circle</i>
             <input type="text" id="icon_prefix" type="text" class="validate" name="nome" value="<?=$row['nome']?>">
             <label for="icon_prefix">Nome</label>
           </div>
           <div class="input-field col s6">
             <i class="material-icons prefix">date_range</i>
             <input type="date" id="icon_nascimento" type="tel" class="validate" name="data_nascimento" value="<?=$row['data_nascimento']?>">
             <!-- <label for="icon_nascimento">Data de Nascimento</label> -->
           </div>
         </div>
         <div class='row'>
         <?php
         while($rowEmail  = $resultEmail->fetch_assoc()){
           $i++;
          echo "<div class='input-field col s6'>";
          echo "<i class='material-icons prefix'>email</i>";
          echo "<input type='email' id='icon_prefix' type='text' class='validate' name='email".$i."' value=".$rowEmail['email'].">";
          echo "<label for='icon_prefix'>Email".$i."</label>";
          echo "<input type='hidden' name='idEmail$i' value=".$rowEmail['id'].">";
          echo "</div>";
        }
        echo "<input type='hidden' name='rEmail' value=".$i.">";
        $i = 0;
        while ($rowTelef = $resultTelef->fetch_assoc()) {
          $i++;
          echo "<div class='input-field col s6'>";
          echo "<i class='material-icons prefix'>phone</i>";
          echo "<input name='telefone".$i."' id='icon_telephone' type='tel' class='validate' value=".$rowTelef['telefone'].">";
          echo "<label for='icon_telephone'>Telefone$i</label>";
          echo "<input type='hidden' name='idTelefone$i' value=".$rowTelef['id'].">";
          echo "</div>";
        }
        echo "<input type='hidden' name='rTelefone' value=".$i.">";
        $i=0;
         ?>
        </div>
         <div class="row">
           <div class="col s12">
             <input class="btn waves-effect waves-light" type="submit" value="Concluir" />
           </div>
         </div>
       </form>
       <div class="row">
         <div class="col s12">
           <a href="novo_email.php?id=<?=$id?>"><button class="btn waves-effect waves-light"/>Adicionar novo Email</button></a>
         </div>
       </div>
       <div class="row">
         <div class="col s12">
           <a href="novo_telefone.php?id=<?=$id?>"><button class="btn waves-effect waves-light"/>Adicionar novo Telefone</button></a>
         </div>
       </div>
     </div>
  </div>
<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once 'includes/connection.php';

    $post = $_POST;

    $nome = $post['nome'];
    $data = $post['data_nascimento'];

    $stmt = $conn->prepare("UPDATE contatos set nome = ?, data_nascimento = ? WHERE id = ?");
    $stmt->bind_param('ssi', $post['nome'], $post['data_nascimento'], $id);

    $stmt->execute();
    $init = 0;

    while($init < $post['rEmail']) {
      $init++;
      $stmtE = $conn->prepare("UPDATE email set email = ? WHERE id = ?");
      $stmtE->bind_param('si', $post['email'.$init.''], $post['idEmail'.$init.'']);
      $stmtE->execute();
    }
    $init = 0;
    while($init < $post['rTelefone']) {
      $init++;
      $stmtF = $conn->prepare("UPDATE telefone set telefone = ? WHERE id = ?");
      $stmtF->bind_param('si', $post['telefone'.$init.''], $post['idTelefone'.$init.'']);
      $stmtF->execute();
    }
    $idUser = $id;

    $imagem = $_FILES['photo_profile'];

    if($imagem['error']){
      echo "Error";
      die();
    }

    $dirImagens = 'imagens';

    if(!is_dir($dirImagens)){
      mkdir($dirImagens);
    }

    $new_path = $dirImagens. DIRECTORY_SEPARATOR .$idUser.".jpg";

    if(move_uploaded_file($imagem['tmp_name'], $new_path)){
      $img_contato =  $idUser.".jpg";
      $conn->query("UPDATE contatos SET img_contato = '$img_contato' WHERE id = '$idUser'");
    }else{
      echo "Erro no upload";
    }
  }







  require_once 'includes/footer.php';
?>
