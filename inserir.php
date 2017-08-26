<?php
  require_once 'includes/header.php';
?>

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
        <input type="text" id="icon_prefix" type="text" class="validate" name="nome">
        <label for="icon_prefix">Nome</label>
      </div>
      <div class="input-field col s6">
        <i class="material-icons prefix">date_range</i>
        <input type="date" id="icon_nascimento" type="tel" class="validate" name="data_nascimento">
        <!-- <label for="icon_nascimento">Data de Nascimento</label> -->
      </div>
    </div>

    <div class="row">
      <div class="input-field col s6">
        <i class="material-icons prefix">email</i>
        <input type="email" id="icon_prefix" type="text" class="validate" name="email">
        <label for="icon_prefix">Email</label>
      </div>
      <div class="input-field col s6">
        <i class="material-icons prefix">phone</i>
        <input name="telefone" id="icon_telephone" type="tel" class="validate">
        <label for="icon_telephone">Telefone</label>
      </div>
    </div>

    <div class="row">
      <div class="col s12">
        <input class="btn waves-effect waves-light" type="submit" value="Adicionar" />
      </div>
    </div>
  </form>
</div>

</div>
<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $nome = $_POST['nome'];
    $dataNascimeto = $_POST['data_nascimento'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    require_once 'includes/connection.php';

    $stmt = $conn->prepare("CALL inserir(?,?,?,?)");

    $stmt->bind_param('ssss', $nome, $dataNascimeto, $telefone ,$email);

    if($stmt->execute()){
      echo "<script>alert('Inserido com sucesso')</script>";
    }

    $result = $conn->query("SELECT * FROM contatos WHERE id = @uId");
    $row = $result->fetch_assoc();
    $idUser = $row['id'];

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
