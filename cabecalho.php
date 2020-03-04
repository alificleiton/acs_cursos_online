<html>
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- HTML5Shiv -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->

    <!-- Estilo customizado -->
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" type="text/css" href="css/estilo2.css">
    <link rel="stylesheet" type="text/css" href="css/cards.css">
   

    <title>ACS CURSOS</title>

    <link rel="icon" href="imagens/favicon.png">
  </head>
  <body>

    <header><!-- inicio cabecalho -->
      
      <nav class = "navbar navbar-expand-md navbar-light bg-dark fixed-top navbar-transparente">
        <div class="container">
           <a href="index.php" class="navbar-brand" >
              <img src="imagens/EEEE.png" width="200">
           </a>


           <button class="navbar-toggler" data-toggle="collapse" data-target="#nav-principal">
            <i class = "fas fa-bars text-white"></i>
           </button>

           <div class="collapse navbar-collapse" id="nav-principal">
              <form class="form-inline ml-5 my-2 my-lg-0">
                <input class="form-control ml-2 mr-sm-2" name="txtpesquisarCursos" type="search" placeholder="Pesquisar" aria-label="Pesquisar"><button class="btn btn-outline-light my-2 my-sm-0 botao-buscar" name="buttonPesquisar" type="submit">
                <i class="fas fa-search lupa-buscar"></i></button>

              </form>
              <ul class="navbar-nav ml-auto">

                  <li class="nav-item">
                    <a href="index.php#home" class="nav-link">HOME</a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php#servicos" class="nav-link">QUEM SOMOS</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle " data-toggle="dropdown" id="navDrop">CURSOS</a>
                    <div class="dropdown-menu ">
                      <a class="dropdown-item" href="cursos.php">EXCEL</a>
                      <a class="dropdown-item" href="cursos.php">INGLÊS</a>
                    </div>
                  </li>

                  <li class="nav-item divisor">
                    
                  </li>

                  <li class="nav-item">
                    <a href="index.php#servicos" class="nav-link">INSCREVER-SE</a>
                  </li>


                  <?php

                    session_start();
                    if(!@$_SESSION['usuario']){

                  ?>

                    <li class="nav-item">
                      <a href="login.php" class="nav-link">ENTRAR</a>
                    </li>
                     
                   <? }else{ ?>

                    <li class="nav-item">
                      <a href="logout.php" class="nav-link">SAIR</a>
                    </li>

                   <? } ?>


                  ?>


                  
              </ul>
           </div>
        </div>
      </nav>

    </header><!-- fim cabecalho -->

</body>
</html>


<?php

  if(isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarCursos'] != ''){

    $nome = '%' .$_GET['txtpesquisarCursos'] . '%';

    echo "<script language='javascript'>window.location='cursos.php?nome=$nome'; </script>";

  }


?>