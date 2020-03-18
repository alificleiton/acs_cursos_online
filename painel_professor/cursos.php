<?php
    include_once('../conexao.php');
?>


    <div class="container ml-4">
      <div class="row">

        <div class="col-lg-8 col-md-6 col-sm-12">
          <button class="btn btn-outline-secondary bg-light" data-toggle="modal" data-target="#modalExemplo"> <i class="fas fa-user-plus"> CURSOS </i> </button>

      </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
          <form class="form-inline my-2 my-lg-0">
            <input name="txtpesquisarCursos" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Cursos" aria-label="Pesquisar">
            <button name="buttonPesquisar " class="btn btn-outline-secondary my-2 my-sm-0 bg-light" type="submit"><i class="fa fa-search"></i></button>
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

                        


                        if(isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarCursos'] != ''){



                          $nome = '%' .$_GET['txtpesquisarCursos'] . '%';
                          
                          $query = "SELECT c.id, c.nome, c.desc_rapida, c.desc_longa, c.valor, c.aulas, c.professor, c.categoria, c.imagem, c.status, c.mensagem, cat.nome as nome_categoria from cursos as c INNER JOIN categorias as cat ON c.categoria = cat.id where c.nome LIKE '$nome' and c.professor = '$_SESSION[cpf]' order by c.nome asc ";

                          $result_count = mysqli_query($conexao, $query);

                        }else{
                          $query = "SELECT c.id, c.nome, c.desc_rapida, c.desc_longa, c.valor, c.aulas, c.professor, c.categoria, c.imagem, c.status, c.mensagem, cat.nome as nome_categoria from cursos as c INNER JOIN categorias as cat ON c.categoria = cat.id where c.professor = '$_SESSION[cpf]' order by c.id desc limit 10";

                          $query_count = "SELECT * from cursos where professor = '$_SESSION[cpf]'";
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
                            Valor
                          </th>
                          <th>
                            Aulas
                          </th>
                         
                          <th>
                            Categoria
                          </th>
                           <th>
                            Status
                          </th>
                          
                           <th>
                            Imagem
                          </th>
                         
                            
                         
                            <th>
                            Ações
                          </th>
                        </thead>
                        <tbody>
                        
                        <?php
                          while($res = mysqli_fetch_array($result)){
                            $nome = $res["nome"];
                            $desc_rapida = $res["desc_rapida"];
                            $desc_longa = $res["desc_longa"];
                            $valor = $res["valor"];
                            $aulas = $res["aulas"];
                            $professor = $res["professor"];
                            $categoria = $res["categoria"];
                            $imagem = $res["imagem"];
                            $status = $res["status"];
                            $mensagem = $res["mensagem"];
                            $id = $res["id"];
                            $nome_categoria = $res["nome_categoria"];

                          
                        ?>

                            <tr>

                             <td>

                               <a class="text-dark" title="Adicionar Aulas" href="painel_professor.php?acao=cursos&func=aulas&id=<?php echo $id; ?>">

                              <?php echo $nome; ?> </a>

                              <?php if($mensagem != ''){ ?>

                                <a class="text-warning" title="Mensagem do Administrador" href="painel_professor.php?acao=cursos&func=mensagem&id=<?php echo $id; ?>"><i class="fas fa-sticky-note"></i></a>

                             <?php } ?>
                               
                             </td>


                             <td><?php echo $valor; ?></td> 
                            
                             <td><?php echo $aulas; ?></td>
                             
                             <td><?php echo $nome_categoria; ?></td>
                             

                             <td align="center">

                              <?php if($status == 'Em Construção'){  ?>
                              <i class="fas fa-square text-danger"></i>
                              <?php } ?>

                              <?php if($status == 'Em Análise'){  ?>
                              <i class="fas fa-square text-warning"></i>
                              <?php } ?>

                              <?php if($status == 'Aprovado'){  ?>
                              <i class="fas fa-square text-success"></i>
                              <?php } ?>


                            </td>



                             
                              <td><img src="../imagens/cursos/<?php echo $imagem; ?>" width="37" height="37" ></td>
                            

                                                        
                            
                             <td>

                              <?php
                                $query_perg = "select * from perguntas where curso = '$id' and respondida='Não' ";
                                $result_perg = mysqli_query($conexao, $query_perg);

                                $linha = mysqli_num_rows($result_perg);
                                

                                if($linha == ''){
                                  $linha = 0;
                                }
                                
                              ?>

                              <? if($linha > 0){ ?>

                                <a href="painel_professor.php?acao=cursos&func=pergunta&id=<? echo $id; ?>" class="btn btn-warning" title="Ver perguntas">
                                <span class="badge badge-light"><? echo $linha ?></span></a>

                               <a class="btn btn-info" title="Editar" href="painel_professor.php?acao=cursos&func=edita&id=<?php echo $id; ?>"><i class="fas fa-edit"></i></a>

                              <? }else{ ?>

                                <a href="painel_professor.php?acao=cursos&func=pergunta&id=<? echo $id; ?>" class="btn btn-info" title="Ver perguntas">
                                <span class="badge badge-light"><? echo $linha ?></span></a>

                               <a class="btn btn-info" title="Editar" href="painel_professor.php?acao=cursos&func=edita&id=<?php echo $id; ?>"><i class="fas fa-edit"></i></a>

                              <? } ?>

                                


                               <?php 

                               if($status == 'Em Construção'){  ?>

                                <a class="btn btn-danger" title="Excluir" href="painel_professor.php?acao=cursos&func=excluir&id=<?php echo $id; ?>"><i class="fa fa-minus-square"></i></a>

                                <a class="btn btn-success" title="Enviar Curso para Aprovação" href="painel_professor.php?acao=cursos&func=enviar&id=<?php echo $id; ?>"><i class="fas fa-check-circle"></i></a>


                              <?php  }  ?>


                                
                             

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
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title">Cursos</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <form method="POST" action="" enctype="multipart/form-data">

             <div class="row">

              

               

                   <div class="form-group col-md-3">
                    <label for="id_produto">Nome</label>
                    <input type="text" class="form-control mr-2" name="nome" placeholder="Nome" required>
                  </div>

                   <div class="form-group col-md-3">
                    <label for="fornecedor">Valor</label>
                     <input type="text" class="form-control mr-2" name="valor" placeholder="Valor" required>
                  </div>

                   <div class="form-group col-md-3">
                    <label for="fornecedor">Carga Horária</label>
                     <input type="number" class="form-control mr-2" name="carga" placeholder="Horas" required>
                  </div>

                   <div class="form-group col-md-3">
                    <label for="fornecedor">Categoria</label>


                      <select class="form-control mr-2" id="category" name="categoria">

                        <?php 

                        $query = "select * from categorias order by nome asc";
                        $result = mysqli_query($conexao, $query );
                        while($res = mysqli_fetch_array($result)){


                          ?>

                           <option value="<?php echo $res['id']; ?>"><?php echo $res['nome']; ?></option> 

                          <?php
                        }

                         ?>
                                                                
                       
                        
                           
                   </select>
                  </div>


               

                </div>

                  

                 
                    <div class="form-group">
                    <label for="id_produto">Descrição Curta</label>
                    <input type="text" class="form-control mr-2" name="desc_rapida" placeholder="Descriçao Curta" required>
                  </div>

                   <div class="form-group">
                    <label for="id_produto">Descrição Longa</label>
                    <textarea type="text" class="form-control mr-2" name="desc_longa" required></textarea>
                  </div>

                  

                 
                  <div class="form-group">
                   <label for="inputAddress">Foto</label>
                   <div class="custom-file">
                    <form method="post" enctype="multipart/form-data">
                      <input type="file" name="imagem" >
                     
                     
                    </div>

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
    $desc_rapida = $_POST['desc_rapida'];
    $desc_longa = $_POST['desc_longa'];
    $valor = $_POST['valor'];
    $professor = $_SESSION['cpf_usuario'];
    $categoria = $_POST['categoria'];
    $carga = $_POST['carga'];
    


    $caminho = '../imagens/cursos/' .$_FILES['imagem']['name'];
    $imagem = $_FILES['imagem']['name']; 
    $imagem_temp = $_FILES['imagem']['tmp_name']; 
    move_uploaded_file($imagem_temp, $caminho);


    

    $query = "INSERT INTO cursos (nome, desc_rapida, desc_longa, valor, professor, categoria, imagem, status, carga) values ('$nome', '$desc_rapida', '$desc_longa', '$valor', '$professor', '$categoria','$imagem', 'Em Construção', '$carga')";

    $result = mysqli_query($conexao, $query);




    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
    }else{
      echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
      echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos'; </script>";

    }
    
  }
 ?>




