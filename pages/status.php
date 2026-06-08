<?php
session_start();
require './utils/utils.php';
require '../connection/conn.php'; // Presume que este arquivo define: $servername, $username, $password, $dbaccount

$mysql_host = $servername;
$mysql_port = 3306;         // Porta padrão do MySQL
$timeout = 2;            // Tempo limite da verificação em segundos

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/style.css">
  <title>Metin2</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="../index.php" class="navbar-brand"><img src="../assets/metin2.png" class="img-fluid ms-1" alt="metin2"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
      aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
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
            <a class="nav-link" href="rules.php"><i class="bi bi-shield-shaded me-2"></i>Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="status.php"><i class="bi bi-info-circle"></i>Status</a>
          </li>
        </ul>
      </div>
      <div class="logar">
        <ul class="navbar-nav align-items-center pe-3 pe-md-4">
          <li class="nav-item">
            <?php if (!$_SESSION['user']): ?>
              <a class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold text-uppercase d-inline-flex align-items-center gap-2"
                href="./login.php" style="letter-spacing: 0.5px; font-size: 0.85rem; transition: all 0.2s ease;">
                <i class="bi bi-box-arrow-in-right fs-5"></i>
                <span>Entrar</span>
              </a>
            <?php endif; ?>
          </li>
        </ul>
        <?php
        avatar($_SESSION['user'], $avatarBackgroundColor, 'logout.php', './change_password.php');
        ?>
      </div>
    </div>
  </nav>
  <main>
    <div class="content d-flex align-items-center mt-5 mb-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8">

            <div class="text-center mb-5">
              <h2 class="h3 text-primary text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">
                <i class="bi bi-activity me-2"></i>Status do Sistema
              </h2>
              <p class="text-white-50 small">Acompanhe em tempo real a integridade e disponibilidade dos serviços do
                jogo.</p>
            </div>

            <div class="row g-4 justify-content-center">

              <div class="col-12 col-sm-6">
                <div class="card bg-dark text-light border-secondary h-100 shadow-sm transition-hover">
                  <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <div
                        class="bg-secondary bg-opacity-10 p-3 rounded border border-secondary me-3 text-primary fs-4">
                        <i class="bi bi-shield-lock-fill"></i>
                      </div>
                      <div>
                        <h4 class="h6 mb-1 text-white text-uppercase fw-bold" style="letter-spacing: 0.5px;">Serviço de
                          Login</h4>
                        <small class="text-white-50">Autenticação de contas</small>
                      </div>
                    </div>

                    <div class="text-end">
                      <?php if ($conn): ?>
                        <div class="d-flex align-items-center gap-2">
                          <span class="status-pulse bg-success"></span>
                          <span
                            class="badge bg-success bg-opacity-25 border border-success text-success px-3 py-2 fw-bold"
                            style="font-size: 0.8rem;">ONLINE</span>
                        </div>
                      <?php else: ?>
                        <div class="d-flex align-items-center gap-2">
                          <span class="status-pulse bg-danger animate-none"></span>
                          <span class="badge bg-danger bg-opacity-25 border border-danger text-danger px-3 py-2 fw-bold"
                            style="font-size: 0.8rem;">OFFLINE</span>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6">
                <div class="card bg-dark text-light border-secondary h-100 shadow-sm transition-hover">
                  <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <div
                        class="bg-secondary bg-opacity-10 p-3 rounded border border-secondary me-3 text-primary fs-4">
                        <i class="bi bi-controller"></i>
                      </div>
                      <div>
                        <h4 class="h6 mb-1 text-white text-uppercase fw-bold" style="letter-spacing: 0.5px;">Servidor -
                          CH 1</h4>
                        <small class="text-white-50">Canal de Jogo Padrão</small>
                      </div>
                    </div>

                    <div class="text-end">
                      <?php if ($conn): // Usando a mesma variável apenas para espelhar o comportamento ?>
                        <div class="d-flex align-items-center gap-2">
                          <span class="status-pulse bg-success"></span>
                          <span
                            class="badge bg-success bg-opacity-25 border border-success text-success px-3 py-2 fw-bold"
                            style="font-size: 0.8rem;">ONLINE</span>
                        </div>
                      <?php else: ?>
                        <div class="d-flex align-items-center gap-2">
                          <span class="status-pulse bg-danger animate-none"></span>
                          <span class="badge bg-danger bg-opacity-25 border border-danger text-danger px-3 py-2 fw-bold"
                            style="font-size: 0.8rem;">OFFLINE</span>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

            </div>

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
      <a href="<?= $social['youtube']?>" target="_blank"><i class="bi bi-youtube"></i></a>
      <a href="<?= $social['instagram'] ?>" target="_blank"><i class="bi bi-instagram"></i></a>
    </div>
  </footer>
  <script src="../script/dynamic-icons.js"></script>
</body>

</html>