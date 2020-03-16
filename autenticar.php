<?php
    include_once('conexao.php');
    session_start();
    $id_curso = @$_GET['curso'];
?>


 <?php

 	//verifica se post usuario ou senha estao vazios
	 if(empty($_POST['usuario']) || empty($_POST['senha'])){
	 	header('Location:login.php');
	 	exit();
	 }

	//pega do post os valores e adiciona nas variáveis
	$usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
	$senha = mysqli_real_escape_string($conexao, $_POST['senha']);

	//verfica no banco de dados se possui o usuario e senha
	$query = "select * from usuarios where usuario = '$usuario' and senha = '$senha' ";
	$result = mysqli_query($conexao, $query);
	$dado = mysqli_fetch_array($result);                    	
	$linha = mysqli_num_rows($result);
        	
	//se linha retornar um valor maior que zero quer dizer que encontrou
	if($linha > 0){

		//pega os dados do usuario
		$_SESSION['usuario'] = $usuario;
		$_SESSION['nome'] = $dado['nome'];
		$_SESSION['nivel'] = $dado['nivel'];
		$_SESSION['cpf'] = $dado['cpf'];


		//verifica qual tipo de usuario ele é

		if($_SESSION['nivel'] == 'Administrador'){
			header('Location:painel_admin/painel_admin.php');
			exit();
		}

		if($_SESSION['nivel'] == 'Professor'){
			header('Location:painel_professor/painel_professor.php');
			exit();
		}

		if($_SESSION['nivel'] == 'Aluno'){

			//verificação se o usuario esta entrando no painel ou direto no curso
			if($id_curso == 0){
				header('Location:painel_aluno/painel_aluno.php');
			}else{
				echo "<script language='javascript'>window.location='curso.php?acao=pagamento&id=$id_curso'; </script>";
			}

			exit();
		}

		
	}else{

		$_SESSION['nao_autenticado'] = true;
		header('Location:login.php');
		
	}

?>