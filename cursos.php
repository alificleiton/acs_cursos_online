<?php

  include_once "cabecalho.php";
  include_once("conexao.php");

?>

<!-- Área dos Cursos -->
  <section class="bg-light page-section" id="cursos">
    <div class="container">
      <div class="row">
        <div class="py-4 col-lg-12 text-center">
          <h3 class="section-subheading text-muted">Ver a lista completa de cursos</h3>
        </div>
      </div>

      <div class="row">

        <?php 


            if(isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarCursos'] != ''){

              $nome = '%' .$_GET['txtpesquisarCursos'] . '%';

              $query = "select * from cursos where status = 'Aprovado' and nome LIKE '$nome' or desc_rapida LIKE '$nome' order by id desc";

            }else{

              $query = "select * from cursos where status = 'Aprovado' order by id";

            }

            
            $result = mysqli_query($conexao, $query);

            $linha = mysqli_num_rows($result);
            

            if($linha == ''){

              echo "<script language='javascript'>window.alert('Busca não encontrada!'); </script>";
              echo "<script language='javascript'>window.location='cursos.php?'; </script>";

            }else{

            while($res = mysqli_fetch_array($result)){
              $nome = $res["nome"];
              $desc_rapida = $res["desc_rapida"];
              $imagem = $res["imagem"];  
              $valor = $res["valor"]; 
              $id = $res["id"];

              $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

              $nome_sem_espaco = preg_replace('/[ -]+/' , '-' , $nome_novo);
          ?>

        <div class="col-md-3 col-sm-6 cursos-item">
          <a class="cursos-link" href='curso.php?curso=<?php echo $nome_sem_espaco; ?>&id=<?php echo $id; ?>'>
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

      <? } } ?>

        

      </div>


  	</div>
  </section>




<?php

  include_once "rodape.php"

?>