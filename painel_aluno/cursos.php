 <?php
    include_once('../conexao.php');
    include_once('../pagseguro/PagSeguro.class.php');
    $PagSeguro = new PagSeguro();

    ?>


    <div class="container ml-4">
      <div class="row">

        <div class="col-lg-8 col-md-6 col-sm-12">
         

      </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
          <form class="form-inline my-2 my-lg-0">
            <input name="txtpesquisarCursos" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Cursos" aria-label="Pesquisar">
            <button name="buttonPesquisar" class="btn btn-outline-secondary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
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

                        $cpf_aluno = $_SESSION['cpf'];

                        //recuperar as matriculas do aluno e ver se tem aprovação de pagamento pendente
                        $query_mat_al = "SELECT * from matriculas where aluno = '$cpf_aluno' ";

                        $result_mat_al = mysqli_query($conexao, $query_mat_al);

                        while($res_mat_al = mysqli_fetch_array($result_mat_al)){

                        $id_matricula = $res_mat_al['id'];

                        $P = $PagSeguro->getStatusByReference($id_matricula);

                            if($P == 3 || $P == 4){
                               
                              $query_teste = "update matriculas set status = 'Matriculado' where id = '$id_matricula'";
                              mysqli_query($conexao, $query_teste);

                            }


                        }


                        if(isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarCursos'] != ''){



                          $nome = '%' .$_GET['txtpesquisarCursos'] . '%';
                          
                          $query = "SELECT m.id, m.id_curso, m.aluno, m.professor, m.aulas_concluidas, m.valor, m.data, m.status, c.nome as nome_curso from matriculas as m INNER JOIN cursos as c ON m.id_curso = c.id where m.aluno = '$cpf_aluno' and c.nome LIKE '$nome' order by id desc ";

                          $result_count = mysqli_query($conexao, $query);

                        }else{
                          $query = "SELECT * from matriculas where aluno = '$cpf_aluno' order by id desc";

                          $query_count = "SELECT * from matriculas where aluno = '$cpf_aluno'";
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
                            Curso
                          </th>
                          
                         
                          <th>
                            Professor
                          </th>
                         
                          <th>
                            Aulas Concluídas
                          </th>
                           <th>
                            Valor
                          </th>
                           <th>
                            Data
                          </th>
                          
                           <th>
                            Status
                          </th>
                         
                           
                        </thead>
                        <tbody>
                        
                        <?php
                          while($res = mysqli_fetch_array($result)){
                            $curso = $res["id_curso"];
                            $aluno = $res["aluno"];
                            $professor = $res["professor"];
                            $aulas_concluidas = $res["aulas_concluidas"];
                            $valor = $res["valor"];
                            $data = $res["data"];
                            $status = $res["status"];
                            $id_matricula = $res["id"];

                            $data2 = implode('/', array_reverse(explode('-', $data)));

                            //verificar se o pagamento no pagseguro esta aprovado
                            
                            $P = $PagSeguro->getStatusByReference($id_matricula);

                            if($P == 3 || $P == 4){
                               
                              $query_teste = "update matriculas set status = 'Matriculado' where id = '$id_matricula'";
                              mysqli_query($conexao, $query_teste);

                            }else{
                              
                              $query_matric = "update matriculas set status = 'Aguardando' where id = '$id_matricula'";
                              mysqli_query($conexao, $query_matric);
                            }


                            //EXTRAIR O NOME DO CURSO
                            $query_curso = "SELECT * from cursos where id = '$curso' ";

                            $result_curso = mysqli_query($conexao, $query_curso);
                            $res_curso = mysqli_fetch_array($result_curso);
                            $nome_curso = $res_curso['nome'];
                            $aulas_curso = $res_curso['aulas'];


                            //EXTRAIR O NOME DO PROFESSOR
                            $query_prof = "SELECT * from professores where cpf = '$professor' ";

                            $result_prof = mysqli_query($conexao, $query_prof);
                            $res_prof = mysqli_fetch_array($result_prof);
                            $nome_prof = $res_prof['nome'];

                          
                        ?>

                            <tr>

                             <td>

                               <?php if($status == 'Aguardando'){  ?>

                               

                              <?php echo $nome_curso; ?> 

                               <?php }else{  ?>

                                 <a class="text-success" title="Entra no Curso" href="painel_aluno.php?acao=cursos&func=aulas&id=<?php echo $curso; ?>&aulas_concluidas=<?php echo $aulas_concluidas; ?>">

                              <?php echo $nome_curso; ?> <i class="fas fa-arrow-right text-success ml-1"></i> </a>

                                <?php } ?>
                                                            
                             </td>


                           
                            
                             <td><?php echo $nome_prof; ?></td>
                             
                             <td><?php echo $aulas_concluidas; ?> / <?php echo $aulas_curso; ?>
                               
                               <?php if($aulas_concluidas == $aulas_curso){ ?>
                                 <?php 
                                 $query_ava = "SELECT * from avaliacoes where aluno = '$cpf_aluno' and curso = '$curso' ";

                                $result_ava = mysqli_query($conexao, $query_ava);
                                $linha_ava = mysqli_num_rows($result_ava);
                                if($linha_ava == 0){ ?>

                                  <a href="painel_aluno.php?acao=cursos&func=avaliar&id=<?php echo $curso; ?>"> <i class="estrela fas fa-star ml-4"></i></a>

                                <?php }

                                ?>
                                

                                
                                <?php } ?>
                             </td>
                             
                             <td><?php echo $valor; ?></td>

                             <td><?php echo $data2; ?></td>

                             <td>

                              <?php if($status == 'Aguardando'){  ?>
                              <i class="fas fa-square text-danger"></i>
                              <?php } ?>

                           
                              <?php if($status == 'Matriculado'){  ?>
                              <i class="fas fa-square text-success"></i>
                              <?php } ?>


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




<!--ABRIR AULAS -->
<?php 
  if(@$_GET['func'] == 'aulas'){

     $id = $_GET['id'];


     //VERIFICAR SE O ALUNO ESTÁ MATRICULADO NO CURSO E SUA MATRICULA ESTÁ APROVADA
     $query_verificar_status = "SELECT * from matriculas where id_curso = '$id' and aluno = '$cpf_aluno' and status = 'Matriculado' ";
     $result_verificar_status = mysqli_query($conexao, $query_verificar_status);
               
      $row_verificar_status = mysqli_num_rows($result_verificar_status);

      if($row_verificar_status > 0){   



       
          
        $aulas_concluidas = $_GET['aulas_concluidas'];

        $query = "select * from cursos where id = '$id' ";
        $result = mysqli_query($conexao, $query);

        $res = mysqli_fetch_array($result);
        $nome = $res["nome"];
        $arquivo = $res["arquivo"];
        $imagem = $res["imagem"];
                         
    ?>



    <!-- Modal Aulas -->
      <div id="modalAulas" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title"><img class="mr-2" src="../imagens/cursos/<?php echo $imagem; ?>" width="40px"><small>Curso de <?php echo $nome; ?></small></h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="content">
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-5">
                    <a class="text-dark mb-3" href="<?php echo $arquivo; ?>" target="_blank"><i class="far fa-file-code mr-2"></i> Arquivos </a><br><br>

                     <small>

            <?php  

             $query_aulas = "select * from aulas where curso = '$id' ";

            $result_aulas = mysqli_query($conexao, $query_aulas);

            while($res_aulas = mysqli_fetch_array($result_aulas)){
              $num_aula = $res_aulas["num_aula"];
              $nome_aula = $res_aulas["nome"];
              $link = $res_aulas["link"];
              ?>

              <?php if($num_aula <= $aulas_concluidas){ ?>

                <i class="fas fa-video mr-1"></i> <span class="link-ativo"> <a href="painel_aluno.php?acao=cursos&func=aula&id=<?php echo $id; ?>&num_aula=<?php echo $num_aula; ?>&aulas_concluidas=<?php echo $aulas_concluidas; ?>">Aula <?php echo $num_aula; ?> - <?php echo $nome_aula; ?></a></span><br>

             <?php }else{ ?>

               <i class="fas fa-video mr-1"></i> Aula <?php echo $num_aula; ?> - <?php echo $nome_aula; ?><br>

            <?php } ?>
           
        

         <?php } ?>
         
        </small>


                  </div>
                    <div class="col-sm-12 col-md-12 col-lg-7">
                     <a class="text-dark" href="painel_aluno.php?acao=cursos&func=pergunta&id=<?php echo $id; ?>"><i class="far fa-question-circle"></i> <span class="text-muted">Nova Pergunta</span></a> <br><br>


                      <?php  

                     $query_perg = "select * from perguntas where curso = '$id' and aluno = '$cpf' ";

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
                       <span> <a class="text-dark" href="painel_aluno.php?acao=cursos&func=responder&id=<?php echo $id; ?>&id_pergunta=<?php echo $id_pergunta; ?>&aulas_concluidas=<?php echo $aulas_concluidas; ?>">Aula <?php echo $aula ?> - <?php echo $pergunta ?></a> </span></small>
                     </div>

                   <?php } ?>



                   <?php  

                     $query_perg = "select * from perguntas where curso = '$id' and aluno != '$cpf'  order by id desc ";

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
                      $img_aluno = $res_aluno['foto'];
                      $nome = $res_aluno['nome'];
                      ?>
                      <div class="mt-3">
                        <small><span> <img class="rounded-circle z-depth-0" src="../imagens/perfil/<?php echo $img_aluno; ?>" width="25" height="25"> - <?php echo $nome; ?> <span class="ml-4"><?php echo $data2; ?></span> <span class="ml-2"><?php echo $respostas; ?> Respostas</span> </span><br>
                       <span> <a class="text-dark" href="painel_aluno.php?acao=cursos&func=responder&id=<?php echo $id; ?>&id_pergunta=<?php echo $id_pergunta; ?>&aulas_concluidas=<?php echo $aulas_concluidas; ?>">Aula <?php echo $aula ?> - <?php echo $pergunta ?></a> </span></small>
                     </div>

                   <?php } ?>

                    
                  </div>
                </div>
              </div>

            </div>

               
                   
           
          </div>
        </div>
      </div> 



<!--FECHAMENTO DO IF QUE VERIFICAR SE A JANELA MODAL DAS AUAS FOI ABERTA -->
<?php } else{ ?>

<h5>Você não está matriulado neste curso!!</h5>

<?php } }?>




     <!--ABRIR AULA -->