<!--EDITAR -->
<?php 
  if(@$_GET['func'] == 'edita'){
    $id = $_GET['id'];

  $query = "select * from cursos where id = '$id' ";
  $result = mysqli_query($conexao, $query);

  while($res = mysqli_fetch_array($result)){
    $nome = $res["nome"];
    $desc_rapida = $res["desc_rapida"];
    $desc_longa = $res["desc_longa"];
    $valor = $res["valor"];
    $categoria = $res["categoria"];
    $imagem = $res["imagem"];
    $carga = $res["carga"];

      $query_cat = "select * from categorias where id = '$categoria' ";
      $result_cat = mysqli_query($conexao, $query_cat);
      $row = mysqli_fetch_array($result_cat);
      $nome_categoria = $row['nome'];

                            
    ?>

    <!-- Modal -->
      <div id="modalEditar" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title">Cursos</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <form method="POST" action="" enctype="multipart/form-data">

             <div class="row">

              

               

                   <div class="form-group col-md-3">
                    <label for="id_produto">Nome</label>
                    <input type="text" class="form-control mr-2" name="nome" placeholder="Nome" required value="<?php echo $nome; ?>">
                  </div>

                   <div class="form-group col-md-3">
                    <label for="fornecedor">Valor</label>
                     <input type="number" class="form-control mr-2" name="valor" placeholder="Valor" required value="<?php echo $valor; ?>">
                  </div>

                   <div class="form-group col-md-3">
                    <label for="fornecedor">Carga</label>
                     <input type="number" class="form-control mr-2" name="carga" placeholder="Horas" required value="<?php echo $carga; ?>">
                  </div>

                   <div class="form-group col-md-3">
                    <label for="fornecedor">Categoria</label>


                      <select class="form-control mr-2" id="category" name="categoria">

                        <option value="<?php echo $categoria; ?>"><?php echo $nome_categoria; ?></option> 

                        <?php 

                        $query = "select * from categorias order by nome asc";
                        $result = mysqli_query($conexao, $query );



                        while($res = mysqli_fetch_array($result)){


                          ?>

                           <?php 

                           if($nome_categoria != $res['nome']){ ?>

                             <option value="<?php echo $res['id']; ?>"><?php echo $res['nome']; ?></option> 


                            
                          <?php
                             } }

                         ?>
                                                                
                       
                        
                           
                   </select>
                  </div>


               

                </div>

                  

                 
                    <div class="form-group">
                    <label for="id_produto">Descrição Curta</label>
                    <input type="text" class="form-control mr-2" name="desc_rapida" placeholder="Descriçao Curta" required value="<?php echo $desc_rapida; ?>">
                  </div>

                   <div class="form-group">
                    <label for="id_produto">Descrição Longa</label>
                    <textarea type="text" class="form-control mr-2" name="desc_longa" required ><?php echo $desc_longa; ?></textarea>
                  </div>

                  

                 
                  <div class="form-group">
                   <label for="inputAddress">Foto</label>
                   <div class="custom-file">
                    <form method="post" enctype="multipart/form-data">
                      <input type="file" class="custom-file-input" name="imagem" >
                      <label class="custom-file-label" for="customFile">Escolher Foto</label>
                     
                    </div>
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
    $desc_rapida = $_POST['desc_rapida'];
    $desc_longa = $_POST['desc_longa'];
    $valor = $_POST['valor'];
    $professor = $_SESSION['cpf_usuario'];
    $categoria = $_POST['categoria'];
    $carga = $_POST['carga'];
    


      $caminho = '../imagens/cursos/' .$_FILES['imagem']['name'];
      $imagem = $_FILES['imagem']['name']; 
      $imagem_temp = $_FILES['imagem']['tmp_name']; 
      move_uploaded_file($imagem_temp, $caminho);
   
   

  


   


   if($_FILES['imagem']['name'] == ''){
    $query = "UPDATE cursos SET nome = '$nome', desc_rapida = '$desc_rapida', desc_longa = '$desc_longa', valor = '$valor' , carga = '$carga' where id = '$id' ";

   }else{
    $query = "UPDATE cursos SET nome = '$nome', desc_rapida = '$desc_rapida', desc_longa = '$desc_longa', valor = '$valor' , carga = '$carga', imagem = '$imagem' where id = '$id' ";
   }
    

    $result = mysqli_query($conexao, $query);



    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
    }else{
      echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
      echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos'; </script>";

    }

  }
    



   } } 

   ?>

  

