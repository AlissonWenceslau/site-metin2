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
        <ul class="navbar-nav" id="mainNav">
          <li class="nav-item">
            <a class="nav-link" href="../index.php"><i class="bi bi-house-door"></i>Início</a>
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
            <a class="nav-link active" href="rules.php"><i class="bi bi-book"></i>Regras</a>
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
    <div class="content d-flex align-items-center">
      <div class="container">
        <div class="col-lg-6 offset-lg-3">
          <h2 class="text text-primary">Regras do Servidor </h2>
          <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
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
  <script src="../script/dynamic-icons.js"></script>  
</body>

</html>