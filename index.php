<?php  
  include_once "cabecalho.php";
  include_once("conexao.php");
?>


    <!-- DEFINIÇÃO DO CARROSEL  -->
    <section id="home" class="d-flex"><!-- Inicio home -------------------------------------------------------------->
      <div class="container align-self-center">
        <div class="row">
          <div class="col-md-12 capa">
            <div id="carousel-spotify" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <h1>Conhecimento para todos</h1>
                  <a href="" class="btn btn-lg btn-custom btn-roxo">
                    Aproveite o ACS CURSOS ONLINE
                  </a>
                  <a href="cursos.php" class="btn btn-lg btn-custom btn-branco">
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
    </section><!-- Fim home --------------------------------------------------------------------------------------->



    <!-- DEFINIÇÃO DOS ÚLTIMOS CURSOS APROVADOS------------------------------------------------------------------------  -->
    <section id="servicos" class="caixa">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center mb-3">
            <h2 class="section-heading text-uppercase"> Últimos Cursos</h2>
            <h4 class="section-subheading text-muted"><a class="text-muted" href="cursos.php"> Veja a lista completa</a></h4>
          </div>
        </div>
        <div class="row">
          <?php 
            //VERIFICA SE FOI PESQUISADO O NOME DO CURSO
            if(isset($_GET['nome']) and $_GET['nome'] != ''){
              $nome = '%' .$_GET['nome'] . '%';
              $query = "select * from cursos where status = 'Aprovado' and ( nome LIKE '$nome' or desc_rapida LIKE '$nome') order by id desc limit 6";
            }else{
              $query = "select * from cursos where status = 'Aprovado' order by id desc limit 6";
            }
            //conexão com o banco para preenchimento dos dados 
            $result = mysqli_query($conexao, $query);
            while($res = mysqli_fetch_array($result)){//-------------------------------------------------------------
              $nome = $res["nome"];
              $desc_rapida = $res["desc_rapida"];
              $imagem = $res["imagem"];  
              $id = $res["id"];
              $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
              $nome_sem_espaco = preg_replace('/[ -]+/' , '-' , $nome_novo);
          ?>
          <div class="col-md-4 col-sm-6 cursos-item text-center">
            <a class="cursos-link" href="curso.php?curso=<?php echo $nome_sem_espaco; ?>&id=<?php echo $id; ?>">
              <img class="img-fluid" src="imagens/cursos/<?php echo $imagem; ?>" width="250" alt="">
            </a>
            <div class="cursos-caption">
              <h4 class="text-center"><?php echo $nome; ?></h4>
              <p class="text-dark text-center"><?php echo $desc_rapida; ?></p>
            </div>
          </div>
            <? } ?><!-- FECHAMENTO WHILE-------------------------------------------------------------------------------->
        </div>
      </div>
    </section><!-- ------------------------------------------------------------------------------------------------  -->


    <!-- DEFINIÇÃO DE QUEM SOMOS  INSERÇÃO DA IMAGEM QUE SOME QUANDO FICA MOBILE ------------------------------------ -->
    <section id="recursos" class="caixa">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center py-4">
            <h2 class="section-heading text-uppercase"> QUEM SOMOS ?</h2>
            <h4 class="section-subheading"> Conheça o ACS CURSOS ONLINE</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 text-center">
            <p class="py-4 text-light"> Plataforma de cursos online , que visa a portabilidade, facilidade, acessibilidade de forma a garantir conteúdos de qualidade para seu dia a dia, onde você poderá estudar quando e onde quiser, com preços acessíveis e aulas didáticas.</p>
            <h4 class="text-uppercase py-4"> Sobre o autor</h4>
            <div class="row ">
                <div class="col-md-4 text-center ">
                  <!--<img class="mx-auto myself " width="160" height="190" src="imagens/eumesmo3.png" alt="">
                  <h4> Alifi Cleiton</h4>
                  <p class="text-light text-center">Cientista da Computação</p>
                  <ul class="list-inline social-buttons">
                    <li class="list-inline-item">
                      <a href="#">
                        <i class="fab fa-youtube bg-light"></i>
                      </a>
                    </li>
                    <li class="list-inline-item bg-light">
                      <a href="#">
                        <i class="fab fa-facebook"></i>
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="#">
                        <i class="fab fa-instagram bg-light"></i>
                      </a>
                    </li>-->
                    <ul id="album-fotos">
                      <li id="foto01">
                        <span>
                          <p><b>Alifi Cleiton</b></br>
                          Cientista da Computação</br>
                          <a href="#">
                            <i class="fab fa-youtube bg-light"></i>
                          </a>
                          <a href="#">
                            <i class="fab fa-facebook"></i>
                          </a>
                          <a href="#">
                            <i class="fab fa-instagram bg-light"></i>
                          </a>
                            
                          </p>
                        </span>
                      </li>
                    </ul>

                </div>
                <div class="col-md-8 py-4 ">
                  <p >Sou formado em ciência da computação na Universidade Federal de Itajubá, atuo há 2 anos na área de tecnologia de informação, tenho experiência em desenvolvimento Full Stack, sou professor e ministro aulas de tecnologia.</p>
                </div>
            </div>
          </div>
          <div class="col-md-6 ">
            
            <div class="card ml-auto">
              <div class="face front text-center">
                <p class="text-dark"><b>"Investir</br> em conhecimento</br> rende sempre</br>  os melhores </br> juros"</b></p>
              </div>
              <div class ="face back text-center">

                <p ><b>"Conhecimento</br> gera conhecimento"</br></b> </p>
                <!--<img  class="d-none d-md-block " src="imagens/cidadecircular2.png" width="600" alt="">-->
              </div>
            </div>

          </div>
        </div>
      </div>
    </section><!-- __---------------------------------------------------- ------------------------------------ -->

    
    
  
<!-- DEFINIÇÃO DE QUEM SOMOS  INSERÇÃO DA IMAGEM QUE SOME QUANDO FICA MOBILE ------------------------------------ 
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
    </section>--------------------------------------------------------------------------------------------------->

 <section id="servicos" class="caixa">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <h2 class= "text-dark">NOSSOS IDEAIS</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 text-center">
            <span class="fa-stack fa-4x">
              <i class="fas fa-circle fa-stack-2x text-warning"></i>
              <i class="fas fa-lock fa-stack-1x fa-inverse"></i>
            </span>
            <h4 class="text-dark">Segurança</h4>
            <p class="text-muted"> Todo o site contém um sistema de segurança onde todo acesso é único e garantia total de devolução do dinheiro.
          </div>
          <div class="col-md-4 text-center">
             <span class="fa-stack fa-4x">
              <i class="fas fa-circle fa-stack-2x text-success"></i>
              <i class="fas fa-check-circle fa-stack-1x fa-inverse"></i>
            </span>
            <h4 class="text-dark">Qualidade</h4>
            <p class="text-muted"> Desenvolvemos aulas didáticas com a mais alta qualidade de ensino.
          </div>
          <div class="col-md-4 text-center ">
             <span class="fa-stack fa-4x">
              <i class="fas fa-circle fa-stack-2x text-danger"></i>
              <i class="fas fa-play-circle fa-stack-1x fa-inverse"></i>
            </span>
            <h4 class="text-dark">Acesso Ilimitado</h4>
            <p class="text-muted"> Veja quando quiser. O conteúdo do curso é seu para sempre!
          </div>
        </div>
        
      </div>
</section>



    <!-- Contatos --------------------------------------------------------------------------------------------------->
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
  </section><!----------------------------------------------------------------------------------------------------->


<? include_once "rodape.php" ?>