<?php 
  if(@$_GET['func'] == 'aula'){
    $id_curso = $_GET['id'];


    //VERIFICAR SE O ALUNO ESTÁ MATRICULADO NO CURSO E SUA MATRICULA ESTÁ APROVADA
     $query_verificar_status = "SELECT * from matriculas where id_curso = '$id_curso' and aluno = '$cpf_aluno' and status = 'Matriculado' ";
     $result_verificar_status = mysqli_query($conexao, $query_verificar_status);
               
      $row_verificar_status = mysqli_num_rows($result_verificar_status);

      if($row_verificar_status > 0){  




    $num_aula = $_GET['num_aula'];


    //RECUPERAR A QUANTIDADE DE AULAS EXISTENTES NO CURSO
     $query_cur = "select * from cursos where id = '$id_curso' ";

     $result_cur = mysqli_query($conexao, $query_cur);

     $res_cur = mysqli_fetch_array($result_cur);
     $total_aulas = $res_cur['aulas'];


    if($num_aula < $total_aulas){

      if($num_aula == @$aulas_concluidas_2){
      $nova_aula = $num_aula + 1;

      $query_upd = "update matriculas set aulas_concluidas = '$nova_aula' where id_curso = '$id_curso' and aluno = '$cpf_aluno' ";
      $result_upd = mysqli_query($conexao, $query_upd);

    }

    }

    

   



  $query = "select * from aulas where num_aula = '$num_aula' and curso = '$id_curso' ";
  $result = mysqli_query($conexao, $query);

  $res = mysqli_fetch_array($result);
  $nome = $res["nome"];
  $link = $res["link"];

  

  ?>
  
<!-- Modal Aula -->
      <div id="modalAula" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <form method="POST" action="">
              <div class="modal-header">
              
                <h5 class="modal-title"><small>Aula <?php echo $num_aula; ?> - <?php echo $nome; ?></small></h5>
                <button type="submit" class="close" name="fecharModal">&times;</button>
              </form>
            </div>
            
            <div class="modal-body">
             

              <iframe width="760" height="500" src="<?php echo $link; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
               
             
            </div>
                   
            
          </div>
        </div>
      </div>    

<?php }  } ?>


