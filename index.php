<?php
session_start();
require './pages/utils/utils.php'
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="./assets/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./css/style.css">
  <title>Metin2</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="index.php" class="navbar-brand"><img src="./assets/metin2.png" class="img-fluid ms-1" alt="metin2"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse responsive" id="navbarText">
      <div class="links-navegator">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="index.php"><i class="bi bi-house-door-fill"></i>Início</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pages/download.php"><i class="bi bi-cloud-arrow-down-fill"></i>Download</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pages/ranking.php"><i class="bi bi-trophy-fill"></i>Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pages/rules.php"><i class="bi bi-book-fill"></i>Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pages/status.php"><i class="bi bi-info-circle-fill"></i>Status</a>
          </li>
        </ul>
      </div>
      <div class="logar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <?php
            if (!$_SESSION['user']) {
              echo '<a class="btn btn-primary me-2" href="./pages/login.php">';
              echo '<i class="bi bi-box-arrow-in-right me-1"></i>';
              echo 'Entrar';
              echo '</a>';
            }
            ?>
          </li>
        </ul>
        <?php
        avatar($_SESSION['user'], $avatarBackgroundColor, 'index.php');
        ?>
      </div>
    </div>
  </nav>
  <main>
    <div class="d-flex justify-content-center">
      <div class="container">
        <?php
        if ($_SESSION['user']) {
          require './pages/includes/panel.php';
        } else {
          require './pages/includes/register.php';
        }
        ?>
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
          <a href="#"><i class="bi bi-youtube"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
      </div>
  </footer>
</body>

</html>