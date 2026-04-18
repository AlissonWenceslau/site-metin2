<?php
session_start();
require './utils/utils.php';
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="../assets/favicon.ico">  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Início</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="download.php">Download</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ranking.php">Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="rules.php">Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="status.php">Status</a>
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
        avatar($_SESSION['user'], $avatarBackgroundColor, '../index.php');
        ?>
      </div>
    </div>
  </nav>
  <main class="d-flex justify-content-center">
    <div class="w-75">
      <table class="table">
        <thead class="thead-dark">
          <h2 class="text text-primary">Requisitos Recomendados</h2>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Sistema Operacional</th>
            <td>Windows 10+</td>
          </tr>
          <tr>
            <th scope="row">Processador</th>
            <td>Intel Core I5</td>
          </tr>
          <tr>
          <tr>
            <th scope="row">Memória RAM</th>
            <td>RAM 4GB</td>
          </tr>
          <tr>
            <th scope="row">Placa de Vídeo</th>
            <td>Geforce GTX 1060 </td>
          </tr>
          <tr>
          <tr>
            <th scope="row">DirectX</th>
            <td>Directx 9.0c ou mais recente</td>
          </tr>
          <tr>
            <th scope="row">Disco Rígido</th>
            <td>8 GB de espaço livre</td>
          </tr>
          <tr>
          <tr>
            <th scope="row">Internet</th>
            <td>Banda Larga</td>
          </tr>
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        <a class="bi bi-cloud-arrow-down-fill btn btn-primary w-100 mt-2 mb-2" href="#LinkAqui" role="button">
          Fazer Download
        </a>
      </div>
    </div>
  </main>
  <footer id="sticky-footer" class="flex-shrink-0 py-3 bg-dark text-white-50">
    <div class="container text-center">
      <small>Todos os direitos reservados! Copyright &copy; <?php echo date("Y"); ?></small>
    </div>
  </footer>
</html>