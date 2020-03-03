
    <?php
        include_once('../conexao.php');
    ?>

<?php 
  
  $cpf = $_GET['cpf'];

  $query = "select * from alunos where cpf = '$cpf' ";
  $result = mysqli_query($conexao, $query);

  while($res = mysqli_fetch_array($result)){
        $nome = $res["nome"];
        $email = $res["email"];
        $senha = $res["senha"];
        $telefone = $res["telefone"];
        $cpf = $res["cpf"];
        $endereco = $res["endereco"];
        $cidade = $res["cidade"];
        $estado = $res["estado"];

        if(isset($_GET['img'])){
          $foto = $_GET['img'];
        }else{
          $foto = $res["imagem"];
        }
                          
?>




<div class="container ml-4">

  <form class="mr-4" method="post">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4 " class="text-light">Nome</label>
        <input type="text" class="form-control text-dark" name="nome" placeholder="Nome" value="<? echo $nome; ?>">
      </div>
      <div class="form-group col-md-3">
        <label for="inputPassword4" class="text-light">Telefone</label>
        <input type="text" class="form-control text-dark" id="telefone" name="telefone" placeholder="Telefone" value="<? echo $telefone; ?>">
      </div>
      <div class="form-group col-md-3">
        <label for="inputPassword4" class="text-light">CPF</label>
        <input type="text" class="form-control text-dark" id="cpf" name="cpf" placeholder="CPF" value="<? echo $cpf; ?>">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4" class="text-light">Email</label>
        <input type="email" class="form-control text-dark" name="email" placeholder="Email" value="<? echo $email; ?>">
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4" class="text-light">Senha</label>
        <input type="text" class="form-control text-dark" name="senha" placeholder="Senha" value="<? echo $senha; ?>">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputAddress" class="text-light">Endereço</label>
        <input type="text" class="form-control text-dark" name="endereco" id="endereco" placeholder="Rua dos Bobos, nº 0" value="<? echo $endereco; ?>">
      </div>
      
      <div class="form-group col-md-4">
        <label for="inputCity" class="text-light">Cidade</label>
        <input type="text" class="form-control text-dark" name="cidade" id="cidade" value="<? echo $cidade; ?>">
      </div>

      <div class="form-group col-md-2">
        <label for="inputEstado" class="text-light">Estado</label>
        <select id="estado" name="estado" class="form-control text-dark">
          <option value="MG" <?php if($estado == 'MG'){ ?> selected <?php } ?> >MG</option>
        <option value="SP" <?php if($estado == 'SP'){ ?> selected <?php } ?>>SP</option>

         <option value="RJ" <?php if($estado == 'RJ'){ ?> selected <?php } ?>>RJ</option>

         <option value="RS" <?php if($estado == 'RS'){ ?> selected <?php } ?>>RS</option>
        </select>
      </div>
    </div>

</div>

<div class="container ml-4">
  <div class="form-row">

    <div class="form-group col-md-2 mt-4">
        <button name="salvar" type="submit" class="btn btn-primary">Salvar</button>
    </div>

  </form>

    <div class="form-group col-md-5">
      <label for="inputAddress" class="text-light">Foto</label>
      <div class="custom-file">
        <form method="post" enctype="multipart/form-data">
            <input type="file" class="custom-file-input" name="imagem" id="imagem">
            <label class="custom-file-label text-light" for="customFile" >Escolher Foto</label>
      </div>
    </div>

    <div class="form-group ">
      <label for="inputAddress" class="text-light">Atualizar</label>
      <div class="custom-file">
        <button type="submit" name="atualizar" class="btn btn-secondary"><i class="fas fa-sync-alt"></i></button>
      </div>
    </div>
                   
    <div class="form-group col-md-3">
      <img src="../imagens/perfil/<? echo $foto; ?>" width="120">
    </div>
   
    
 
  </div>

  </form>

</div>


    




<?php

  if(isset($_POST['atualizar'])){



    $caminho = '../imagens/perfil/' .$_FILES['imagem']['name'];
    $imagem = $_FILES['imagem']['name']; 
    $imagem_temp = $_FILES['imagem']['tmp_name']; 
    move_uploaded_file($imagem_temp, $caminho);


    echo "<script language='javascript'>window.location= 'painel_aluno.php?acao=perfil&cpf=$cpf&img=$imagem'</script>";

  }

?>



<?php

  if(isset($_POST['salvar'])){

    $nome_post = $_POST['nome'];
    $telefone_post = $_POST['telefone'];
    $cpf_post = $_POST['cpf'];
    $email_post = $_POST['email'];
    $senha_post = $_POST['senha'];
    $endereco_post = $_POST['endereco'];
    $cidade_post = $_POST['cidade'];
    $estado_post = $_POST['estado'];

  

  if($res["cpf"] != $cpf_post){
      //VERIFICAR SE O CPF JÁ ESTÁ CADASTRADO
    $query_verificar_cpf = "SELECT * from alunos where cpf = '$cpf_post' ";
    $result_verificar_cpf = mysqli_query($conexao, $query_verificar_cpf);
    $row_verificar_cpf = mysqli_num_rows($result_verificar_cpf);
      if($row_verificar_cpf > 0){
        echo "<script language='javascript'>window.alert('CPF já Cadastrado'); </script>";
        exit();
      }


    }

    if($res["email"] != $email_post){
    //VERIFICAR SE O USUARIO JÁ ESTÁ CADASTRADO
    $query_verificar_usu = "SELECT * from alunos where email = '$email_post' ";
    $result_verificar_usu = mysqli_query($conexao, $query_verificar_usu);
    $row_verificar_usu = mysqli_num_rows($result_verificar_usu);
      if($row_verificar_usu > 0){
        echo "<script language='javascript'>window.alert('Usuário já Cadastrado'); </script>";
        exit();
      }


    }


    $query_post = "UPDATE alunos SET nome = '$nome_post', telefone = '$telefone_post', cpf = '$cpf_post', email = '$email_post', senha = '$senha_post', endereco = '$endereco_post', cidade = '$cidade_post', estado = '$estado_post', imagem = '$foto' where cpf = '$res[cpf]' ";

    $result_post = mysqli_query($conexao, $query_post);


    $query_post_usuario = "UPDATE usuarios SET nome = '$nome_post', cpf = '$cpf_post', usuario = '$email_post', senha = '$senha_post' where cpf = '$res[cpf]' ";

    $result_post_usuario = mysqli_query($conexao, $query_post_usuario);


    $_SESSION['cpf_usuario'] = $cpf_post;
    

    echo "<script language='javascript'>window.alert('Dados Alterados!!'); </script>";

    echo "<script language='javascript'>window.location='painel_aluno.php?acao=perfil&cpf=$cpf_post'; </script>";

  }

?>


<? } ?>

 <!--MASCARAS -->

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
      $('#telefone').mask('(00) 00000-0000');
      $('#cpf').mask('000.000.000-00');
      });
</script>