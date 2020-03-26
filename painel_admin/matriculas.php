
    <?php
    include_once('../conexao.php');

    ?>


    <div class="container ml-4">
    	<div class="row">

    		<div class="col-lg-6 col-md-6 col-sm-12">
			   

			</div>

    		<div class="col-lg-6 col-md-6 col-sm-12">
			    <form class="form-inline my-2 my-lg-0">

              <select class="form-control mr-2" id="category" name="cbpesquisarMatriculas">
             <option value="Todos">Todas</option> 
             <option value="Aguardando">Aguardando</option> 
             <option value="Matriculado">Matriculado</option> 
             
            </select>


			      <input name="txtpesquisarMatriculas" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Cursos" aria-label="Pesquisar">
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

                      
                        $status = @$_GET['cbpesquisarMatriculas'];
                        if(isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarMatriculas'] != ''){



                          $nome = '%' .$_GET['txtpesquisarMatriculas'] . '%';

                           

                           if($status == 'Todos'){

                            $query = "SELECT m.id, m.id_curso, m.aluno, m.professor, m.aulas_concluidas, m.valor, m.data, m.status, c.nome as nome_curso from matriculas as m INNER JOIN cursos as c ON m.id_curso = c.id where c.nome LIKE '$nome' order by id desc ";

                           }else{

                            $query = "SELECT m.id, m.id_curso, m.aluno, m.professor, m.aulas_concluidas, m.valor, m.data, m.status, c.nome as nome_curso from matriculas as m INNER JOIN cursos as c ON m.id_curso = c.id where c.nome LIKE '$nome' and m.status = '$status' order by id desc ";

                           }
                          
                          

                          $result_count = mysqli_query($conexao, $query);

                        }else{
                          if($status == 'Todos' || $status == ''){
                            $query = "SELECT * from matriculas order by id desc limit 10";

                          }else{
                            $query = "SELECT * from matriculas where status = '$status' order by id desc limit 10";
                          }
                          
                          if($status == 'Todos' || $status == ''){
                            $query_count = "SELECT * from matriculas ";
                          }else{
                            $query_count = "SELECT * from matriculas where status = '$status'";
                          }
                          
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
                            Aluno
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
                            $id = $res["id"];


                            $data2 = implode('/', array_reverse(explode('-', $data)));

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


                            //EXTRAIR O NOME DO ALUNO
                            $query_aluno = "SELECT * from alunos where cpf = '$aluno' ";

                            $result_aluno = mysqli_query($conexao, $query_aluno);
                            $res_aluno = mysqli_fetch_array($result_aluno);
                            $nome_aluno = $res_aluno['nome'];
                           

                          
                        ?>

                            <tr>

                             <td>

                             

                              <?php echo $nome_curso; ?> 

                             
                                                            
                             </td>


                            <td><?php echo $nome_aluno; ?></td>
                            
                             <td><?php echo $nome_prof; ?></td>
                             
                            <td><?php echo $aulas_concluidas; ?> / <?php echo $aulas_curso; ?></td>
                             
                             <td><?php echo $valor; ?></td>

                             <td><?php echo $data2; ?></td>

                             <td>

                              <?php if($status == 'Aguardando'){  ?>
                              <a href="painel_admin.php?acao=matriculas&func=aprovar&id=<?php echo $id; ?>" title="Aprovar Matricula"><i class="fas fa-square text-danger mr-2"></i></a>
                            
                              <?php } ?>

                           
                              <?php if($status == 'Matriculado'){  ?>
                               <a href="painel_admin.php?acao=matriculas&func=cancelar&id=<?php echo $id; ?>" title="Cancelar Matricula">
                              <i class="fas fa-square text-success"></i></a>
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





<!--APROVAR A MATRICULA -->
<?php 
  if(@$_GET['func'] == 'aprovar'){
    $id = $_GET['id'];


    //trazer os dados da matricula para salvar nas vendas
       $query_mat = "SELECT * from matriculas where id = '$id' ";

                            $result_mat = mysqli_query($conexao, $query_mat);
                            $res_mat = mysqli_fetch_array($result_mat);
                            $aluno_mat = $res_mat['aluno'];
                            $curso_mat = $res_mat['id_curso'];
                            $valor_mat = $res_mat['valor'];
                           



  $query = "UPDATE matriculas set status = 'Matriculado' where id = '$id' ";
  mysqli_query($conexao, $query);


  //LANÇAR O VALOR DA MATRICULA NA TABELA DE VENDAS
   $query_vendas = "INSERT INTO vendas (curso, valor, aluno, data,  id_matricula) values ('$curso_mat', '$valor_mat', '$aluno_mat', curDate(), '$id')";
  mysqli_query($conexao, $query_vendas);


  echo "<script language='javascript'>window.location='painel_admin.php?acao=matriculas'; </script>";

}

?>


<!--CANCELAR A MATRICULA -->
<?php 
  if(@$_GET['func'] == 'cancelar'){
    $id = $_GET['id'];


  $query = "UPDATE matriculas set status = 'Aguardando' where id = '$id' ";
  mysqli_query($conexao, $query);


   $query_mat = "delete from vendas where id_matricula = '$id' ";
  mysqli_query($conexao, $query_mat);


  echo "<script language='javascript'>window.location='painel_admin.php?acao=matriculas'; </script>";

}

?>