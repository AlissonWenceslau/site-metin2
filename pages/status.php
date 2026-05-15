<?php
session_start();
require './utils/utils.php';
require '../connection/conn.php'; // Presume que este arquivo define: $servername, $username, $password, $dbaccount

$mysql_host  = $servername;
$mysql_port  = 3306;         // Porta padrão do MySQL
$timeout     = 2;            // Tempo limite da verificação em segundos

// Verifica se a porta do MySQL está aberta
function isMysqlOnline($host, $port, $timeout = 2)
{
  $socket = @fsockopen($host, $port, $errno, $errstr, $timeout);
  if ($socket) {
    fclose($socket);
    return true;
  }
  return false;
}

$connect = null;

if (isMysqlOnline($mysql_host, $mysql_port, $timeout)) {
  // Só tenta conectar se o MySQL estiver escutando
  $conn = @new mysqli($servername, $username, $password, $dbaccount);

  if ($conn->connect_error) {
    // Erro ao conectar (usuário/senha errados, banco inexistente, etc)
    error_log("Erro de conexão com MySQL: " . $conn->connect_error);
    $conn = null;
  }
} else {
  // MySQL está offline ou inacessível
  error_log("MySQL está offline ou a porta $mysql_port está fechada.");
}
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
            <a class="nav-link" href="rules.php"><i class="bi bi-book"></i>Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="status.php"><i class="bi bi-info-circle"></i>Status</a>
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
    <div class="content d-flex ">
      <div class="container">
        <div class="col-lg-6 offset-lg-3">
          <div class="container mt-5">
            <h2 class="text text-primary">Status do Sistema</h2>
            <table class="table table-bordered table-striped mt-3 text-center">
              <thead class="table-dark">
                <tr>
                  <th>Serviço</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Login</td>
                  <td>
                    <?php
                    if ($conn) {
                      echo '<span class="badge bg-success">ONLINE</span>';
                    } else {
                      echo '<span class="badge bg-danger">OFFLINE</span>';
                    }
                    ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
  </div>
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