<?php
header("access-control-allow-origin: https://pagseguro.uol.com.br");
header("Content-Type: text/html; charset=UTF-8",true);
date_default_timezone_set('America/Sao_Paulo');
include_once('../conexao.php');
session_start();

require_once("PagSeguro.class.php");
$PagSeguro = new PagSeguro();

$id_curso = $_GET['curso'];
$id_matricula = $_GET['codigo'];

 $query_curso = "SELECT * from cursos where id = '$id_curso' ";
                $result_curso = mysqli_query($conexao, $query_curso);
                $res_curso = mysqli_fetch_array($result_curso);
                $valor = $res_curso['valor'];
                $curso = $res_curso['nome'];

$query_mat = "SELECT * from matriculas where id = '$id_matricula' ";
                $result_mat = mysqli_query($conexao, $query_mat);
                $res_mat = mysqli_fetch_array($result_mat);
                $cpf_aluno = $res_mat['aluno'];


$query_aluno = "SELECT * from alunos where cpf = '$cpf_aluno' ";
                $result_aluno = mysqli_query($conexao, $query_aluno);
                $res_aluno = mysqli_fetch_array($result_aluno);
                $nome_aluno = $res_aluno['nome'];
                $telefone = $res_aluno['telefone'];
                $email = $res_aluno['email'];
                $cidade = $res_aluno['cidade'];
                $estado = $res_aluno['estado'];

               if($telefone == ""){
               	$telefone = "(33) 3333-3333";
               }


	
//EFETUAR PAGAMENTO	
$venda = array("codigo"=>$id_matricula,
			   "valor"=>$valor,
			   "descricao"=>$curso,
			   "nome"=>$nome_aluno,
			   "email"=>$email,
			   "telefone"=>$telefone,
			   "rua"=>"",
			   "numero"=>"",
			   "bairro"=>"",
			   "cidade"=>"",
			   "estado"=>"", //2 LETRAS MAIÚSCULAS
			   "cep"=>"",
			   "codigo_pagseguro"=>$id_matricula);
			   
$PagSeguro->executeCheckout($venda,"http://localhost/ACS APPS/painel_aluno/painel_aluno.php?acao=cursos");

//----------------------------------------------------------------------------


//RECEBER RETORNO
if( isset($_GET['transaction_id']) ){
	$pagamento = $PagSeguro->getStatusByReference($_GET['codigo']);
	
	$pagamento->codigo_pagseguro = $_GET['transaction_id'];
	if($pagamento->status==3 || $pagamento->status==4){

		
	}else{
		//ATUALIZAR NA BASE DE DADOS
	}
}

?>