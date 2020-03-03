
<? include_once "../conexao.php" ?>


    <div class="container ml-4">
      <div class="row">

        <div class="col-lg-8 col-md-6 col-sm-12">
          <button class="btn btn-outline-secondary bg-light" data-toggle="modal" data-target="#modalExemplo"> <i class="fas fa-user-plus"> USUÁRIOS </i> </button>

      </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
          <form class="form-inline my-2 my-lg-0">
            <input name="txtpesquisarUsuarios" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Cursos" aria-label="Pesquisar">
            <button name="buttonPesquisar" class="btn btn-outline-secondary my-2 my-sm-0 bg-light" type="submit"><i class="fa fa-search"></i></button>
          </form>
      </div>
    </div>
  </div>



<div class="container ml-4">


    <br>

        
          <div class="content">
            <div class="row mr-3">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                   
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">

                      <!--LISTAR TODOS OS USUÁRIOS -->
                      <?php 
                        if(isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarUsuarios'] != ''){



                          $nome = $_GET['txtpesquisarUsuarios'] . '%';
                          $cpf = $_GET['txtpesquisarUsuarios'];
                          $query = "SELECT * from usuarios where nome LIKE '$nome' or cpf = '$cpf' order by nome asc ";

                          $result_count = mysqli_query($conexao, $query);

                        }else{
                          $query = "SELECT * from usuarios order by id desc limit 10";

                          $query_count = "SELECT * from usuarios";
                          $result_count = mysqli_query($conexao, $query_count);

                        }

                        $result = mysqli_query($conexao, $query);
                        
                        $linha = mysqli_num_rows($result);
                        $linha_count = mysqli_num_rows($result_count);

                        if($linha == ''){
                          echo "<h3> Não foram encontrados dados Cadastrados no Banco!! </h3>";
                        }else{

                          ?>


                                               

                      <table class="table">
                        <thead class="text-secondary">
                          
                          <th>
                            Nome
                          </th>
                          <th>
                            CPF
                          </th>
                          <th>
                            Usuário
                          </th>
                           <th>
                            Senha
                          </th>
                            <th>
                            Nível
                          </th>
                           <th>
                            Data
                          </th>
                         
                            <th>
                            Ações
                          </th>
                        </thead>
                        <tbody>
                        
                        <?php
                          while($res = mysqli_fetch_array($result)){
                            $nome = $res["nome"];
                            $cpf = $res["cpf"];
                            $usuario = $res["usuario"];
                            $senha = $res["senha"];
                            $nivel = $res["nivel"];
                            $data = $res["data"];
                            $id = $res["id"];

                            $data2 = implode('/', array_reverse(explode('-', $data)));
                          
                        ?>

                            <tr>

                             <td><?php echo $nome; ?></td>
                             <td><?php echo $cpf; ?></td> 
                             <td><?php echo $usuario; ?></td>
                             <td><?php echo $senha; ?></td>
                             <td><?php echo $nivel; ?></td>
                             <td><?php echo $data2; ?></td>
                            
                             <td>
                             <a class="btn btn-info" href='painel_admin.php?acao=usuarios&func=edita&id=<?php echo $id; ?>'   ><i class="fas fa-edit"></i></a>

                             <a class="btn btn-danger" href="painel_admin.php?acao=usuarios&func=excluir&id=<?php echo $id; ?>"><i class="fa fa-minus-square"></i></a>

                             </td>
                            </tr>

                           <?php } ?>
                           

                        </tbody>
                        <tfoot>
                          <tr>

                             <td></td>
                             <td></td> 
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>

                          <td>
                            <span class="text-muted">Registros: <?php echo $linha_count ?> </span>
                          </td>
                        </tr>

                        </tfoot>
                      </table>

                      <?php
                        }

                      ?>
                         
                    </div>
                  </div>
                </div>
              </div>

</div>