<!--EXCLUIR -->
<?php 
  if(@$_GET['func'] == 'excluir'){
    $id = $_GET['id'];




  $query = "DELETE FROM cursos where id = '$id' ";
  $result = mysqli_query($conexao, $query);
  echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos'; </script>";

  
 

}

?>



<!--MENSAGEM -->
<?php 
  if(@$_GET['func'] == 'mensagem'){
    $id = $_GET['id'];

    $query = "select * from cursos where id = '$id' ";
    $result = mysqli_query($conexao, $query);

    while($res = mysqli_fetch_array($result)) {
    $mensagem = $res["mensagem"]; ?>

    <!-- Modal Mensagem -->
      <div id="modalMensagem" class="modal fade" role="dialog">
        <div class="modal-dialog">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title">Mensagem</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <p> <?php echo $mensagem; ?> </p>
                   
          
            </div>
            <form method="post">
              <div class="modal-footer">
                 <button type="submit" class="btn btn-secondary mb-3" name="limpar">Limpar Mensagem </button>
              </div>
            </form>

          </div>
        </div>
      </div>    


<?php }   ?>

<?php 
 if(isset($_POST['limpar'])){

   $query_msg = "UPDATE cursos SET mensagem = '' where id = '$id' ";
   mysqli_query($conexao, $query_msg);

    echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos'; </script>";

 } }
 ?>
  



