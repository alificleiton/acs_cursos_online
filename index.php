<?php  
  include_once "cabecalho.php";
  include_once("conexao.php");
?>

    <section id="home" class="d-flex"><!-- Inicio home -->
      <div class="container align-self-center">
        <div class="row">
          <div class="col-md-12 capa">
            <div id="carousel-spotify" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <h1>Tecnologia para todos</h1>
                  <a href="" class="btn btn-lg btn-custom btn-roxo">
                    Aproveite o ACS CURSOS ONLINE
                  </a>
                  <a href="" class="btn btn-lg btn-custom btn-branco">
                    Confira nossas aulas
                  </a>
                </div>
                <div class="carousel-item">
                  <h1>As melhores aulas</h1>
                  <a href="" class="btn btn-lg btn-custom btn-branco">
                    <i class=""></i>Estude agora
                  </a>
                </div>
                <a href="#carousel-spotify" class="carousel-control-prev" data-slide="prev">
                  <i class="fas fa-angle-left fa-3x"></i>
                </a>
                <a href="#carousel-spotify" class="carousel-control-next" data-slide="next">
                  <i class="fas fa-angle-right fa-3x"></i>
                </a>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- Fim home -->

<!--
    <section id="servicos" class="caixa">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading text-uppercase"> Formações</h2>
            <h4 class="section-subheading text-muted"> Nossas principais formações</h4>
          </div>
        </div>

          <div class="row">
              <div class="col-md-6 text-center">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-laptop fa-stack-1x text-muted"></i>
                </span>
                <h4 class="text-center text-muted"> EXCEL </h4>
                <p class="text-muted"> Curso completo do básico ao avançado.</p>
              </div>
          
          
            <div class="col-md-6 text-center">
                  <span class="fa-stack fa-4x">
                      <i class="fas fa-book-reader fa-stack-1x text-muted"></i>
                  </span>
                  <h4 class="text-center text-muted" > INGLÊS </h4>
                  <p class="text-muted"> Curso completo do básico ao avançado.</p>
                
            </div>

          </div>

      </div>
    </section>
-->

    <section id="servicos" class="caixa">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading text-uppercase"> Últimos Cursos</h2>
            <h4 class="section-subheading text-muted"><a class="text-muted" href="cursos.php"> Veja a lista completa</a></h4>
          </div>
        </div>
        <div class="row">

          <?php 

            if(isset($_GET['nome']) and $_GET['nome'] != ''){

              $nome = '%' .$_GET['nome'] . '%';

              $query = "select * from cursos where status = 'Aprovado' and ( nome LIKE '$nome' or desc_rapida LIKE '$nome') order by id desc limit 6";

            }else{

              $query = "select * from cursos where status = 'Aprovado' order by id desc limit 6";

            }

            
            $result = mysqli_query($conexao, $query);

            while($res = mysqli_fetch_array($result)){
              $nome = $res["nome"];
              $desc_rapida = $res["desc_rapida"];
              $imagem = $res["imagem"];  
          ?>


              <div class="col-md-4 col-sm-6 cursos-item">
              <a class="cursos-link" href="#">
                <div class="cursos-hover">
                  <div class="cursos-hover-content">
                    <i class="fas fa-plus fa-3x"></i>
                  </div>
                </div>
                <img class="img-fluid" src="imagens/cursos/<?php echo $imagem; ?>" width="350" alt="">
              </a>
              <div class="cursos-caption">
                <h4><?php echo $nome; ?></h4>
                <p class="text-muted"><?php echo $desc_rapida; ?></p>
              </div>
            </div>

          <?php } ?>

        </div>
      </div>
    </section>

    <section id="recursos" class="caixa">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading text-uppercase"> QUEM SOMOS ?</h2>
            <h4 class="section-subheading"> Conheça o ACS Cursos Online</h4>
          </div>
        </div>

          <div class="row">
              <div class="col-md-6 text-center">
                
                <p class="py-4 text-light"> Plataforma de cursos online , que visa a portabilidade, facilidade, acessibilidade de forma a garantir conteúdos de qualidade para seu dia a dia, onde você poderá estudar quando e onde quiser, com preços acessíveis e aulas didáticas.</p>
              </div>
          
          
            <div class="col-md-6 text-center">
                  
                  <p class="text-muted"> IMAGEM.</p>
                
            </div>

          </div>

      </div>
    </section>

    
    
  

    <section id="servicos" class="caixa">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center my-5">
            <h2 class= "display-4"><i class="fa fa-paper-plane text-primary"  aria-hidden="true"></i>Inscreva-se</h2>
          </div>
          
        </div>
       

            <form action=""  method="POST" name="formulario">
              
                <div class="py-3 col-md-6 offset-md-3">
                      <label for="inputNome">Seu nome:</label>
                      <input type="text" class="form-control" id="inputNome" placeholder="Nome">
                </div>

                <div class="py-3 col-md-6 offset-md-3">
                  <label for="inputTelefone">Telefone:</label>
                  <input type="text" class="form-control" id="inputTelefone" placeholder="Telefone">
                </div>

                <div class="py-3 col-md-6 offset-md-3">
                  <label for="inputTelefone">Email:</label>
                  <input type="text" class="form-control" id="inputEmail" placeholder="Email">
                </div>

                <div class="py-3 col-md-6 offset-md-3">
                  <label for="inputTelefone">Confirmar Email:</label>
                  <input type="text" class="form-control" id="inputConfEmail" placeholder="Confirmar Email">
                </div>

                <div class="py-3 col-md-6 offset-md-3">
                  <label for="inputTelefone">Senha:</label>
                  <input type="password" class="form-control" id="inputSenha" placeholder="Senha">
                </div>

                <div class="py-3 col-md-6 offset-md-3">
                  <label for="inputTelefone">Confirmar Senha:</label>
                  <input type="password" class="form-control" id="inputSenha" placeholder="Confirmar Senha">
                </div>

                <div class="py-3 col-md-6 offset-md-3">
                  <button type="submit" class="btn btn primary" >ENVIAR</button>
                </div>

                

             
            </form>
          
      </div>
    </section>


    <!-- Contatos -->
  <section class="page-section" id="contatos">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center py-4">
          <h2 class="section-heading text-uppercase text-light">Contate-nos</h2>
          <h3 class="section-subheading text-light">Em caso de dúvidas preencha abaixo!!</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <form id="contactForm" name="sentMessage" novalidate="novalidate">
            <div class="row">
              <div class="col-md-6 py-4">
                <div class="form-group">
                  <input class="form-control" id="nome" type="text" placeholder="Seu Nome *" required="required" data-validation-required-message="Preencha seu nome.">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <input class="form-control" id="email" type="email" placeholder="Seu Email *" required="required" data-validation-required-message="Preencha seu Email!">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <input class="form-control" id="telefone" type="tel" placeholder="Seu Telefone">
                 
                </div>
              </div>
              <div class="col-md-6 py-4">
                <div class="form-group">
                  <textarea class="form-control" id="mensagem" placeholder="Sua Mensagem *" required="required" data-validation-required-message="Entre com a Mensagem!!"></textarea>
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-lg-12 text-center">
                <div id="success"></div>
                <button id="" class="btn btn-primary btn-xl text-uppercase" type="submit">Enviar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>


<? include_once "rodape.php" ?>