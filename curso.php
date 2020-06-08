<?php 
include_once("cabecalho.php");
include_once("conexao.php");
session_start();
?>

<?php 

//includes para o mercado pago
include_once("mercadopago/lib/mercadopago.php");
include_once("mercadopago/PagamentoMP.php");
$pagar = new PagamentoMP;
$url = "http://localhost/ACS APPS";

 ?>


  <?php 

    $id = $_GET['id'];
    $nivel = @$_SESSION['nivel'];
    $cpf = @$_SESSION['cpf'];

    $query = "select * from cursos where id = $id";
    $result = mysqli_query($conexao, $query);

    while($res = mysqli_fetch_array($result)){
      $nome = $res["nome"];
      $desc_rapida = $res["desc_rapida"];
      $desc_longa = $res["desc_longa"];
      $imagem = $res["imagem"];  
      $valor = $res["valor"]; 
      $carga = $res["carga"];
      $professor = $res["professor"];
      $categoria = $res["categoria"];
      $aulas = $res["aulas"];
      $nome_curso = $res["nome"];

      $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

      $nome_sem_espaco = preg_replace('/[ -]+/' , '-' , $nome_novo);

      //recuperando professor
      $query_prof = "select * from professores where cpf = '$professor'";
      $result_prof = mysqli_query($conexao, $query_prof);
      $res_prof = mysqli_fetch_array($result_prof);
      $nome_prof = $res_prof["nome"];

      //recuperando categoria
      $query_cat = "select * from categorias where id = $categoria";
      $result_cat = mysqli_query($conexao, $query_cat);
      $res_cat = mysqli_fetch_array($result_cat);
      $nome_cat = $res_cat["nome"];


  ?>

  <div class="container conteudo_curso" id="servicos">

    <div class="py-3 mt-3 row cabecalho_curso">

      <div class=" py-3 mt-5 col-md-12 col-lg-9 col-sm-12">

        <h5>Curso de <? echo $nome; ?> - <small><? echo $desc_rapida; ?></small></h5>

        <!-- VERIFICAR SE O ALUNO ESTA LOGADO -->
          <a href="curso.php?acao=pagamento&id=<? echo $id; ?>"><span class="valor"><i class="mt-3 fas fa-shopping-cart mr-1"></i>Matricule-se R$  <? echo $valor; ?></span></a>         

      </div>

       <div class=" col-md-12 col-lg-3 col-sm-12">

      </div>

    </div>

    <hr>

      <div class="row">

        <div class="col-sm-12 col-md-9 col-lg-9">

          <!-- DESCRIÇÃO DO CURSO -->
          <div class="row">
              <!-- IMAGEM -->
              <div class="col-sm-12 col-md-4 col-lg-4">
                  <img src="imagens/cursos/<?echo $imagem; ?>" width="100%">
              </div>
              <!-- CONTEÚDO DO CURSO -->
              <div class="col-sm-12 col-md-8 col-lg-8">

                <p class="descricao"> <? echo $desc_longa; ?></p>

                <div class="row mt-2">
                  
                   <div class="col-md-7 col-lg-6 col-sm-12">

                     <span class="text-muted descricao"><i class="fas fa-chalkboard-teacher mr-1"></i>Professor : <? echo $nome_prof; ?></span>

                  </div>

                  <div class="col-md-5 col-lg-6 col-sm-12">

                     <span class="text-muted descricao"><i class="fas fa-video mr-1"></i>Aulas : <? echo $aulas; ?> Aulas</span>

                  </div>

                </div>

                <div class="row mt-1 mb-3">
                  
                   <div class="col-md-7 col-lg-6 col-sm-12">

                     <span class="text-muted descricao"><i class="fas fa-layer-group mr-1"></i>Categoria : <? echo $nome_cat; ?></span>

                  </div>

                  <div class="col-md-5 col-lg-6 col-sm-12">

                     <span class="text-muted descricao"><i class="fas fa-video mr-1"></i>Certificado : <? echo $carga; ?> Horas</span>

                  </div>

                </div>

              </div>


          </div>

          <!-- CURSOS RELACIONADOS -->
          <div class="row">
            <div class="container mt-3 mb-3">
              <h5><small> Cursos Relacionados </small></h5>
            </div>

            <section class="bg-light page-section">
              <div class="container">
                <div class="row">


                  <?php 
                        $id = $_GET['id'];

                        $query = "select * from cursos where categoria = '$categoria' order by id";
                        $result = mysqli_query($conexao, $query);

                        while($res = mysqli_fetch_array($result)){
                          $nome = $res["nome"];
                          $desc_rapida = $res["desc_rapida"];
                          $imagem = $res["imagem"];  
                          $valor = $res["valor"]; 
                          $id = $res["id"];

                          

                          $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

                          $nome_sem_espaco_2 = preg_replace('/[ -]+/' , '-' , $nome_novo);
                      ?>

                    <div class="col-md-3 col-sm-6 cursos-item">
                      <a class="cursos-link" href='curso.php?curso=<?php echo $nome_sem_espaco_2; ?>&id=<?php echo $id; ?>'>
                        <img class="img-fluid text-center" src="imagens/cursos/<? echo $imagem; ?>" alt="">
                      </a>
                      <div class="cursos-caption">
                        <h4 class="text-dark text-center "><? echo $nome; ?></h4>
                        <p class="text-muted text-center"><? echo $desc_rapida; ?></p>
                        <p class="text-dark text-center"> R$ <? echo $valor; ?></p>
                      </div>
                    </div>

                  <? } ?>

                  
                  
                </div>
              </div>
            </section>

          </div>

          <!-- AVALIAÇÕES -->
          <div class="row">

            <div class="container mt-3 mb-4">
              <h5><small> Avaliações </small> </h5>

            <hr>

            <?php  

                    $id = $_GET['id'];
                   
                    $query_ava = "select * from avaliacoes where curso = '$id' order by id asc ";

                    $result_ava = mysqli_query($conexao, $query_ava);

                    $linha_ava = mysqli_num_rows($result_ava);

                    if($linha_ava > 0){

                      while($res_ava = mysqli_fetch_array($result_ava)){
                        $id_ava = $res_ava["id"];
                        $nota = $res_ava["nota"];
                        $comentario = $res_ava["comentario"];
                        $aluno = $res_ava["aluno"];
                        $data = $res_ava["data"];

                        $data2 = implode('/', array_reverse(explode('-', $data)));

                        $query_aluno = "select * from alunos where cpf = '$aluno' ";

                        $result_aluno = mysqli_query($conexao, $query_aluno);
                        $res_aluno = mysqli_fetch_array($result_aluno);
                        $img_aluno = $res_aluno['imagem'];
                        $nome = $res_aluno['nome'];                     

                        ?>
                        <div class="mt-3">
                          <span> <img class="rounded-circle z-depth-0" src="imagens/perfil/<?php echo $img_aluno; ?>" width="25" height="25"> - <?php echo $nome; ?> <span class="ml-4"><?php echo $data2; ?></span>  </span>
                          <? if($nota == 5){ ?>



                          <span class="ml-4"><i class="fas fa-star text-warning"><i class="fas fa-star"><i class="fas fa-star"><i class="fas fa-star"><i class="fas fa-star"></i></i></i></i></i></span>

                          <span class="ml-1 text-muted"><i>-  Excelente </i></span>

                          <? } ?>

                          <? if($nota == 4){ ?>



                          <span class="ml-4"><i class="fas fa-star text-warning"><i class="fas fa-star"><i class="fas fa-star"><i class="fas fa-star"></i></i></i></i></span>

                          <span class="ml-1 text-muted"><i>-  Muito Bom </i></span>

                          <? } ?>
                          <? if($nota == 3){ ?>



                          <span class="ml-4"><i class="fas fa-star text-warning"><i class="fas fa-star"><i class="fas fa-star"></i></i></i></span>

                          <span class="ml-1 text-muted"><i>-  Bom </i></span>

                          <? } ?>

                          



                          <? if($nota == 2){ ?>



                          <span class="ml-4"><i class="fas fa-star text-warning"><i class="fas fa-star"></i></i></span>

                          <span class="ml-1 text-muted"><i>-  Ruim </i></span>

                          <? } ?>

                          <? if($nota == 1){ ?>



                          <span class="ml-4"><i class="fas fa-star text-warning"></i></span>

                          <span class="ml-1 text-muted"><i>-  Muito Ruim </i></span>

                          <? } ?>

                          <?php if(@$_SESSION['nivel'] === 'Administrador' ){

                            $nivel_usuario_2 = @$_SESSION['nivel'];

                          ?>

                            <span class="ml-4 text-danger"><a href="curso.php?curso=<?php echo $nome_sem_espaco_2; ?>&id=<?php echo $id; ?>&func=excluir_ava&id_ava=<?php echo $id_ava ?>"><span class="ml-4 text-danger"><i class="far fa-trash-alt"></i></span></a></span>

                           <? } ?>

                          <br>
                         <span> <?php echo $comentario ?> </span>
                       </div>

                   <?php } 

                    }else{
                      echo "<h5><small>Não foram encontrados dados cadastrados no banco!!!</small></h5>";
                    }

                    ?>
            </div>
          </div>

        </div>

        <div class="col-md-12 col-md-3 col-lg-3">
           <small>

              <?php

                $id = $_GET['id'];

                $query_aulas = "select * from aulas where curso = '$id'";
                $result_aulas = mysqli_query($conexao, $query_aulas);

                while($res_aulas = mysqli_fetch_array($result_aulas)){
                  $num_aula = $res_aulas["num_aula"];
                  $nome = $res_aulas["nome"];
                  $link = $res_aulas["link"];

              ?>

                  <? if($num_aula <= 2){ ?>
             
                      <i class="fas fa-video mr-1"></i><a class="text-dark" href='curso.php?curso=<?php echo $nome_sem_espaco_2; ?>&id=<?php echo $id; ?>&acao=aula&aula=<? echo $num_aula; ?>'>Aula <? echo $num_aula; ?> - <? echo $nome; ?></a><br>
                  <? }else{ ?>

                      <i class="fas fa-video mr-1"></i>Aula <? echo $num_aula; ?> - <? echo $nome; ?><br>
                  <? } ?>

              <? } ?>
           
            </small>
        </div>

      </div>

  </div>



<? } ?>