<!--ENVIAR CURSO APROVÃÇÃO -->
 <?php 
  if(@$_GET['func'] == 'enviar'){
    $id = $_GET['id'];


    $query_verificar = "SELECT * from cursos where aulas = '0' and id = '$id' ";
    $result_verificar = mysqli_query($conexao, $query_verificar);
    $row_verificar = mysqli_num_rows($result_verificar);
      if($row_verificar > 0){
        echo "<script language='javascript'>window.alert('Este Curso ainda não possui aulas'); </script>";
        exit();
      }else{

      }



  $query_msg = "UPDATE cursos SET status = 'Em Análise' where id = '$id' ";
   mysqli_query($conexao, $query_msg);

    echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos'; </script>";

  }

  ?>







<!--ADICIONAR AULAS -->
 <?php 
  if(@$_GET['func'] == 'aulas'){
    $id = $_GET['id']; 

    $query_num_aula = "select * from aulas where curso = '$id' order by id desc ";
    $result_num_aula = mysqli_query($conexao, $query_num_aula);

    $res_num_aula = mysqli_fetch_array($result_num_aula);
    $ultima_aula = $res_num_aula["num_aula"]; 
    $ultima_aula = $ultima_aula + 1;

    ?>

  <!-- Modal Aulas -->
      <div id="modalAulas" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title">Adicionar Aulas</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="POST" action="">

                <div class="row">

                   <div class="form-group col-md-2">
                    <label for="id_produto">Aula</label>
                    <input type="number" class="form-control text-dark" name="num_aula" required value="<?php echo $ultima_aula; ?>"/>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">Nome</label>
                    <input type="text" class="form-control text-dark" name="nome" maxlength="35" required />
                  </div>

                  <div class="form-group col-md-5">
                    <label for="id_produto">Link</label>
                    <input type="text" class="form-control text-dark" name="link" maxlength="300" required />
                  </div>

                  <div class="form-group col-md-2">
                     <label for="id_produto"></label>
                    <button type="submit" class="btn btn-info mt-4" name="salvar_aula">Adicionar </button>
                  </div>


                   


               
                  </form>


                  <div class="table-responsive ml-3 mr-3">

                      <!--LISTAR TODOS OS USUÁRIOS -->
                      <?php 
                        
                          $query = "select * from aulas where curso = '$id' order by num_aula asc";

                                                 

                        $result = mysqli_query($conexao, $query);
                        
                        $linha = mysqli_num_rows($result);
                        

                        if($linha == ''){
                          echo "<p> Cadastre aulas para o Curso!! </p>";
                        }else{

                          ?>

                        <!--VERIFICAR SE TEM ARQUIVO -->
                      <?php 
                        
                          $query_curso = "select * from cursos where id = '$id' and arquivo != '' ";

                          $result_curso = mysqli_query($conexao, $query_curso);
                        
                          $linha_curso = mysqli_num_rows($result_curso);
                        

                      ?>


                                               

                      <table class="table table-sm">
                        <thead class="text-secondary">
                          
                          <th>
                            Aula
                          </th>
                          
                          <th width="70%">
                            Nome
                          </th>
                          
                            <th>
                            Ações
                          </th>
                        </thead>
                        <tbody>
                        
                        <?php
                          while($res = mysqli_fetch_array($result)){
                            $nome = $res["nome"];
                            $num_aula = $res["num_aula"];
                            $id_aula = $res["id"];

                          
                        ?>

                            <tr>

                            
                             <td><?php echo $num_aula; ?></td> 
                            
                             <td><?php echo $nome; ?></td>
                             
                                                        
                            
                             <td>
                               <a class="text-info" href="painel_professor.php?acao=cursos&func2=edit&id_aula=<?php echo $id_aula; ?>&id_curso=<?php echo $id; ?>"><i class="fas fa-edit"></i></a>



                                <a class="text-danger" href="painel_professor.php?acao=cursos&func2=excluir&id_aula=<?php echo $id_aula; ?>&id_curso=<?php echo $id; ?>"><i class="fa fa-minus-square"></i></a>

                               

                             </td>
                            </tr>

                           <?php } ?>
                           

                        </tbody>
                        <tfoot>
                          <tr>

                             <td><a href="painel_professor.php?acao=cursos&func3=arquivo&id_curso=<?php echo $id; ?>"><i class="fas fa-file-alt"></i></a>
                                <? if($linha_curso > 0 ){ ?>

                                  - Arquivos.rar

                               <? } ?>
                             </td>
                             <td></td> 


                             

                          <td>
                            <span class="text-muted">Registros: <?php echo $linha ?> </span>
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
      </div> 

<?php 

    if(isset($_POST['salvar_aula'])){


      //RECUPERAR QUANTIDADE DE AULAS DO CURSO
    $query_quant_aula = "select * from cursos where id = '$id'";
    $result_quant_aula = mysqli_query($conexao, $query_quant_aula);

    $res_quant_aula = mysqli_fetch_array($result_quant_aula);
    $quant_aula = $res_quant_aula["aulas"]; 
    


    $num_aula = $_POST['num_aula']; 
    $nome = $_POST['nome'];  
    $link = $_POST['link'];  

    $query = "INSERT INTO aulas (num_aula, nome, link, curso) values ('$num_aula', '$nome', '$link', '$id')";

    $result = mysqli_query($conexao, $query);




    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
    }else{


            //atualizar a quantidade de aulas no curso
            $quant_aula = $quant_aula + 1;

            $query_aulas = "UPDATE cursos set aulas = '$quant_aula' where id = '$id' ";

            mysqli_query($conexao, $query_aulas);


            echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos&func=aulas&id=$id'; </script>";

    }

  }

 ?>



  <?php } ?>