<?php 

      if(isset($_POST['fecharModal'])){
       
      $id = $_GET['id'];
      $aulas_concluidas = $_GET['aulas_concluidas'];
      $num_aula = $_GET['num_aula'];

       //RECUPERAR A QUANTIDADE DE AULAS EXISTENTES NO CURSO
     $query_cur = "select * from cursos where id = '$id' ";

     $result_cur = mysqli_query($conexao, $query_cur);

     $res_cur = mysqli_fetch_array($result_cur);
     $total_aulas = $res_cur['aulas'];


    if($num_aula < $total_aulas){


      if($aulas_concluidas == $num_aula){
        $aulas_concluidas = $aulas_concluidas + 1;

        $query_upd = "update matriculas set aulas_concluidas = '$aulas_concluidas' where id_curso = '$id' and aluno = '$cpf_aluno' ";
        $result_upd = mysqli_query($conexao, $query_upd);
      }
    }

      

      echo "<script language='javascript'>window.location='painel_aluno.php?acao=cursos&func=aulas&id=$id&aulas_concluidas=$aulas_concluidas'; </script>";

}

       ?>







 

<!--ABRIR PERGUNTA -->
<?php 
  if(@$_GET['func'] == 'pergunta'){
    $id = $_GET['id'];
    
    
    $query = "select * from cursos where id = '$id' ";
    $result = mysqli_query($conexao, $query);

    $res = mysqli_fetch_array($result);
    $nome = $res["nome"];
    $arquivo = $res["arquivo"];
    $imagem = $res["imagem"];
                         
    ?>



    <!-- Modal Pergunta -->
      <div id="modalPergunta" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <form method="POST" action="">
              <div class="modal-header">
                
                <h5 class="modal-title"><img class="mr-2" src="../imagens/cursos/<?php echo $imagem; ?>" width="40px"><small>Curso de <?php echo $nome; ?></small></h5>
                <button type="submit" class="close" name="fecharModal">&times;</button>
              </div>
            </form>

          <form method="POST" action="">
            <div class="modal-body">

                <div class="form-group">
                    <label for="fornecedor">Aula</label>
                     <input type="number" class="form-control mr-2 text-dark " name="aula" placeholder="Aula">
                  </div>


                   <div class="form-group">
                    <label for="id_produto">Pergunta</label>
                    <textarea type="text" class="form-control mr-2 text-dark" name="pergunta" maxlength="1000" required> </textarea>
                  </div>

            </div>

            <div class="modal-footer">
               <button type="submit" class="btn btn-secondary mb-3" name="salvar_pergunta">Salvar </button>

            
            </div>
          </form>

               
                   
           
          </div>
        </div>
      </div> 



<!--FECHAMENTO DO IF QUE VERIFICAR SE A JANELA MODAL DAS PERGUNTAS FOI ABERTA -->
<?php } ?>



