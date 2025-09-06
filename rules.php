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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex justify-content-between">
    <div class="d-flex">
      <div class="logo">
        <a href="index.php" class="navbar-brand"><img src="./assets/metin2.png" class="img-fluid" alt="metin2"></a>
      </div>
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
          <a class="nav-link active" href="rules.php">Regras</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="status.php">Status</a>
        </li>
      </ul>
    </div>
    <div class="d-flex">
      <ul class="navbar-nav">
        <li class="nav-item">
          <?php
          if (!$_SESSION['user']) {
            echo '<a class="btn btn-primary me-2" href="login.php">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right me-1"     viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>';
            echo 'Entrar';
            echo '</a>';
          }
          ?>
        </li>
      </ul>
      <?php
      if ($_SESSION['user']) {
        echo '<a href="index.php" class="rounded-circle border d-flex justify-content-center align-items-center text-light bg-primary link-offset-2 link-underline link-underline-opacity-0"
        style="width:50px;height:50px"
        alt="Avatar">';
        echo htmlspecialchars(strtoupper($_SESSION['user'])[0]) . '</a>';

        '</a>';
      }
      ?>
    </div>
  </nav>
  <div class="content d-flex align-items-center">
    <div class="container">
      <div class="col-lg-6 offset-lg-3">
        <h2>Regras do Servidor </h2>
        <table class="table table-bordered table-striped">
          <thead class="table-primary text-center">
            <tr>
              <th>#</th>
              <th>Regra</th>
              <th>Descrição</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Uso de Hacks/Bots</td>
              <td>É proibido usar programas externos para ganhar vantagem (auto-farm, speed, etc).</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Comércio por dinheiro real (RMT)</td>
              <td>Vender ou comprar itens/moedas do jogo por dinheiro real é proibido.</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Abuso de bugs</td>
              <td>Explorar falhas no jogo para benefício próprio pode levar a banimento.</td>
            </tr>
            <tr>
              <td>4</td>
              <td>Ofensas e discurso de ódio</td>
              <td>Não é permitido insultar outros jogadores ou usar linguagem ofensiva/preconceituosa.</td>
            </tr>
            <tr>
              <td>5</td>
              <td>Fake de Staff/Admin</td>
              <td>Fingir ser parte da equipe do servidor é terminantemente proibido.</td>
            </tr>
            <tr>
              <td>6</td>
              <td>Spam e flood no chat</td>
              <td>Enviar muitas mensagens repetitivas no chat é proibido.</td>
            </tr>
            <tr>
              <td>7</td>
              <td>KS (Kill Steal)</td>
              <td>Roubar monstros ou pedras que outro jogador está enfrentando é proibido.</td>
            </tr>
            <tr>
              <td>8</td>
              <td>Divulgação de outros servidores</td>
              <td>Falar ou divulgar outros servidores de Metin2 dentro do jogo não é permitido.</td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
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