<?php 
 if($_GET['collection_id'] || $_GET['id']){
   
   include_once("../conexao.php");                   // Conexão
   require_once 'lib/mercadopago.php';  // Biblioteca Mercado Pago
   require_once 'PagamentoMP.php';            // Classe Pagamento
   
   $pagar = new PagamentoMP;
   
   if(isset($_GET['collection_id'])):
    $id =  $_GET['collection_id'];
   elseif(isset($_GET['id'])):
    $id =  $_GET['id'];
   endif; 
   
   
   $retorno = $pagar->Retorno($id , $conexao);
   if($retorno){
      // Redirecionar usuario
      echo '<script>location.href="../painel_aluno/painel_aluno.php?acao=cursos"</script>';
   }else{
     // Redirecionar usuario e informar erro ao admin
      echo '<script>location.href="../painel_aluno/painel_aluno.php?acao=cursos"</script>';
      
      /*
       
       ENVIAR EMAIL AO ADMIN
      
      */
   }
   
 }
 
 
?>