<?php 
include_once("cabecalho.php");
include_once("conexao.php");
?>


  <?php 

    $id = $_GET['id'];

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

         <a href="#"><span class="valor"><i class="mt-3 fas fa-shopping-cart mr-1"></i>Matricule-se R$  <? echo $valor; ?></span></a>

      </div>

       <div class=" col-md-12 col-lg-3 col-sm-12">

      </div>

    </div>

    <hr>

      <div class="row">

        <div class="col-md-12 col-lg-9 col-sm-12">

          <div class="row">

            <div class="col-md-6 col-lg-5 col-sm-12 mb-1">
              <img src="imagens/curso.jpg" width="100%">
            </div>

            <div class="col-md-6 col-lg-7 col-sm-12">
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


            <div class="col-md-6 col-lg-7 col-sm-12 mt-3">
            </div>


          </div>

          <div class="col-md-12 col-lg-9 col-sm-12">

            <h5><small> Cursos Relacionados </small> </h5>

            <hr>

            <section class="bg-light page-section">
              <div class="container">
                <div class="row">


                  <?php 

                        $query = "select * from cursos where categoria = '$categoria' order by id";
                        $result = mysqli_query($conexao, $query);

                        while($res = mysqli_fetch_array($result)){
                          $nome = $res["nome"];
                          $desc_rapida = $res["desc_rapida"];
                          $imagem = $res["imagem"];  
                          $valor = $res["valor"]; 
                          

                          $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

                          $nome_sem_espaco = preg_replace('/[ -]+/' , '-' , $nome_novo);
                      ?>

                    <div class="col-md-3 col-sm-6 cursos-item">
                      <a class="cursos-link" href='curso.php?curso=<?php echo $nome; ?>&id=<?php echo $id; ?>'>
                        <div class="cursos-hover">
                          <div class="cursos-hover-content">
                            <i class="fas fa-plus fa-3x"></i>
                          </div>
                        </div>
                        <img class="img-fluid" src="imagens/cursos/<? echo $imagem; ?>" alt="">
                      </a>
                      <div class="cursos-caption">
                        <h4 class="text-dark "><? echo $nome; ?></h4>
                        <p class="text-muted"><? echo $desc_rapida; ?></p>
                        <p class="text-dark"><? echo $valor; ?></p>
                      </div>
                    </div>

                  <? } ?>

                  
                  
                </div>
              </div>
            </section>

          </div>

          <div class="col-md-12 col-lg-7 col-sm-12">

            <h5><small> Avaliações </small> </h5>

            <hr>

            <?php  

                    $query_ava = "select * from avaliacoes where curso = '$id' order by id asc ";

                    $result_ava = mysqli_query($conexao, $query_ava);

                    $linha_ava = mysqli_num_rows($result_ava);

                    if($linha_ava > 0){

                      while($res_ava = mysqli_fetch_array($result_ava)){
                        $id = $res_ava["id"];
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
                          <span> <img class="rounded-circle z-depth-0" src="imagens/perfil/<?php echo $img_aluno; ?>" width="25" height="25"> - <?php echo $nome; ?> <span class="ml-4"><?php echo $data2; ?></span>  </span><br>
                         <span> <?php echo $comentario ?> </span>
                       </div>

                   <?php } 

                    }else{
                      echo "<h5><small>Não foram encontrados dados cadastrados no banco!!!</small></h5>";
                    }

                    ?>

          </div>

        </div>

        <div class="col-md-12 col-lg-3 col-sm-12">

         
            <small>

              <?php

                $query_aulas = "select * from aulas where curso = '$id'";
                $result_aulas = mysqli_query($conexao, $query_aulas);

                while($res_aulas = mysqli_fetch_array($result_aulas)){
                  $num_aula = $res_aulas["num_aula"];
                  $nome = $res_aulas["nome"];
                  $link = $res_aulas["link"];

              ?>

                  <? if($num_aula <= 2){ ?>
             
                      <i class="fas fa-video mr-1"></i><a class="text-dark" href='curso.php?curso=<?php echo $nome_sem_espaco; ?>&id=<?php echo $id; ?>&acao=aula&aula=<? echo $num_aula; ?>'>Aula <? echo $num_aula; ?> - <? echo $nome; ?></a><br>
                  <? }else{ ?>

                      <i class="fas fa-video mr-1"></i>Aula <? echo $num_aula; ?> - <? echo $nome; ?><br>
                  <? } ?>

              <? } ?>
           
            </small>

        </div>
      
      </div>

  </div>

  <? }  ?>



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

              <iframe width="560" height="315" src="<? echo $link_aula ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              
             
            </div>
                   
            
            </div>
          </div>
        </div>
      </div>    

<? } ?>


<script> $("#modalAula").modal("show"); </script>


<?php 

      if(isset($_POST['fecharModal'])){
       
     
      echo "<script language='javascript'>window.location='curso.php?curso=$nome_sem_espaco&id=$id'; </script>";

}

?>