<? include_once "rodape.php" ?>


<!--ABRIR MODAL COM A AULA -->
<?php 
  if(@$_GET['acao'] == 'aula'){
    $num_aula = $_GET['aula'];
    $id_curso = $_GET['id'];

    $query_aulas_modal = "select * from aulas where curso = '$id_curso' and num_aula = $num_aula";
    $result_aulas_modal = mysqli_query($conexao, $query_aulas_modal);

    $res_aulas_modal = mysqli_fetch_array($result_aulas_modal);
    $nome_aula = $res_aulas_modal["nome"];
    $link_aula = $res_aulas_modal["link"];
?>

  <!-- Modal Mensagem -->
      <div id="modalAula" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <form method="POST" action="">
              <div class="modal-header">
                <h5 class="modal-title">Aula <? echo $num_aula; ?> - <? echo $nome_aula; ?></h5>
                <button type="submit" class="close" name="fecharModal">&times;</button>
              </div>
            </form>
            <div class="modal-body">

              <iframe class="embed-responsive embed-responsive-21by9" src="<? echo $link_aula ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" style="height:400px;" allowfullscreen></iframe>
             
            </div>
                   
            </div>
          </div>
        </div>
      </div>    

<? } ?>


<script> $("#modalAula").modal("show"); </script>