<!-- codigo para adicionar arquivos-->
<?php 
  if(@$_GET['func3'] == 'arquivo'){
     
    $id_curso = $_GET['id_curso']; 

?>

      <!-- Modal Editar Aula -->
      <div id="modalArquivos" class="modal fade" role="dialog">
        <div class="modal-dialog">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title">Adicionar Arquivo</h5>
            
            </div>
            <div class="modal-body">
              <form method="POST" action="">

                <div class="row">

                   <div class="form-group col-md-12">
                    <label for="id_produto">Aula</label>
                    <input type="text" class="form-control text-dark" name="arquivo" />
                  </div>

                </div>

                <div class="modal-footer">
               <button type="submit" class="btn btn-info mb-3" name="add_arquivo">Adicionar </button>


                <button type="submit" class="btn btn-info mb-3 " name="fechar_add_arquivos">Fechar </button>
            </form>
            </div>
                           
               
             
            </div>
                   
            
          </div>
        </div>
      </div> 




      <?php 

      if(isset($_POST['add_arquivo'])){
        $arquivo = $_POST['arquivo'];
       

        $query = "UPDATE cursos SET arquivo = '$arquivo' where id = '$id_curso' ";
     

        $result = mysqli_query($conexao, $query);

        if($result == ''){
          echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
        }else{
     
          echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos&func=aulas&id=$id_curso'; </script>";

        } } }

       ?>

       <?php 

        if(isset($_POST['fechar_add_arquivos'])){
         
       
        echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos&func=aulas&id=$id_curso'; </script>";

        }

       ?>


<?php 
  if(@$_GET['func2'] == 'edit'){
    $id = $_GET['id_aula']; 
    $id_curso = $_GET['id_curso']; 

    $query = "select * from aulas where id = '$id' ";
    $result = mysqli_query($conexao, $query);

    while($res = mysqli_fetch_array($result)){
    $nome = $res["nome"];
    $num_aula = $res["num_aula"];
    $link = $res["link"];

    ?>

      <!-- Modal Editar Aula -->
      <div id="modalEditarAulas" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title">Editar Aula</h5>
            
            </div>
            <div class="modal-body">
              <form method="POST" action="">

                <div class="row">

                   <div class="form-group col-md-2">
                    <label for="id_produto">Aula</label>
                    <input type="number" class="form-control text-dark" name="num_aula" required value="<?php echo $num_aula; ?>"/>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">Nome</label>
                    <input type="text" class="form-control text-dark" name="nome" maxlength="35" required value="<?php echo $nome; ?>" />
                  </div>

                  <div class="form-group col-md-7">
                    <label for="id_produto">Link</label>
                    <input type="text" class="form-control text-dark" name="link" maxlength="300" required value="<?php echo $link; ?>" />
                  </div>

                                     


               
                  

                </div>

                <div class="modal-footer">
               <button type="submit" class="btn btn-success mb-3" name="editar_aulas">Editar </button>


                <button type="submit" class="btn btn-info mb-3 " name="fechar_editar_aulas">Fechar </button>
            </form>
            </div>
                           
               
             
            </div>
                   
            
          </div>
        </div>
      </div> 




      <?php 

      if(isset($_POST['editar_aulas'])){
        $nome = $_POST['nome'];
        $num_aula = $_POST['num_aula'];
        $link = $_POST['link'];


        $query = "UPDATE aulas SET nome = '$nome', num_aula = '$num_aula', link = '$link' where id = '$id' ";
     

        $result = mysqli_query($conexao, $query);

        if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
    }else{
     
      echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos&func=aulas&id=$id_curso'; </script>";

    } }

       ?>






<?php 

      if(isset($_POST['fechar_editar_aulas'])){
       
     
      echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos&func=aulas&id=$id_curso'; </script>";

}

       ?>


  <?php } }  ?>