<!-- SALVAR A PERGUNTA -->
<?php 
  if(isset($_POST['salvar_pergunta'])){
    $aula = $_POST['aula'];
    $pergunta = $_POST['pergunta'];

    $query = "INSERT INTO perguntas (aula, pergunta, curso, respostas, aluno, data, respondida) values ('$aula', '$pergunta', '$id', '0', '$cpf_aluno', curDate(), 'Não')";

    $result = mysqli_query($conexao, $query);


    



    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
    }else{
     
     echo "<script language='javascript'>window.location='painel_aluno.php?acao=cursos&func=aulas&id=$id&aulas_concluidas=$aulas_concluidas'; </script>";

    }



}  ?>






<!--ABRIR A PERGUNTA CLICADA-->
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



    <!-- Modal Pergunta Clicada -->
      <div id="modalPergunta" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <form method="POST" action="">
              <div class="modal-header">
                
                <h5 class="modal-title"><small><?php echo $pergunta; ?> <small><span class="ml-3">Aula <?php echo $aula; ?></span> - <span class="ml-3"><?php echo $respostas; ?> Respostas</span></small></small></h5>
                <button type="submit" class="close" name="fechar_respostas">&times;</button>
              </div>
            </form>
            

         
            <div class="modal-body">

               <div class="container">

                <?php  

                     $query_resp = "select * from respostas where pergunta = '$id_pergunta' order by id asc ";

                    $result_resp = mysqli_query($conexao, $query_resp);

                    $linha_resp = mysqli_num_rows($result_resp);

                    while($res_resp = mysqli_fetch_array($result_resp)){
                      $pergunta = $res_resp["pergunta"];
                      $pessoa = $res_resp["pessoa"];
                      $data = $res_resp["data"];
                      $funcao = $res_resp["funcao"];
                      $resposta = $res_resp["resposta"];

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
                        <small><span> <img class="rounded-circle z-depth-0" src="../imagens/perfil/<?php echo $img_aluno; ?>" width="25" height="25"> - <?php echo $nome; ?> <span class="ml-4"><?php echo $data2; ?></span>  </span><br>
                       <span> <?php echo $resposta ?> </span></small>
                     </div>

                   <?php } ?>



                   

               </div>

            </div>

            <div class="modal-footer">
              
                <div class="container">
                  <form method="POST" action="">
                  <small>
                   <div class="form-group">
                        <label for="id_produto">Resposta</label>
                        <textarea type="text" class="form-control mr-2" name="resposta" maxlength="1000" required> </textarea>
                    </div>
                    <div align="right">
                      <button type="submit" class="btn btn-secondary mb-3" name="salvar_resposta">Salvar </button>
                    </div>
                  </small>
                  </form>
                </div>
              

            
            </div>
         

               
                   
           
          </div>
        </div>
      </div> 



