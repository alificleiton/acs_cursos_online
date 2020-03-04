<?php

  include_once "cabecalho.php";
  include_once "conexao.php";
  session_start();

  $id_curso = @$_GET['curso'];

?>

    <div class="modal-dialog text-center">
        <div class=" col-md-12 main-section ">
          <div class="modal-content">
            <div class="py-3 col-12 user-img">
              <img src="imagens/login.png">
            </div>

            <div class="col-12 form-input">
              <form action="autenticar.php?curso=<? echo $id_curso;?>" method="post">
                <div class="form-group">
                  <input type="email" name="usuario" class="form-control text-dark" placeholder="Email" required>
                </div>

                <div class="form-group">
                  <input type="password" name="senha" class="form-control text-dark" placeholder="Senha" required>
                </div>

                <button type="submit" class="btn btn-success">Login</button>
              </form>
            </div>

            <div class="col-12 forgot">
              <div class="d-flex justify-content-center links"> Não possui cadastro? <a href="login.php?curso=0&acao=cadastro"  class="ml-2"> Cadastre-se</a>
              </div>
              <div class="d-flex justify-content-center links">  <a href="#" class="ml-2">Recuperar senha</a>
              </div>

            </div>






          </div>
        </div>
    </div>

<!-- MODAL PAGAMENTO -->
<?php 
  if(@$id_curso != '' and @$_GET['acao'] != ''){
    
    

    
?>

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
                    <? if($id_curso == 0){ ?>
                      <option value="Professor">Professor</option> 
                    <? } ?>
                       
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

  <? } ?> 

<?php
  if(isset($_SESSION['nao_autenticado'])){
    echo "<script language='javascript'>window.alert('Usuário ou senha incorretos!!!'); </script>";
  }

  unset($_SESSION['nao_autenticado']);

?>

      <!--CADASTRO -->

<?php 

  if(isset($_POST['salvar'])){
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];


    //VERIFICAR SE O CPF JÁ ESTÁ CADASTRADO
    $query_verificar_cpf = "SELECT * from usuarios where cpf = '$cpf' and usuario = '$usuario' and senha = '$senha' ";
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

      $query_alunos = "INSERT INTO alunos (nome, cpf, email, senha, imagem, data) values ('$nome', '$cpf', '$usuario', '$senha', 'sem-perfil.png', curDate())";

      $result_alunos = mysqli_query($conexao, $query_alunos);


    }


    //INSERINDO NA TABELA DE ALUNOS
    if($nivel == 'Professor'){

      $query_professor = "INSERT INTO professores (nome, cpf, email, senha, imagem, data) values ('$nome', '$cpf', '$usuario', '$senha', 'semperfil.png', curDate())";

      mysqli_query($conexao, $query_professor);


    }
    


    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
    }else{
      echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";

      if($id_curso == 0){
        echo "<script language='javascript'>window.location='login.php'; </script>";
      }else{

        echo "<script language='javascript'>window.location='login.php?curso=$id_curso'; </script>";

      }


      

    }
    
  }
 ?>
    
<?php

  include_once "rodape.php"

?>

<!--MASCARAS -->

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
      $('#telefone').mask('(00) 00000-0000');
      $('#cpf').mask('000.000.000-00');
      });
</script>


<script> $("#modalExemplo").modal("show"); </script>