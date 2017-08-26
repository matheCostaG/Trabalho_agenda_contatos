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
        <i class="material-icons prefix">phone</i>
        <input name="telefone" id="icon_telephone" type="tel" class="validate">
        <label for="icon_telephone">Novo Telefone</label>
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
  $telefone = $_POST['telefone'];
  require_once 'includes/connection.php';
  $stmt = $conn->prepare("INSERT INTO telefone (idContato, telefone) VAlUES(?,?)");
  $stmt->bind_param('is',$id, $telefone);
  if($stmt->execute()){
    echo "<script>alert('Novo telefone inserido com sucesso')</script>";
  }else {
    echo "<script>alert('Erro ao inserir novo telefone')</script>";
  }

}
require_once 'includes/footer.php';
?>