<!--FECHAMENTO DO IF QUE VERIFICAR SE A JANELA MODAL DAS PERGUNTAS CLICADAS FOI ABERTA -->
<?php } ?>



<?php 

      if(isset($_POST['fechar_respostas'])){

      $aulas_concluidas = $_GET['aulas_concluidas'];  
       
     
      echo "<script language='javascript'>window.location='painel_aluno.php?acao=cursos&func=aulas&id=$id_curso&aulas_concluidas=$aulas_concluidas'; </script>";

}

?>




<!-- SALVAR A RESPOSTA -->
<?php 
  if(isset($_POST['salvar_resposta'])){

    $id_curso_get = $_GET['id'];
    $pergunta_curso_get = $_GET['id_pergunta'];
    $aulas_concluidas = $_GET['aulas_concluidas'];  
    
    $resposta = $_POST['resposta'];

    $query = "INSERT INTO respostas (resposta, curso, pessoa, data, pergunta, funcao) values ('$resposta', '$id_curso', '$cpf',  curDate(), '$id_pergunta', 'Aluno')";

    $result = mysqli_query($conexao, $query);


    //RECUPERAR A QUANTIDADE DE RESPOSTAS DA PERGUNTA
     $query_quant = "select * from perguntas where id = '$id_pergunta'";

     $result_quant = mysqli_query($conexao, $query_quant);
     $res_quant = mysqli_fetch_array($result_quant);
     $quant_resp = $res_quant['respostas'];

    //INCREMENTAR MAIS UM NAS RESPOSTAS DA PERGUNTA
     $quantidade = $quant_resp + 1;
      $query_upd = "update perguntas set respostas = '$quantidade' where id = '$id_pergunta' ";

      mysqli_query($conexao, $query_upd);

    //ATUALIZAR A PERGUNTA PARA LIDA
      $query_upd_lida = "update perguntas set respondida = 'Não' where id = '$id_pergunta' ";

      mysqli_query($conexao, $query_upd_lida);


    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
    }else{
     
    echo "<script language='javascript'>window.location='painel_aluno.php?acao=cursos&func=aulas&id=$id_curso&aulas_concluidas=$aulas_concluidas'; </script>";

    }



}  ?>







