<?php
    include_once('../conexao.php');
    session_start();
    include_once('../verificar_autenticacao.php');
?>

<?php

  if($_SESSION['nivel'] != 'Aluno' && $_SESSION['nivel'] != 'Administrador'){

    header('Location: ../login.php');
    exit();
  }


?>


<html>
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>




<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- HTML5Shiv -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->

    <!-- Estilo customizado -->
    <link rel="stylesheet" type="text/css" href="../css/estilo.css">
    <link rel="stylesheet" type="text/css" href="../css/estilo2.css">
    <link rel="stylesheet" type="text/css" href="../css/cards.css">

    <title>ACS CURSOS</title>

    <link rel="icon" href="../imagens/favicon.png">
  </head>
  <body>

    <header><!-- inicio cabecalho -->
      
      <nav class = "navbar navbar-expand-md navbar-light bg-dark fixed-top navbar-transparente">
        <div class="container">
           <a href="../index.php" class="navbar-brand" target="_blank">
              <img src="../imagens/EEEE.png" width="90">
           </a>

           <button class="navbar-toggler" data-toggle="collapse" data-target="#nav-principal">
            <i class = "fas fa-bars text-white"></i>
           </button>

          <div class="collapse navbar-collapse" id="nav-principal">
             <ul class="navbar-nav ml-auto nav-flex-icons">

               <li class="nav-item dropdown mr-3">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <i class="text-light fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-default"
                      aria-labelledby="navbarDropdownMenuLink-333">
                      <a class="dropdown-item" href="../logout.php">SAIR</a>


                      <? if($_SESSION['nivel'] == 'Administrador'){ ?>

                        <a class="dropdown-item" href="../painel_admin/painel_admin.php">PAINEL DOS ADMINISTRADORES</a>
                        <a class="dropdown-item" href="#">PAINEL DOS PROFESSORES</a>

    
                      <? } ?>



                      
                    </div>
                </li>

                <?php 
  
                  $cpf = $_SESSION['cpf'];

                  $query = "select * from alunos where cpf = '$cpf' ";
                  $result = mysqli_query($conexao, $query);

                  while($res = mysqli_fetch_array($result)){
                        $nome = $res["nome"];
                        $foto = $res["imagem"];
                                          
                ?>

                <li class="nav-item avatar mt-1 mr-1">
                      <a class="nav-link p-0" href="#">
                        <img src="../imagens/perfil/<? echo $foto; ?>" class="rounded-circle z-depth-0"
                          alt="avatar image" height="35">
                      </a>

                </li>
                  <li class="nav-item avatar mt-2"></li>
                  <span class="py-2 "><a class="text-light" href="painel_aluno.php?acao=perfil&cpf=<?php echo $_SESSION['cpf']; ?> "><? echo $nome  ?> </span></a>
                  <li class="nav-item avatar"></li>


                <? } ?>

           
              </ul>
          </div>
        </div>
      </nav>


           

    </header><!-- fim cabecalho -->

<div class="container_admin">

  <div class="row">

    <div class="col-lg-2 col-md-3 col-sm-12">
      <!-- Sidebar -->
      <div class="bg-light" id="sidebar-wrapper">
        
        <div class="list-group list-group-flush">

           <span href="#" class=" list-group-item ativo">Painel Aluno</span>
          
          <a href="painel_aluno.php?acao=perfil&cpf=<?php echo $_SESSION['cpf']; ?>" class="list-group-item list-group-item-action bg-light"><i class="fas fa-user-friends mr-1"></i>Editar Perfil</a>
          <a href="painel_aluno.php?acao=cursos" class="list-group-item list-group-item-action bg-light"><i class="fas fa-book-reader mr-1"></i>Curso</a>
          <a href="#" class="list-group-item list-group-item-action bg-light"><i class="fas fa-sitemap mr-1"></i>Categorias</a>
          <a href="#" class="list-group-item list-group-item-action bg-light"><i class="fas fa-sitemap mr-1"></i>Desempenho</a>
          <a href="#" class="list-group-item list-group-item-action bg-light"><i class="fas fa-sitemap mr-1"></i>Profile</a>
          <a href="#" class="list-group-item list-group-item-action bg-light"><i class="fas fa-sitemap mr-1"></i>Status</a>
        </div>
      </div>
    </div>

    <div class="col-lg-10 col-md-9 col-sm-12">

      <?php

        if(@$_GET['acao'] == 'perfil'){
          include_once "perfil.php";
        }else if(@$_GET['acao'] == 'cursos'or isset($_GET['txtpesquisarCursos']) ){
          include_once "cursos.php";
        }else{

          include_once "home.php";
        }

      ?>
      
    </div>
  </div>
</div>



<!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
   
</body>


</html>