<!--EXCLUIR A AVALIAÇÃO -->
<?php 
  if(@$_GET['func'] == 'excluir_ava'){
    $id_ava = $_GET['id_ava'];
    echo "<script language='javascript'>window.alert('Entrou no Excluir!'); </script>";
    $query = "DELETE from avaliacoes where id = '$id_ava'";

    $result = mysqli_query($conexao, $query);

    if($result == ''){
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Excluir!'); </script>";
    }else{
     
     echo "<script language='javascript'>window.location='curso.php?curso=$nome_sem_espaco&id=$id'; </script>";

    }
 
 }
                         
?>


<?php 

      if(isset($_POST['fecharModal'])){
       
     
      echo "<script language='javascript'>window.location='curso.php?curso=$nome_sem_espaco&id=$id'; </script>";

}

?>


<!-- MODAL PAGAMENTO -->
<?php 
  if(@$_GET['acao'] == 'pagamento'){
    
    $id_curso = $_GET['id'];

    
?>

  <!-- Modal Pagamento -->
      <div id="modalPagamento" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content bg-light">
            <form method="POST" action="">
              <div class="modal-header">
                <h5 class="modal-title">Pagamento Curso de <? echo $nome_curso; ?></h5>
                <button type="submit" class="close" name="fecharModal">&times;</button>
              </div>
            </form>
            <div class="modal-body">

              <? if($nivel == ''){?>

              <p class="text-muted"> Você precisa estar logado no site para efetuar a matrícula no curso, faça seu login <a href="login.php?curso=<? echo $id_curso; ?>" target="_blank" class="text-danger"> aqui </a> ou caso não tenha cadastro cadastre-se <a href="login.php?curso=<? echo $id_curso; ?>&acao=loginpgto" target="_blank" class="text-danger"> aqui!!!</p>

              <? }else{ ?>


                <?php

                  //iniciando a matricula com status de aguardando pagamento


                  $query_verificar = "SELECT * from matriculas where id_curso = '$id_curso' and aluno = '$cpf' ";
                  $result_verificar = mysqli_query($conexao, $query_verificar);
                  $row_verificar = mysqli_num_rows($result_verificar);
                  $res_cpf = mysqli_fetch_array($result_verificar);
                  $aulas_concluidas = $res_cpf['aulas_concluidas'];


                  if($row_verificar == 0){

                    $query_mat = "INSERT INTO matriculas (id_curso, aluno, professor, aulas_concluidas, valor, data,status) values ('$id_curso', '$cpf', '$professor', '1', '$valor', curDate(), 'Aguardando')";

                     mysqli_query($conexao, $query_mat);
                     

                   } ?>

                  <?php

                    //VERIFICAR SE O ALUNO ESTÁ MATRICULADO NO CURSO E SUA MATRICULA ESTÁ APROVADA
                $query_verificar_status = "SELECT * from matriculas where id_curso = '$id_curso' and aluno = '$cpf' and status = 'Matriculado' ";
                $result_verificar_status = mysqli_query($conexao, $query_verificar_status);

                              
                $row_verificar_status = mysqli_num_rows($result_verificar_status);

                  if($row_verificar_status == 0){   ?>


                    <?php 

                      //RECUPERAR O ID DA MATRICULA CRIADA
                      $query_mat = "SELECT * from matriculas where id_curso = '$id_curso' and aluno = '$cpf' ";
                      $result_mat = mysqli_query($conexao, $query_mat);

                      $res_mat = mysqli_fetch_array($result_mat);
                   
                      $id_mat = $res_mat['id'];
                      $valor_mat = $res_mat['valor'];

                    ?>

                    <div class="row">
                      <div class="col-md-4 col-sm-12 mb-1">

                          <a title="PagSeguro - Acesso Imediato ao Curso" target="_blank" href="pagseguro/checkout.php?codigo=<?php echo $id_mat; ?>&curso=<?php echo $id_curso; ?>"><img src="imagens/pagamentos/pagseguro.png" width="200"></a>
                          <span class="text-muted"><i><small><br>Liberação Imediata no Cartão <br>
                          Boleto pode demorar até 24 Horas.</small></i></span>

                      </div>

                      <div class="col-md-4 col-sm-12 mb-1">
                        <a title="Paypal - Acesso Imediato ao Curso" href="paypal/checkout.php?id=<?php echo $id_mat; ?>&curso=<?php echo $id_curso; ?>" target="_blank"><img src="imagens/pagamentos/paypal.png" width="200"></a> 
                          <span class="text-muted"><i><small><br>Liberação Imediata no Cartão <br>
                          Pagamentos no Estrangeiro.</small></i></span>
                      </div>

                     
                      <div class="col-md-4 col-sm-12 mb-1">
                        //<?php 
                          //botao do mercado pago
                          $btn = $pagar->PagarMP($id_mat, $nome_curso, (float)$valor_mat, $url);

                           echo $btn;
                         ?>

                          <span class="text-muted"><i><small><br>Liberação Imediata Cartão ou Saldo <br>
                          Boleto pode demorar até 24 Horas.</small></i></span>
                      </div>
                      
                    
                     

                     </div>



                     <div class="row mt-4">
                       <div class="col-md-12">
                        <p align="center">Depósitos ou Transferências </p> 
                        <span class="text-muted"><small> Precisamos que nos envie o comprovante para a liberação do curso, se for transferência será liberado de Imediato, caso seja depósito ou Doc precisa aguardar o pagamento ser compensado, geralmente de 12 a 24 horas, pode nos mandar o comprovante no WhatsApp <a class="text-muted" href="http://api.whatsapp.com/send?1=pt_BR&phone=5535992220490" alt="35 99222-0490" target="_blank"><i class="fab fa-whatsapp mr-1 text-success"></i>31 97527-5084</a> ou no email alificleiton123@gmail.com !!</span></small>

                        <a href="imagens/pagamentos/contas-grande.png" title="Clique para Ampliar" target="_blank">
                        <img src="imagens/pagamentos/contas.png" width="100%" class="mt-3">
                        <p align="center" class="text-danger"><i><small>Clique para Ampliar</small></i></p> </a>

                       </div>
                     </div>




                    <? }else{ ?>

                    <p target="_blank" class="text-muted">Você já possui este curso, entre no seu painel, clique <a href="painel_aluno/painel_aluno.php?acao=cursos&func=aulas&id=<? echo $id_curso;?>&aulas_concluidas=<? echo $aulas_concluidas;?>" target="_blank" class="text-danger"> aqui</a>para acompanhar o curso</p>

                  <? } ?>

                  
                <? } ?>
              
             
            </div>
                   
            
            </div>
          </div>
        </div>
      </div>    

<? } ?>

<script> $("#modalPagamento").modal("show"); </script>
