<?php 
include_once("conexao.php");
 class PagamentoMP{
      // vamos dar alguns atributos a esta class
      // como :
     // O botão que irá retornar da função PagarMP (string)
     public $btn_mp;
     // Definiremos o botão que irá retornar, se será uma lightbox // do mercado pago ou não, como padrão será false. o user será 
     // redirecionado para o site do mercado pago
     private $lightbox = false;
     // Esta variável recebe uma array com os dados da transação
     public $info = array();
     // Se for em modo de teste, esta variável recebe true, caso 
     // contrário o sistema estará em modo de produção
     private $sandbox = true;
     // Suas credenciais do mercado pago
     private $client_id = "6112808213721502";
     private $client_secret = "W7x9scUcyIo07gXXsp371k48QviYYQtD";
     
     public function PagarMP($ref , $nome , $valor , $url){
     // iniciando as credenciais do MP
     // Os valores de client_id e client_secret são informados  aqui
     $mp = new MP($this->client_id, $this->client_secret);
     
    $preference_data = array(   
            // dados do produto para pagamento 
            "items" => array(
                array(
                    "id"          => 0001,
                    "title"       => $nome,
                    "currency_id" => "BRL",
                    "picture_url" => "https://www.mercadopago.com/org-img/MP3/home/logomp3.gif",
                    "description" => $nome,
                    "quantity"    => 1,
                    "unit_price"  => $valor
                )
            ),
            "back_urls" => array(
               "success" => $url."/mercadopago/notifica.php?success",
               "failure" => $url."/mercadopago/notifica.php?failure",
               "pending" => $url."/mercadopago/notifica.php?pending"
             ),
            "notification_url" => $url."/mercadopago/notifica.php",
            "external_reference" => $ref
        );
      $preference = $mp->create_preference($preference_data);
     
      // Criar link para o botão de pagamento normal ou sandbox
        if($this->sandbox):
         //sandbox
         $mp->sandbox_mode(TRUE);
         $link = $preference["response"]["sandbox_init_point"];
            else:
            // normal em produção
            $mp->sandbox_mode(FALSE);
            $link = $preference["response"]["init_point"];
           endif;
        $this->btn_mp = '<a title="Mercado Pago - Acesso Imediato ao Curso" class="" id="btnMP" target="_blank" href="'.$link.'" '; 
        $this->btn_mp .= 'name="MP-Checkout" ><img src="imagens/pagamentos/mercadopago.jpg" width="200"></a>';
         if($this->lightbox):
            $this->btn_mp .= '<script type="text/javascript" src="//secure.mlstatic.com/mptools/render.js"></script>';
          endif;
     
        return $this->btn_mp;
     
     
     }
   public function Retorno($id , $conexao){
      // iniciando as credenciais do MP
      $mp = new MP($this->client_id, $this->client_secret);
      
      
      // Dentro da função Retorno
      $params = ["access_token" => $mp->get_access_token()];
      // params recebe o token
      $topic = 'payment';
      
      if ($topic == 'payment'){
      $payment_info = $mp->get("/collections/notifications/" . $id, $params, false);
      
      $merchant_order_info = $mp->get("/merchant_orders/" . $payment_info["response"]["collection"]["merchant_order_id"], $params, false);
      
      }
      
      switch ($payment_info["response"]["collection"]["status"]):
         case "approved"     : $status = "Aprovado";           break;
         case "pending"      : $status = "Pendente";           break;
         case "in_process"   : $status = "Análise";            break;
         case "rejected"     : $status = "Rejeitado";          break;
         case "refunded"     : $status = "Devolvido";          break;
         case "cancelled"    : $status = "Cancelado";          break;
         case "in_mediation" : $status = "Mediação";           break;
   
     endswitch;
      
      
      switch ($payment_info["response"]["collection"]["payment_type"]):
      
         case "ticket"        : $forma = "Boleto";
        break;
         case "account_money" : $forma = "Saldo MP";
        break;
         case "credit_card"   : $forma = "Cartão de Crédito";
        break;
         default : $forma =   $payment_info["response"]["collection"]["payment_type"];
         
      endswitch;
        
        
     $ref = $payment_info["response"]["collection"]["external_reference"];


      if ($status == "Aprovado"){
      	$query = mysqli_query($conexao,"UPDATE matriculas SET status='Matriculado' WHERE id='$ref'");


         //trazer os dados da matricula para salvar nas vendas
           $query_mat = "SELECT * from matriculas where id = '$ref' ";

           $result_mat = mysqli_query($conexao, $query_mat);
           $res_mat = mysqli_fetch_array($result_mat);
           $aluno_mat = $res_mat['aluno'];
           $curso_mat = $res_mat['id_curso'];
           $valor_mat = $res_mat['valor'];


        //LANÇAR O VALOR DA MATRICULA NA TABELA DE VENDAS
         $query_vendas = "INSERT INTO vendas (curso, valor, aluno, data,  id_matricula) values ('$curso_mat', '$valor_mat', '$aluno_mat', curDate(), '$ref')";
         mysqli_query($conexao, $query_vendas);
         
      }
        
      
      
      
      
      
      
     }
   }
?>