<!--ABRIR MODAL AVALIACAO -->
<?php 
  if(@$_GET['func'] == 'avaliar'){
    $id = $_GET['id'];



    //VERIFICAR SE O ALUNO ESTÁ MATRICULADO NO CURSO E SUA MATRICULA ESTÁ APROVADA
     $query_verificar_status = "SELECT * from matriculas where id_curso = '$id' and aluno = '$cpf_aluno' and status = 'Matriculado' ";
     $result_verificar_status = mysqli_query($conexao, $query_verificar_status);
               
      $row_verificar_status = mysqli_num_rows($result_verificar_status);

      if($row_verificar_status > 0){  
    
    
    $query = "select * from cursos where id = '$id' ";
    $result = mysqli_query($conexao, $query);

    $res = mysqli_fetch_array($result);
    $nome = $res["nome"];
    
    $imagem = $res["imagem"];
                         
    ?>



    <!-- Modal AVALIACAO -->
      <div id="modalPergunta" class="modal fade" role="dialog">
        <div class="modal-dialog">
         <!-- Modal content-->
          <div class="modal-content">
           
              <div class="modal-header">
                
                <h5 class="modal-title"><img class="mr-2" src="../img/cursos/<?php echo $imagem; ?>" width="40px"><small>Curso de <?php echo $nome; ?></small></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
            

          <form method="POST" action="">
            <div class="modal-body">

                <div class="form-group col-md-4">
                    <label for="fornecedor">Nota</label>
                     <select class="form-control mr-2" id="category" name="cbnota">
                     <option value="1">1</option> 
                     <option value="2">2</option> 
                     <option value="3">3</option> 
                     <option value="4">4</option> 
                     <option value="5" selected="">5</option> 
                     
                    </select>
                  </div>


                   <div class="form-group col-md-12">
                    <label for="id_produto">Comentário</label>
                    <textarea type="text" class="form-control mr-2" name="comentario" maxlength="1000" required> </textarea>
                  </div>

            </div>

            <div class="modal-footer">
               <button type="submit" class="btn btn-secondary mb-3" name="salvar_avaliacao">Salvar </button>

            
            </div>
          </form>

               
                   
           
          </div>
        </div>
      </div> 



<!--FECHAMENTO DO IF QUE ABRE A MODAL DA AVALIAÇÃO DO CURSO -->
<?php } } ?>

      


<!-- SALVAR A AVALIACAO -->
<?php 
  if(isset($_POST['salvar_avaliacao'])){
    $nota = $_POST['cbnota'];
    $comentario = $_POST['comentario'];


    //verificar se o aluno já concluiu o curso
     $query_mat = "SELECT * from matriculas where aluno = '$cpf_aluno' and id_curso = '$id' ";

     $result_mat = mysqli_query($conexao, $query_mat);
     $res_mat = mysqli_fetch_array($result_mat);
     $aulas_conc = $res_mat['aulas_concluidas'];


     //verificar quantas aulas tem o curso
     $query_curso = "SELECT * from cursos where id = '$id' ";

     $result_curso = mysqli_query($conexao, $query_curso);
     $res = mysqli_fetch_array($result_curso);
     $quant_aulas = $res['aulas'];


    //VERIFICAR SE A AVALIAÇÃO JÁ FOI FEITA

     if($aulas_conc == $quant_aulas){

          $query_ava = "SELECT * from avaliacoes where aluno = '$cpf_aluno' and curso = '$id' ";

         $result_ava = mysqli_query($conexao, $query_ava);
         $linha_ava = mysqli_num_rows($result_ava);
         if($linha_ava == 0){ 

          $query = "INSERT INTO avaliacoes (nota, comentario, curso, aluno, data) values ('$nota', '$comentario', '$id', '$cpf_aluno', curDate())";

          $result = mysqli_query($conexao, $query);
        }else{
           echo "<script language='javascript'>window.alert('Você já avaliou esse curso!'); </script>";
           exit();
        }
    }else{
       echo "<script language='javascript'>window.alert('Você não finalizou esse curso!'); </script>";
           exit();
    }

    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
    }else{

      echo "<script language='javascript'>window.alert('Avaliação feita com Sucesso!'); </script>";
     
     echo "<script language='javascript'>window.location='painel_aluno.php?acao=cursos'; </script>";

    }

}  ?>

<script> $("#modalAulas").modal("show"); </script> 
<script> $("#modalAula").modal("show"); </script> 
<script> $("#modalPergunta").modal("show"); </script> 