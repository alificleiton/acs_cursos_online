<?php
    include_once('../conexao.php');

    ?>


    <div class="container ml-4">
    	<div class="row">

    		<div class="col-lg-8 col-md-6 col-sm-12">
			    <button class="btn btn-light" data-toggle="modal" data-target="#modalExemplo"> <i class="fas fa-user-plus"> CATEGORIAS </i> </button>

			</div>

    		<div class="col-lg-4 col-md-6 col-sm-12">
			    <form class="form-inline my-2 my-lg-0">
			      <input name="txtpesquisarCategorias" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Categorias" aria-label="Pesquisar">
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
                      	if(isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarCategorias'] != ''){


                      		$nome = '%'. $_GET['txtpesquisarCategorias'] . '%';
                      		
                      		$query = "SELECT * from categorias where nome LIKE '$nome' order by nome asc ";

                      		$result_count = mysqli_query($conexao, $query);

                      	}else{
                      		$query = "SELECT * from categorias order by id desc limit 10";

                      		$query_count = "SELECT * from categorias";
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
                            Descrição
                          </th>
                          <th>
                            Cursos
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
                        		$descricao = $res["descricao"];
                        		$cursos = $res["cursos"];
                        		$imagem = $res["imagem"];
                            $id = $res["id"];
                        	

                        	
                        ?>

                            <tr>

                             <td><?php echo $nome; ?></td>
                             <td><?php echo $descricao; ?></td> 
                            
                             <td><?php echo $cursos; ?></td>
                             <td><img src="../imagens/categorias/<?php echo $imagem; ?>" width="40" height="40" ></td>
                            
                            
                             <td>
                             <a class="btn btn-info" href="painel_admin.php?acao=categorias&func=edita&id=<?php echo $id; ?>"><i class="fas fa-edit"></i></a>

                             <a class="btn btn-danger" href="painel_admin.php?acao=categorias&func=excluir&id=<?php echo $id; ?>"><i class="fa fa-minus-square"></i></a>

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
        <div class="modal-dialog">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <div class="modal-header">
              
              <h5 class="modal-title">Categorias</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="POST" action="" enctype="multipart/form-data">

              <div class="form-group">
                <label for="id_produto">Nome</label>
                <input type="text" class="form-control mr-2 text-dark" name="nome" placeholder="Nome" required>
              </div>

                <div class="form-group">
                <label for="id_produto">Descrição</label>
                <input type="text" class="form-control mr-2 text-dark" name="descricao" placeholder="Descrição" required>
              </div>

              
               <div class="form-group">
                 <label for="inputAddress">Foto</label>
                 <div class="custom-file">
                  
                    <input type="file" class="custom-file-input" name="imagem" id="imagem">
                    <label class="custom-file-label" for="customFile">Escolher Foto</label>
                   
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
		$descricao = $_POST['descricao'];
		

    $caminho = '../imagens/categorias/' .$_FILES['imagem']['name'];
    $imagem = $_FILES['imagem']['name']; 
    $imagem_temp = $_FILES['imagem']['tmp_name']; 
    move_uploaded_file($imagem_temp, $caminho);
		


		//VERIFICAR SE O NOME JÁ ESTÁ CADASTRADO
		$query_verificar_nome = "SELECT * from categorias where nome = '$nome' ";
		$result_verificar_nome = mysqli_query($conexao, $query_verificar_nome);
		$row_verificar_nome = mysqli_num_rows($result_verificar_nome);
		if($row_verificar_nome > 0){
			echo "<script language='javascript'>window.alert('Nome já Cadastrado'); </script>";
			exit();
		}

		$query = "INSERT INTO categorias (nome, descricao, imagem) values ('$nome', '$descricao', '$imagem')";

		$result = mysqli_query($conexao, $query);

		if($result == ''){
			echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
		}else{
			echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
			echo "<script language='javascript'>window.location='painel_admin.php?acao=categorias'; </script>";

		}
		
	}
 ?>




<!--EDITAR -->
<?php 
	if(@$_GET['func'] == 'edita'){
		$id = $_GET['id'];

	$query = "select * from categorias where id = '$id' ";
	$result = mysqli_query($conexao, $query);

	while($res = mysqli_fetch_array($result)){
		$nome = $res["nome"];
    $descricao = $res["descricao"];

                     		
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
               <form method="POST" action="" enctype="multipart/form-data">

              <div class="form-group">
                <label for="id_produto">Nome</label>
                <input type="text" class="form-control mr-2 text-dark" name="nome" value="<?php echo $nome ?>" placeholder="Nome" required>
              </div>

                <div class="form-group">
                <label for="id_produto">Descrição</label>
                <input type="text" class="form-control mr-2 text-dark" name="descricao" placeholder="Descrição" value="<?php echo $descricao ?>" required>
              </div>

            
                <div class="form-group">
                 <label for="inputAddress">Foto</label>
                 <div class="custom-file">
                  
                    <input type="file" class="custom-file-input" name="imagem" id="imagem">
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
		$descricao = $_POST['descricao'];
		
     $caminho = '../imagens/categorias/' .$_FILES['imagem']['name'];
    $imagem = $_FILES['imagem']['name']; 
    $imagem_temp = $_FILES['imagem']['tmp_name']; 
    move_uploaded_file($imagem_temp, $caminho);


		if($res["nome"] != $nome){
			//VERIFICAR SE O nome JÁ ESTÁ CADASTRADO
		$query_verificar_cpf = "SELECT * from categorias where nome = '$nome' ";
		$result_verificar_cpf = mysqli_query($conexao, $query_verificar_cpf);
		$row_verificar_cpf = mysqli_num_rows($result_verificar_cpf);
			if($row_verificar_cpf > 0){
				echo "<script language='javascript'>window.alert('Nome já Cadastrado'); </script>";
				exit();
			}
		}

		

    if($_FILES['imagem']['name'] == ''){
      $query = "UPDATE categorias SET nome = '$nome', descricao = '$descricao' where id = '$id' ";

    }else{
      $query = "UPDATE categorias SET nome = '$nome', descricao = '$descricao', imagem = '$imagem' where id = '$id' ";

    }
		
		$result = mysqli_query($conexao, $query);


   

		if($result == ''){
			echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
		}else{
			echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
			echo "<script language='javascript'>window.location='painel_admin.php?acao=categorias'; </script>";

		}

	}
		



	 } } 

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


 <script> $("#modalEditar").modal("show"); </script> 