<!-- Modal -->
      <div id="modalExemplo" class="modal fade" role="dialog">
        <div class="modal-dialog ">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title">Usuários</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="POST" action="">

              <div class="form-group">
                <label for="id_produto">Nome</label>
                <input type="text" class="form-control mr-2 text-dark" name="nome" placeholder="Nome" required>
              </div>

                <div class="form-group">
                <label for="id_produto">CPF</label>
                <input type="text" class="form-control mr-2 text-dark" name="cpf" placeholder="CPF" id="cpf" required>
              </div>

              <div class="form-group">
                <label for="id_produto">Email / Usuário</label>
                <input type="email" class="form-control mr-2 text-dark" name="usuario" placeholder="Usuário" required>
              </div>

               <div class="form-group">
                <label for="fornecedor">Senha</label>
                 <input type="text" class="form-control mr-2 text-dark" name="senha" placeholder="Senha" required>
              </div>

               <div class="form-group">
                <label for="fornecedor">Nível</label>
                  <select class="form-control mr-2 text-dark" id="category" name="nivel">
                                                            
                    <option value="Aluno">Aluno</option> 
                    <option value="Professor">Professor</option> 
                       
               </select>
              </div>

             
            
               
             
            </div>
                   
            <div class="modal-footer">
               <button type="submit" class="btn btn-success mb-3" name="salvar">Salvar </button>


                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
            </form>
            </div>
          </div>
        </div>
      </div>    




<!--CADASTRO -->

<?php 
  if(isset($_POST['salvar'])){
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];



    //VERIFICAR SE O CPF JÁ ESTÁ CADASTRADO
    $query_verificar_cpf = "SELECT * from usuarios where cpf = '$cpf' ";
    $result_verificar_cpf = mysqli_query($conexao, $query_verificar_cpf);
    $row_verificar_cpf = mysqli_num_rows($result_verificar_cpf);
    if($row_verificar_cpf > 0){
      echo "<script language='javascript'>window.alert('CPF já Cadastrado'); </script>";
      exit();
    }


    //VERIFICAR SE O USUARIO JÁ ESTÁ CADASTRADO
    $query_verificar_usu = "SELECT * from usuarios where usuario = '$usuario' and nivel = '$nivel' ";
    $result_verificar_usu = mysqli_query($conexao, $query_verificar_usu);
    $row_verificar_usu = mysqli_num_rows($result_verificar_usu);
    if($row_verificar_usu > 0){
      echo "<script language='javascript'>window.alert('Usuário já Cadastrado'); </script>";
      exit();
    }



    $query = "INSERT INTO usuarios (nome, cpf, usuario, senha, nivel, data) values ('$nome', '$cpf', '$usuario', '$senha', '$nivel', curDate())";

    $result = mysqli_query($conexao, $query);


    //INSERINDO NA TABELA DE ALUNOS
    if($nivel == 'Aluno'){

      $query_alunos = "INSERT INTO alunos (nome, cpf, email, senha, imagem, data) values ('$nome', '$cpf', '$usuario', '$senha', 'semperfil.png', curDate())";

      $result_alunos = mysqli_query($conexao, $query_alunos);


    }

    //INSERINDO NA TABELA DE ALUNOS
    if($nivel == 'Professor'){

      $query_alunos = "INSERT INTO professores (nome, cpf, email, senha, imagem, data) values ('$nome', '$cpf', '$usuario', '$senha', 'semperfil.png', curDate())";

      $result_alunos = mysqli_query($conexao, $query_alunos);


    }
    


    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
    }else{
      echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
      echo "<script language='javascript'>window.location='painel_admin.php?acao=usuarios'; </script>";

    }
    
  }
 ?>