<!--EXCLUIR A AULA -->
<?php 
  if(@$_GET['func2'] == 'excluir'){
    $id = $_GET['id_aula']; 
    $id_curso = $_GET['id_curso']; 


     //RECUPERAR QUANTIDADE DE AULAS DO CURSO
    $query_quant_aula = "select * from cursos where id = '$id_curso'";
    $result_quant_aula = mysqli_query($conexao, $query_quant_aula);

    $res_quant_aula = mysqli_fetch_array($result_quant_aula);
    $quant_aula = $res_quant_aula["aulas"]; 



    $query = "delete from aulas where id = '$id' ";
    $result = mysqli_query($conexao, $query);

      if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
    }else{

       //atualizar a quantidade de aulas no curso tirando uma
            $quant_aula = $quant_aula - 1;

            $query_aulas = "UPDATE cursos set aulas = '$quant_aula' where id = '$id_curso' ";

            mysqli_query($conexao, $query_aulas);

     
      echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos&func=aulas&id=$id_curso'; </script>";

    }

  }

  ?>

<!--ABRIR PERGUNTA -->
<?php 
  if(@$_GET['func'] == 'pergunta'){
    $id = $_GET['id'];
    

    $query_curso = "select * from cursos where id = '$id'";

    $result_curso = mysqli_query($conexao, $query_curso);

    $res_curso = mysqli_fetch_array($result_curso);

    $imagem = $res_curso['imagem'];
    $nome = $res_curso['nome'];
 
                         
    ?>



    <!-- Modal Pergunta -->
      <div id="modalPergunta" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <form method="POST" action="">
              <div class="modal-header">
                
                <h5 class="modal-title"><img class="mr-2" src="../imagens/cursos/<?php echo $imagem; ?>" width="40px"><small>Curso de <?php echo $nome; ?></small></h5>
                <button type="submit" class="close" data-dismiss="modal">&times;</button>
              </div>
            </form>

          
            <div class="modal-body">

               <div class="content">

                <?php  

                     $query_perg = "select * from perguntas where curso = '$id' and respondida = 'Não' order by id desc ";

                    $result_perg = mysqli_query($conexao, $query_perg);

                    while($res_perg = mysqli_fetch_array($result_perg)){
                      $pergunta = $res_perg["pergunta"];
                      $aluno = $res_perg["aluno"];
                      $data = $res_perg["data"];
                      $aula = $res_perg["aula"];
                      $respostas = $res_perg["respostas"];
                      $id_pergunta = $res_perg["id"];

                      $data2 = implode('/', array_reverse(explode('-', $data)));

                      $query_aluno = "select * from alunos where cpf = '$aluno' ";

                      $result_aluno = mysqli_query($conexao, $query_aluno);
                      $res_aluno = mysqli_fetch_array($result_aluno);
                      $img_aluno = $res_aluno['imagem'];
                      $nome = $res_aluno['nome'];
                      ?>
                      <div class="mt-3">
                        <small><span> <img class="rounded-circle z-depth-0" src="../imagens/perfil/<?php echo $img_aluno; ?>" width="25" height="25"> - <?php echo $nome; ?> <span class="ml-4"><?php echo $data2; ?></span> <span class="ml-2"><?php echo $respostas; ?> Respostas</span> </span><br>
                       <span><b> <a class="text-dark" href="painel_professor.php?acao=cursos&func=responder&id=<?php echo $id ?>&id_pergunta=<? echo $id_pergunta?>">Aula <?php echo $aula ?> - <?php echo $pergunta ?></a></span><a href="painel_professor.php?acao=cursos&func=excluir_perg&id=<?php echo $id ?>&id_pergunta=<? echo $id_pergunta?>"><span class="ml-4 text-danger"><i class="far fa-trash-alt"></i></span></a></b></small>
                     </div>

                   <?php } ?>

                   <?php  

                     $query_perg = "select * from perguntas where curso = '$id' and respondida = 'Sim' order by id desc ";

                    $result_perg = mysqli_query($conexao, $query_perg);

                    while($res_perg = mysqli_fetch_array($result_perg)){
                      $pergunta = $res_perg["pergunta"];
                      $aluno = $res_perg["aluno"];
                      $data = $res_perg["data"];
                      $aula = $res_perg["aula"];
                      $respostas = $res_perg["respostas"];
                      $id_pergunta = $res_perg["id"];

                      $data2 = implode('/', array_reverse(explode('-', $data)));

                      $query_aluno = "select * from alunos where cpf = '$aluno' ";

                      $result_aluno = mysqli_query($conexao, $query_aluno);
                      $res_aluno = mysqli_fetch_array($result_aluno);
                      $img_aluno = $res_aluno['imagem'];
                      $nome = $res_aluno['nome'];
                      ?>
                      <div class="mt-3">
                        <small><span> <img class="rounded-circle z-depth-0" src="../imagens/perfil/<?php echo $img_aluno; ?>" width="25" height="25"> - <?php echo $nome; ?> <span class="ml-4"><?php echo $data2; ?></span> <span class="ml-2"><?php echo $respostas; ?> Respostas</span> </span><br>
                       <span> <a class="text-dark" href="painel_professor.php?acao=cursos&func=responder&id=<?php echo $id ?>&id_pergunta=<? echo $id_pergunta?>">Aula <?php echo $aula ?> - <?php echo $pergunta ?></a></span><a href="painel_professor.php?acao=cursos&func=excluir_perg&id=<?php echo $id ?>&id_pergunta=<? echo $id_pergunta?>"><span class="ml-4 text-danger"><i class="far fa-trash-alt"></i></span></a></b></small>
                     </div>

                   <?php } ?>

                   

               </div>

            </div>

            <div class="modal-footer">
               <button type="submit" class="btn btn-secondary mb-3" name="salvar_pergunta">Salvar </button>

            
            </div>
        

               
                   
           
          </div>
        </div>
      </div> 



<!--FECHAMENTO DO IF QUE VERIFICAR SE A JANELA MODAL DAS PERGUNTAS FOI ABERTA -->
<?php } ?>


