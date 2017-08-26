<?php
  require_once 'includes/header.php';
  if(isset($_GET['id'])){
    $id = $_GET['id'];
  }else{
    header("Location: idex.php");
  }

 ?>

<div class="container">
  <form class="col s12" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="input-field col s6">
        <i class="material-icons prefix">email</i>
        <input type="email" id="icon_prefix" type="text" class="validate" name="email">
        <label for="icon_prefix">Digite o novo email</label>
      </div>
    </div>
    <div class="row">
      <div class="col s12">
        <input class="btn waves-effect waves-light" type="submit" value="Concluir" />
      </div>
    </div>
  </form>
</div>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $email = $_POST['email'];
  require_once 'includes/connection.php';
  $stmt = $conn->prepare("INSERT INTO email (idContato, email) VAlUES(?,?)");
  $stmt->bind_param('is',$id, $email);
  if($stmt->execute()){
    echo "<script>alert('Novo email inserido com sucesso')</script>";
  }else {
    echo "<script>alert('Erro ao inserir novo email')</script>";
  }

}
require_once 'includes/footer.php';
?>
