<?php 
include_once("../conexao.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Portal de Cursos da Escola Q-Cursos Networks, Participe das nossas formações e seja um profissional reconhecido!!">
  <meta name="author" content="Hugo Vasconcelos">
  <meta name="keywords" content="cursos, portal de cursos, curso de tecnologia, cursos de programação, cursos online">
  <title>Painel Administrador</title>


  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

  <link rel="stylesheet" href="../css/estilos-site.css">
  <link rel="stylesheet" href="../css/estilos-padrao.css">
  <link rel="stylesheet" href="../css/cursos.css">
  <link rel="stylesheet" href="../css/detalhes_curso.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<script src="js/validation.js"></script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


</head>

<body>

   <?php 

        $id = $_GET['id'];

        $query = "select * from cursos where id = '$id' ";

        $result = mysqli_query($conexao, $query);

        while($res = mysqli_fetch_array($result)){
          $nome = $res["nome"];
          $desc_rapida = $res["desc_rapida"];
          $imagem = $res["imagem"]; 
          $valor = $res["valor"];
          $descricao_longa = $res["desc_longa"];
          $aulas = $res["aulas"];
          $professor = $res["professor"];
          $categoria = $res["categoria"];
          $carga = $res["carga"];
          $link = $res["arquivo"];

           $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", 
strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

          $nome_sem_espaco = preg_replace('/[ -]+/' , '-' , $nome_novo);


          //recuperar o nome do professor
            $query_prof = "select * from professores where cpf = '$professor' ";

            $result_prof = mysqli_query($conexao, $query_prof);
            $res_prof = mysqli_fetch_array($result_prof);
            $nome_professor = $res_prof["nome"];

             //recuperar o nome da categoria
            $query_cat = "select * from categorias where id = '$categoria' ";

            $result_cat = mysqli_query($conexao, $query_cat);
            $res_cat = mysqli_fetch_array($result_cat);
            $nome_categoria = $res_cat["nome"];

          ?>

  <div class="container conteudo_curso">

    <div class="row mt-4">

      <div class="col-md-12 col-lg-9 col-sm-12">

        <h5>Curso de <?php echo $nome; ?> - <small><?php echo $desc_rapida; ?></small></h5>

         <a href="#"><span class="valor"><i class="fas fa-shopping-cart mr-1"></i>Matricule-se R$ <?php echo $valor; ?></span></a>

      </div>

       <div class="col-md-12 col-lg-3 col-sm-12 mt-2">

          <span class="descricao"><i class="far fa-file-alt mr-1"></i><a href="<?php echo $link; ?>" target="_blank" class="text-dark">Arquivos do Curso </a></span>

      </div>

    </div>

    <hr>



      <div class="row">

      <div class="col-md-12 col-lg-9 col-sm-12">

        <div class="row">

          <div class="col-md-6 col-lg-5 col-sm-12 mb-1">
            <img src="../imagens/cursos/<?php echo $imagem; ?>" width="100%">
          </div>

          <div class="col-md-6 col-lg-7 col-sm-12">
            <p class="descricao"><?php echo $descricao_longa; ?></p>

              <div class="row mt-2">
                
                 <div class="col-md-7 col-lg-6 col-sm-12">

                   <span class="text-muted descricao"><i class="fas fa-chalkboard-teacher mr-1"></i>Professor : <?php echo $nome_professor; ?></span>

                </div>

                <div class="col-md-5 col-lg-6 col-sm-12">

                   <span class="text-muted descricao"><i class="fas fa-video mr-1"></i>Aulas : <?php echo $aulas; ?> Aulas</span>

                </div>

              </div>


               <div class="row mt-1 mb-3">
                
                 <div class="col-md-7 col-lg-6 col-sm-12">

                   <span class="text-muted descricao"><i class="fas fa-layer-group mr-1"></i>Categoria : <?php echo $nome_categoria; ?></span>

                </div>

                <div class="col-md-5 col-lg-6 col-sm-12">

                   <span class="text-muted descricao"><i class="fas fa-video mr-1"></i>Certificado : <?php echo $carga; ?> Horas</span>

                </div>

              </div>

           

            
          </div>


          <div class="col-md-6 col-lg-7 col-sm-12 mt-3">
           
           

          </div>


        </div>

      

      </div>



      

       <div class="col-md-12 col-lg-3 col-sm-12">

       
          <small>

            <?php  

             $query_aulas = "select * from aulas where curso = '$id' ";

            $result_aulas = mysqli_query($conexao, $query_aulas);

            while($res_aulas = mysqli_fetch_array($result_aulas)){
              $num_aula = $res_aulas["num_aula"];
              $nome_aula = $res_aulas["nome"];
              $link = $res_aulas["link"];
              ?>

             

                <i class="fas fa-video mr-1"></i> <a class="text-dark" href="curso.php?<?php echo $nome_sem_espaco; ?>&id=<?php echo $id; ?>&acao=aula&aula=<?php echo $num_aula; ?>">Aula <?php echo $num_aula; ?> - <?php echo $nome_aula; ?></a><br>

            
        

         <?php } ?>
         
        </small>
      

      </div>




    </div>



  </div>


<?php }  ?>

</body>

</html>






<!--ABRIR MODAL COM A AULA -->
<?php 
  if(@$_GET['acao'] == 'aula'){
    $num_aula = $_GET['aula'];
    $id_curso = $_GET['id'];

     $query_aulas_modal = "select * from aulas where curso = '$id_curso' and num_aula = '$num_aula'";

            $result_aulas_modal = mysqli_query($conexao, $query_aulas_modal);

            $res_aulas_modal = mysqli_fetch_array($result_aulas_modal);
              
              $nome_aula_modal = $res_aulas_modal["nome"];
              $link_aula_modal = $res_aulas_modal["link"];
             

?>
  
<!-- Modal Aula -->
      <div id="modalAula" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
         <!-- Modal content-->
          <div class="modal-content">
            <form method="POST" action="">
              <div class="modal-header">
              
                <h5 class="modal-title"><small>Aula <?php echo $num_aula; ?> - <?php echo $nome_aula_modal; ?></small></h5>
                <button type="submit" class="close" name="fecharModal">&times;</button>
              </form>
            </div>
            
            <div class="modal-body">
             

              <iframe width="760" height="500" src="<?php echo $link_aula_modal; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
               
             
            </div>
                   
            
          </div>
        </div>
      </div>    


  
 
<?php
} 

?>


<?php 

      if(isset($_POST['fecharModal'])){
       
     
      echo "<script language='javascript'>window.location='curso.php?$nome_sem_espaco&id=$id'; </script>";

}

       ?>


   <script> $("#modalAula").modal("show"); </script> 