<!--ABRIR AS PERGUNTAS -->
<?php 
  if(@$_GET['func'] == 'responder'){
    $id_curso = $_GET['id'];
    $id_pergunta = $_GET['id_pergunta'];
    
    $query = "select * from perguntas where id = '$id_pergunta'";

    $result = mysqli_query($conexao, $query);

    $res = mysqli_fetch_array($result);

    $pergunta = $res['pergunta'];
    $respostas = $res['respostas'];
    $aula = $res['aula'];
 
                         
?>



    <!-- Modal Pergunta -->
      <div id="modalPergunta" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg ">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <form method="POST" action="">
              <div class="modal-header">
                
                <h5 class="modal-title"><small><?php echo $pergunta; ?><small>AULA <span class="ml-3"><?php echo $aula; ?> </span><span class="ml-3"><?php echo $respostas; ?> RESPOSTAS</span></small></small></h5>
                <button type="submit" class="close" name="fechar_respostas">&times;</button>
              </div>
            </form>

          
            <div class="modal-body">

               <div class="content">

                  <?php 

                    $query_resp = "select * from respostas where pergunta = '$id_pergunta' order by id asc ";

                    $result_resp = mysqli_query($conexao, $query_resp);
                    $linha_resp = mysqli_num_rows($result_resp);

                    while($res_resp = mysqli_fetch_array($result_resp)){
                      $pergunta = $res_resp["pergunta"];
                      $pessoa = $res_resp["pessoa"];
                      $data = $res_resp["data"];
                      $respostas = $res_resp["resposta"];
                      $funcao = $res_resp["funcao"];
                      $id_resposta = $res_resp["id"];

                      $data2 = implode('/', array_reverse(explode('-', $data)));

                      if($funcao == 'Aluno'){

                        $query_aluno = "select * from alunos where cpf = '$pessoa' ";

                      }else{

                        $query_aluno = "select * from professores where cpf = '$pessoa' ";

                      }

                      $result_aluno = mysqli_query($conexao, $query_aluno);
                      $res_aluno = mysqli_fetch_array($result_aluno);
                      $img_aluno = $res_aluno['imagem'];
                      $nome = $res_aluno['nome'];
                      ?>
                      <div class="mt-3">
                        <small>
                          <span> 
                            <img class="rounded-circle z-depth-0" src="../imagens/perfil/<?php echo $img_aluno; ?>" width="25" height="25"> - <?php echo $nome; ?> 
                            <span class="ml-4"><?php echo $data2; ?></span>
                          </span>
                          <span class="ml-2"><?php echo $respostas; ?></span>
                          <a href="painel_professor.php?acao=cursos&func=excluir_resp&id=<?php echo $id_curso ?>&id_resposta=<? echo $id_resposta?>&id_pergunta_2=<? echo $pergunta?>"><span class="ml-4 text-danger"><i class="far fa-trash-alt"></i></span></a>
                        </small>
                       
                     </div>

                   <? } ?>

               </div>

            </div>

            <div class="modal-footer">
                <div class="container">
                  <form method="POST" action="">
                    <div class="form-group">
                        <label for="id_produto">Resposta</label>
                        <textarea type="text" class="form-control mr-2 text-dark" name="resposta" maxlength="1000" required> </textarea>
                    </div>
                    <div align="right">
                      <button type="submit" class="btn btn-secondary mb-3" name="salvar_resposta">Salvar </button>
                    </div>
                  </form>
                </div>
            </div> 

          </div>
        </div>
      </div> 

<!--FECHAMENTO DO IF QUE VERIFICAR SE A JANELA MODAL DAS PERGUNTAS FOI ABERTA -->
<? } ?>


