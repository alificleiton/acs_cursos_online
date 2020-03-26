
    <?php
    include_once('../conexao.php');

    ?>


    <div class="container ml-4">
    	<div class="row">

    		<div class="col-lg-6 col-md-6 col-sm-12">
			   

			</div>

    		<div class="col-lg-6 col-md-6 col-sm-12">
			    <form class="form-inline my-2 my-lg-0">

           <input name="dataInicial" class="form-control mr-sm-2" type="date" placeholder="Pesquisar" aria-label="Pesquisar">
            <input name="dataFinal" class="form-control mr-sm-2" type="date" placeholder="Pesquisar" aria-label="Pesquisar">
			      
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

                      <!--LISTAR TODOS AS VENDAS -->
                      <?php

                      
                        $dataInicial = @$_GET['dataInicial'];
                        $dataFinal = @$_GET['dataFinal'];

                        if($dataInicial == ''){
                          $dataInicial = Date('Y-m-d');
                        }

                        if($dataFinal == ''){
                          $dataFinal = Date('Y-m-d');
                        }

                        if(isset($_GET['buttonPesquisar'])){

                          $query = "select * from vendas where data >= '$dataInicial' and data <= '$dataFinal' ";

                          //totalizar as vendas
                           $query_tot = "select SUM(valor) as total from vendas where data >= '$dataInicial' and data <= '$dataFinal' ";
                          

                        }else{

                        

                          $query = "select * from vendas where data = curDate() ";

                            //totalizar as vendas
                           $query_tot = "select SUM(valor) as total from vendas where data = curDate() ";
                          
                        }

                        $result = mysqli_query($conexao, $query);
                        $result_tot = mysqli_query($conexao, $query_tot);
                        
                        $linha = mysqli_num_rows($result);
                       

                        if($linha == ''){
                          echo "<h3> Não foram encontrados dados Cadastrados no Banco!! </h3>";
                        }else{

                          ?>


                                               

                      <table class="table">
                        <thead class="text-secondary">
                          
                          <th>
                            Valor
                          </th>
                          
                         <th>
                            Curso
                          </th>
                          <th>
                            Aluno
                          </th>
                         
                          <th>
                            Data
                          </th>
                           
                          
                           
                        </thead>
                        <tbody>
                        
                        <?php
                          while($res = mysqli_fetch_array($result)){
                            $curso = $res["curso"];
                            $aluno = $res["aluno"];
                            
                            $valor = $res["valor"];
                            $data = $res["data"];
                            $id_matricula = $res["id_matricula"];
                            $id = $res["id"];


                            $data2 = implode('/', array_reverse(explode('-', $data)));

                            //EXTRAIR O NOME DO CURSO
                            $query_curso = "SELECT * from cursos where id = '$curso' ";

                            $result_curso = mysqli_query($conexao, $query_curso);
                            $res_curso = mysqli_fetch_array($result_curso);
                            $nome_curso = $res_curso['nome'];
                            


                           

                            //EXTRAIR O NOME DO ALUNO
                            $query_aluno = "SELECT * from alunos where cpf = '$aluno' ";

                            $result_aluno = mysqli_query($conexao, $query_aluno);
                            $res_aluno = mysqli_fetch_array($result_aluno);
                            $nome_aluno = $res_aluno['nome'];
                           

                          
                        ?>

                            <tr>

                               <td><?php echo $valor; ?></td>

                             <td><?php echo $nome_curso; ?> </td>


                            <td><?php echo $nome_aluno; ?></td>
                              <td><?php echo $data2; ?></td>

                                                         
                             
                                                        
                            
                           
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
                            <?php 
                              $res_tot = mysqli_fetch_array($result_tot);
                              $total = $res_tot['total'];
                             ?>
                            
                            <span class="text-success">Total: R$ <?php echo $total; ?>  </span>
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