<!--EDITAR -->
<?php 
  if(@$_GET['func'] == 'edita'){
    $id = $_GET['id'];

  $query = "select * from usuarios where id = '$id' ";
  $result = mysqli_query($conexao, $query);

  while($res = mysqli_fetch_array($result)){
        $nome = $res["nome"];
        $cpf = $res["cpf"];
        $usuario = $res["usuario"];
        $senha = $res["senha"];
        $nivel = $res["nivel"];
        $data = $res["data"];
                            
    ?>

    <!-- Modal Editar -->
      <div id="modalEditar" class="modal fade" role="dialog">
        <div class="modal-dialog">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title">Usuários</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="POST" action="">

              <div class="form-group">
                <label for="id_produto">Nome</label>
                <input type="text" class="form-control mr-2 text-dark" name="nome" value="<?php echo $nome ?>" placeholder="Nome" required>
              </div>

                <div class="form-group">
                <label for="id_produto">CPF</label>
                <input type="text" class="form-control mr-2 text-dark" name="cpf" placeholder="CPF" id="cpf" value="<?php echo $cpf ?>" required>
              </div>

              <div class="form-group">
                <label for="id_produto">Email / Usuário</label>
                <input type="email" class="form-control mr-2 text-dark" name="usuario" placeholder="Usuário" value="<?php echo $usuario ?>" required>
              </div>

               <div class="form-group">
                <label for="fornecedor">Senha</label>
                 <input type="text" class="form-control mr-2 text-dark" name="senha" placeholder="Senha" value="<?php echo $senha ?>" required>
              </div>

              <div class="form-group">
                <label for="fornecedor">Nível</label>
                  <select class="form-control mr-2 text-dark" id="category" name="nivel">
                                                            
                    <option value="Aluno">Aluno</option> 
                    <option value="Professor">Professor</option> 
                       
               </select>
              </div>


            </div>
                   
            <div class="modal-footer">
               <button type="submit" class="btn btn-success mb-3" name="editar">Salvar </button>


                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
            </form>
            </div>
          </div>
        </div>
      </div>    


  <?php


  if(isset($_POST['editar'])){
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];


    if($res["cpf"] != $cpf){
      //VERIFICAR SE O CPF JÁ ESTÁ CADASTRADO
    $query_verificar_cpf = "SELECT * from usuarios where cpf = '$cpf' ";
    $result_verificar_cpf = mysqli_query($conexao, $query_verificar_cpf);
    $row_verificar_cpf = mysqli_num_rows($result_verificar_cpf);
      if($row_verificar_cpf > 0){
        echo "<script language='javascript'>window.alert('CPF já Cadastrado'); </script>";
        exit();
      }
    }

    if($res["usuario"] != $usuario){
    //VERIFICAR SE O USUARIO JÁ ESTÁ CADASTRADO
    $query_verificar_usu = "SELECT * from usuarios where usuario = '$usuario' and nivel = '$nivel' ";
    $result_verificar_usu = mysqli_query($conexao, $query_verificar_usu);
    $row_verificar_usu = mysqli_num_rows($result_verificar_usu);
      if($row_verificar_usu > 0){
        echo "<script language='javascript'>window.alert('Usuário já Cadastrado'); </script>";
        exit();
      }
    }


    $query = "UPDATE usuarios SET nome = '$nome', cpf = '$cpf', usuario = '$usuario', senha = '$senha' where id = '$id' ";

    $result = mysqli_query($conexao, $query);


    //atualização dos alunos
     if($nivel == 'Aluno'){
        $query_alunos = "UPDATE alunos SET nome = '$nome', cpf = '$cpf', email = '$usuario', senha = '$senha' where cpf = '$res[cpf]' ";

        $result_alunos = mysqli_query($conexao, $query_alunos);
      }

      //atualização dos alunos
     if($nivel == 'Professor'){
        $query_alunos = "UPDATE professores SET nome = '$nome', cpf = '$cpf', email = '$usuario', senha = '$senha' where cpf = '$res[cpf]' ";

        $result_alunos = mysqli_query($conexao, $query_alunos);
      }



    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
    }else{
      echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
      echo "<script language='javascript'>window.location='painel_admin.php?acao=usuarios'; </script>";

    }

  }
    



   } } 

   ?>


   <script> $("#modalEditar").modal("show"); </script> 

  

<!--EXCLUIR -->
<?php 
  if(@$_GET['func'] == 'excluir'){
    $id = $_GET['id'];



  //recuperar cpf do usuário
  $query_cpf = "select * from usuarios where id = '$id' ";
  $result_cpf = mysqli_query($conexao, $query_cpf);

  while($res = mysqli_fetch_array($result_cpf)){
   
        $cpf = $res["cpf"];
        $nivel = $res["nivel"];
      


   //exclusao dos alunos
     if($nivel == 'Aluno'){
        $query_alunos = "DELETE FROM alunos where cpf = '$cpf' ";

        $result_alunos = mysqli_query($conexao, $query_alunos);
      } 

    } 



  $query = "DELETE FROM usuarios where id = '$id' ";
  $result = mysqli_query($conexao, $query);
  echo "<script language='javascript'>window.location='painel_admin.php?acao=usuarios'; </script>";

  
 

}

?>



 


 <!--MASCARAS -->

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
      $('#telefone').mask('(00) 00000-0000');
      $('#cpf').mask('000.000.000-00');
      });
</script>