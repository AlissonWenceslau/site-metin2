<?php
session_start();
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="./assets/favicon.ico">
  <title>Metin2</title>
  <link href="./css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="logo">
      <a href="index.php" class="navbar-brand"><img src="./assets/metin2.png" class="img-fluid" alt="metin2"></a>
    </div>
    <div class="container-fluid">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="download.php">Download</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ranking.php">Ranking</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php"><?php if(!$_SESSION['user']){echo 'Entrar';} ?></a>
        </li>
      </ul>
      <?php
      if ($_SESSION['user']) {
        echo '<div class="rounded-circle border d-flex justify-content-center align-items-center text-light bg-primary"
          style="width:50px;height:50px"
          alt="Avatar">';
        echo '<a href="index.php" class="link-offset-2 link-underline link-underline-opacity-0 text-light">' . htmlspecialchars(strtoupper($_SESSION['user'])[0]) . '</a>';

        '</div>';
      }
      ?>
    </div>
  </nav>
  <div class="content d-flex justify-content-center align-items-sm-start">
    <div class="container d-flex justify-content-center mt-5 align-items-sm-start">
      <?php
      if ($_SESSION['user']) {
        include './panel.php';
      } else {
        include './cadastro.php';
      }
      ?>
    </div>
  </div>
  <footer id="sticky-footer" class="flex-shrink-0 py-3 bg-dark text-white-50">
    <div class="container text-center">
      <small>Todos os direitos reservados! Copyright &copy; <?php echo date("Y"); ?></small>
    </div>
  </footer>
  <script src="./script/bootstrap.bundle.min.js"></script>
</body>

</html>