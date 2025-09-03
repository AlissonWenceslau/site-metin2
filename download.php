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
  <div class="content">
    <div class="container">
      <div class="col-lg-6 offset-lg-3">
        <table class="table">
          <thead class="thead-dark">
            <h2 class="text text-primary">Requisitos Recomendados</h2>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Sistema Operacional</th>
              <td>Windows 8.1 e 10</td>
            </tr>
            <tr>
              <th scope="row">Processador</th>
              <td>P4 3Ghz ou Athlon 3000+</td>
            </tr>
            <tr>
            <tr>
              <th scope="row">Memória RAM</th>
              <td>RAM 1GB</td>
            </tr>
            <tr>
              <th scope="row">Placa de Vídeo</th>
              <td>Geforce 6600/Radeon X600</td>
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
          <a class="btn btn-primary w-100 mt-2 mb-2" href="#LinkAqui" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-download" viewBox="0 0 16 16">
              <path d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383" />
              <path d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z" />
            </svg>
            Fazer Download
          </a>
        </div>
      </div>
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