<?php 
  if(isset($_POST['fechar_respostas'])){
    echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos&func=pergunta&id=$id_curso'; </script>";
  }
?>

<!-- SALVAR A RESPOSTA -->
<?php 

  if(isset($_POST['salvar_resposta'])){
    
    $resposta = $_POST['resposta'];

    $query = "INSERT INTO respostas (resposta, curso, pessoa, data, pergunta, funcao) values ('$resposta', '$id_curso', '$_SESSION[cpf]', curDate(), '$id_pergunta', 'Professor')";

    $result = mysqli_query($conexao, $query);

    //RECUPERAR A QTD DE RESPOSTAS DA PERGUNTA
    $query_quant = "select * from perguntas where id = '$id_pergunta' order by id asc ";
    $result_quant = mysqli_query($conexao, $query_quant);
    $res_quant = mysqli_fetch_array($result_quant);
    $quant_resp = $res_quant['respostas'];

    //INCREMENTAR MAIS UM NAS RESPOSTAS DAS PERGUNTAS
    $quantidade = $quant_resp + 1;
    $query_upd = "update perguntas set respostas = '$quantidade' where id = '$id_pergunta'";
    mysqli_query($conexao, $query_upd);

    //ATUALIZAR A PERGUNTA PARA LIDA
    $query_upd_lida = "update perguntas set respondida = 'Sim' where id = '$id_pergunta'";
    mysqli_query($conexao, $query_upd_lida);

    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
    }else{
     
     echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos&func=pergunta&id=$id_curso'; </script>";

    }

}  ?>

<!--EXCLUIR AS PERGUNTAS -->
<?php 
  if(@$_GET['func'] == 'excluir_perg'){
    $id_curso = $_GET['id'];
    $id_pergunta = $_GET['id_pergunta'];
    
    $query = "DELETE from perguntas where id = '$id_pergunta'";

    $result = mysqli_query($conexao, $query);

    //EXCLUIR AS RESPOSTAS
    $query_RESPOSTAS = "DELETE from respostas where pergunta = '$id_pergunta'";
    mysqli_query($conexao, $query_RESPOSTAS);

    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Excluir!'); </script>";
    }else{
     
     echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos&func=pergunta&id=$id_curso'; </script>";

    }
 
 }
                         
?>

<!--EXCLUIR AS RESPOSTAS -->
<?php 
  if(@$_GET['func'] == 'excluir_resp'){
    $id_curso = $_GET['id'];
    $id_resposta = $_GET['id_resposta'];
    $id_pergunta_2 = $_GET['id_pergunta_2'];
    
    $query = "DELETE from respostas where id = '$id_resposta'";

    $result = mysqli_query($conexao, $query);


    //recuperar quantidade de respostas das perguntas
    $query_quant = "select * from perguntas where id = '$id_pergunta_2'";
    $result_quant = mysqli_query($conexao, $query_quant);
    $res_quant = mysqli_fetch_array($result_quant);
    $resp = $res_quant['respostas'] - 1;

    //decrementar um valor nas respostas das perguntas
    $query_upd = "update perguntas set respostas = '$resp' where id = '$id_pergunta_2'";
    mysqli_query($conexao, $query_upd);

    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Excluir!'); </script>";
    }else{
     
     echo "<script language='javascript'>window.location='painel_professor.php?acao=cursos&func=pergunta&id=$id_curso&id_pergunta=$id_pergunta_2'; </script>";

    }
 
 }
                         
?>



 <script> $("#modalEditar").modal("show"); </script> 
 <script> $("#modalMensagem").modal("show"); </script> 
 <script> $("#modalAulas").modal("show"); </script> 
 <script> $("#modalEditarAulas").modal("show"); </script> 
 <script> $("#modalArquivos").modal("show"); </script> 
 <script> $("#modalPergunta").modal("show"); </script>
 <script> $("#modalResposta").modal("show"); </script> 

 <!--MASCARAS -->

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
      $('#telefone').mask('(00) 00000-0000');
      $('#cpf').mask('000.000.000-00');
      });
</script>