<?php
session_start();
require './utils/utils.php'
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="../assets/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/style.css">
  <title>Metin2</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="../index.php" class="navbar-brand"><img src="../assets/metin2.png" class="img-fluid ms-1" alt="metin2"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse responsive" id="navbarText">
      <div class="links-navegator">
        <ul class="navbar-nav">
          <li class="nav-item" id="mainNav">
            <a class="nav-link active" href="../index.php"><i class="bi bi-house-door"></i>Início</a>
          </li>
          <?php
            if (!$_SESSION['user']) {          
              echo '<li class="nav-item">';
              echo '<a class="nav-link" href="register.php"><i class="bi bi-person-plus"></i>Cadastrar</a>';
              echo '</li>';
            }
          ?>             
          <li class="nav-item">
            <a class="nav-link" href="download.php"><i class="bi bi-cloud-arrow-down"></i>Download</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ranking.php"><i class="bi bi-trophy"></i>Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="rules.php"><i class="bi bi-book"></i>Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="status.php"><i class="bi bi-info-circle"></i>Status</a>
          </li>
        </ul>
      </div>
      <div class="logar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <?php
            if (!$_SESSION['user']) {
              echo '<a class="btn btn-primary me-2" href="login.php">';
              echo '<i class="bi bi-box-arrow-in-right me-1"></i>';
              echo 'Entrar';
              echo '</a>';
            }
            ?>
          </li>
        </ul>
        <?php
        avatar($_SESSION['user'], $avatarBackgroundColor, 'logout.php');
        ?>
      </div>
    </div>
  </nav>
  <main>
    <div class="content d-flex justify-content-center align-items-sm-start mt-5">
      <div class="card-login border border-dark p-5 m-2 w-100 rounded">
        <h3 class="text text-primary text-center"><i class="bi bi-box-arrow-in-right me-1"></i>Faça o seu login</h3>
        <?php
        session_start();
        // Verifica se há erros na sessão e exibe-os
        if (isset($_SESSION['error'])) {
          echo "<div class='alert alert-danger' id='alert' role='alert'>";
          echo '<i class="bi bi bi-person-fill-x me-1"></i>';
          echo $_SESSION['error'];
          echo "</div>";
          // Limpa as mensagens de erro para evitar que apareçam novamente
          unset($_SESSION['error']);
        }
        ?>
        <form class="needs-validation" method="post" action="./validation/validate_login.php" novalidate>
          <div class="form-group">
            <label for="login"><i class="bi bi-person-vcard me-1"></i>Login</label>
            <input type="text" class="form-control" id="login" name="login" required>
            <div class="invalid-feedback">
              Campo obrigatório!
            </div>
          </div>
          <div class="form-group">
            <label for="password"><i class="bi bi-lock me-1"></i>Senha</label>
            <input type="password" class="form-control campo-senha" id="password" name="password" required>
            <div class="invalid-feedback">
              Campo obrigatório!
            </div>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="showPasword">
            <label class="form-check-label" for="showPasword">
              Mostrar senha
            </label>
          </div>
          <button type="submit" id="btnEntrar" class="btn btn-primary mt-2 w-100">
            <i class="bi bi-box-arrow-in-right"></i>
            Entrar
            <span id="spinner" class="spinner-border spinner-border-sm visually-hidden" role="status" aria-hidden="true"></span>
          </button>
        </form>
      </div>
    </div>
  </main>
  <footer class="rodape">   
      <!-- Direitos Autorais no meio -->
      <div class="direitos">
        &copy; <?php echo date("Y"); ?> Todos os direitos reservados!
      </div>
      
      <!-- Redes Sociais na direita -->
      <div class="redes-sociais">
          <a href="#" target="_blank"><i class="bi bi-youtube"></i></a>
          <a href="#" target="_blank"><i class="bi bi-instagram"></i></a>
      </div>
  </footer>
  <script src="../script/form.validation.js"></script>
  <script src="../script/dynamic-icons.js"></script>  
</body>

</html>