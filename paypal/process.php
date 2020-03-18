<?php
$redirectStr = '';
if(!empty($_GET['paymentID']) && !empty($_GET['token']) && !empty($_GET['payerID']) && !empty($_GET['pid']) ){

    // Include and initialize database class
   include_once('../conexao.php');

    // Include and initialize paypal class
    include 'PaypalExpress.class.php';
    $paypal = new PaypalExpress;
    
    // Get payment info from URL
    $paymentID = $_GET['paymentID'];
    $token = $_GET['token'];
    $payerID = $_GET['payerID'];
    $productID = $_GET['pid'];
    
    // Validate transaction via PayPal API
    $paymentCheck = $paypal->validate($paymentID, $token, $payerID, $productID);
    
    // If the payment is valid and approved
    if($paymentCheck && $paymentCheck->state == 'approved'){

        // Get the transaction data
        $id = $paymentCheck->id;
        $state = $paymentCheck->state;
        $payerFirstName = $paymentCheck->payer->payer_info->first_name;
        $payerLastName = $paymentCheck->payer->payer_info->last_name;
        $payerName = $payerFirstName.' '.$payerLastName;
        $payerEmail = $paymentCheck->payer->payer_info->email;
        $payerID = $paymentCheck->payer->payer_info->payer_id;
        $payerCountryCode = $paymentCheck->payer->payer_info->country_code;
        $paidAmount = $paymentCheck->transactions[0]->amount->details->subtotal;
        $currency = $paymentCheck->transactions[0]->amount->currency;
        
        // Get product details
        $conditions = array(
            'where' => array('id' => $productID),
            'return_type' => 'single'
        );

        //ALTERAR STATUS DA MATRICULA
         $query_mat_al = "update matriculas set status = 'Matriculado' where id = '$productID'";

        mysqli_query($conexao, $query_mat_al);


          //trazer os dados da matricula para salvar nas vendas
           $query_mat = "SELECT * from matriculas where id = '$productID' ";

           $result_mat = mysqli_query($conexao, $query_mat);
           $res_mat = mysqli_fetch_array($result_mat);
           $aluno_mat = $res_mat['aluno'];
           $curso_mat = $res_mat['id_curso'];
           $valor_mat = $res_mat['valor'];


        //LANÇAR O VALOR DA MATRICULA NA TABELA DE VENDAS
         $query_vendas = "INSERT INTO vendas (curso, valor, aluno, data,  id_matricula) values ('$curso_mat', '$valor_mat', '$aluno_mat', curDate(), '$productID')";
         mysqli_query($conexao, $query_vendas);
       
    }
    
    // Redirect to payment status page
    header("Location:payment-status.php".$redirectStr);
}else{
    // Redirect to the home page
    header("Location:erro.php");
}
?>