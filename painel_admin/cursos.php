
    <?php
    include_once('../conexao.php');

    ?>


    <div class="container ml-4">
    	<div class="row">

    		<div class="col-lg-6 col-md-6 col-sm-12">
			   
          <button class="btn btn-light" data-toggle="modal" data-target="#modalExemplo"> <i class="fas fa-user-plus"> CURSOS </i> </button>
          

			</div>

    		<div class="col-lg-6 col-md-6 col-sm-12">
			    <form class="form-inline my-2 my-lg-0">
            
            <select class="form-control mr-2" id="category" name="cbpesquisarCursos">
             <option value="Todos">Todos</option> 
             <option value="Em Análise">Em Análise</option> 
             <option value="Aprovado">Aprovado</option> 
             <option value="Em Construção">Em Construção</option> 
            </select>

			      <input name="txtpesquisarCursos" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Cursos" aria-label="Pesquisar">
			      <button name="buttonPesquisar" class="btn btn-light my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
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

                      $status = @$_GET['cbpesquisarCursos'];
                      	if(isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarCursos'] != ''){



                      		$nome = '%'. $_GET['txtpesquisarCursos'] . '%';

                          

                          if($status == 'Todos'){
                            $query = "SELECT * from cursos where nome LIKE '$nome' order by nome asc ";
                          }else{
                            $query = "SELECT * from cursos where nome LIKE '$nome' and status = '$status' order by nome asc ";
                          }
                      		
                      		

                      		$result_count = mysqli_query($conexao, $query);

                      	}else{

                          if($status == 'Todos' || $status == ''){
                      		$query = "SELECT * from cursos order by id desc limit 10";
                        }else{
                          $query = "SELECT * from cursos where status = '$status' order by id desc limit 10";
                        }

                      		if($status == 'Todos' || $status == ''){
                          $query_count = "SELECT * from cursos";
                          }else{
                            $query_count = "SELECT * from cursos where status = '$status'";
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
                            Nome
                          </th>
                          
                          <th>
                            Valor
                          </th>
                          <th>
                            Aulas
                          </th>
                          <th>
                            Professor
                          </th>
                          <th>
                            Categoria
                          </th>
                           <th>
                            Status
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
                            $id = $res["id"];


                            //TRAZER O NOME DA CATEGORIA
                            $query_categoria = "SELECT * from categorias where id = '$categoria' ";

                          $result_categoria = mysqli_query($conexao, $query_categoria);
                          $row_categoria =  mysqli_fetch_array($result_categoria);
                          $nome_categoria = $row_categoria['nome'];


                          //TRAZER O NOME DO PROFESSOR
                            $query_professor = "SELECT * from professores where cpf = '$professor' ";

                          $result_professor = mysqli_query($conexao, $query_professor);
                          $row_professor =  mysqli_fetch_array($result_professor);
                          $nome_professor = $row_professor['nome'];

                        	
                        ?>

                            <tr>

                             
                              
                             <td>
                               
                                <a class="text-dark" title="Adicionar Aulas" href="curso.php?id=<?php echo $id; ?>" target="_blank">

                                <?php echo $nome; ?> </a>

                             </td> 

                             <td><?php echo $valor; ?></td> 
                            
                             <td><?php echo $aulas; ?></td>
                             <td><?php echo $nome_professor; ?></td>
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

                                                        
                            
                             <td>



                              <a class="btn btn-warning" title="Enviar Mensagem" data-toggle="modal" data-target="#modalMensagem"><i class="fas fa-sticky-note"></i></a>

                             <a class="btn btn-danger" title="Excluir Curso" href="painel_admin.php?acao=cursos&func=excluir&id=<?php echo $id; ?>"><i class="fa fa-minus-square"></i></a>

                               <?php  if($status == 'Em Análise'){  ?>

                             <a class="btn btn-success" title="Aprovar Curso" href="painel_admin.php?acao=cursos&func=aprovar&id=<?php echo $id; ?>"><i class="fas fa-check-circle"></i></a>

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





<!-- Modal Mensagem -->
      <div id="modalMensagem" class="modal fade" role="dialog">
        <div class="modal-dialog">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title">Mensagem Professor</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="POST" action="">

              <div class="form-group">
                <label for="id_produto">Mensagem</label>
                <textarea type="text" class="form-control mr-2" name="mensagem" maxlength="300" required></textarea>
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





<?php 
  if(isset($_POST['salvar'])){
    $mensagem = $_POST['mensagem'];

    $query_msg = "UPDATE cursos SET mensagem = '$mensagem' where id = '$id' ";
   mysqli_query($conexao, $query_msg);

    echo "<script language='javascript'>window.location='painel_admin.php?acao=cursos'; </script>";
  }

  ?>

	

<!--EXCLUIR -->
<?php 
	if(@$_GET['func'] == 'excluir'){
		$id = $_GET['id'];


	$query = "DELETE FROM categorias where id = '$id' ";
	$result = mysqli_query($conexao, $query);
	echo "<script language='javascript'>window.location='painel_admin.php?acao=categorias'; </script>";

  
 

}

?>


 
<!--APROVAR CURSO -->
 <?php 
  if(@$_GET['func'] == 'aprovar'){
    $id = $_GET['id'];

  $query_msg = "UPDATE cursos SET status = 'Aprovado' where id = '$id' ";
   mysqli_query($conexao, $query_msg);

    echo "<script language='javascript'>window.location='painel_admin.php?acao=cursos'; </script>";

  }

  ?>



