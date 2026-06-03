<?php
session_start();
require '../../connection/conn.php';
require '../utils/validation.php';
require '../utils/utils.php';

if (!isset($_SESSION['user'])) {
  header("Location: ../login.php");
  exit;
} else if ($_SESSION['web'] == 0) {
  header("Location: ../logout.php");
  exit;
}

$conn = new mysqli($servername, $username, $password, $dbaccount);

if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $login = trim($_POST['account']);
  $addCash = (int)$_POST['addCash'];

  $errors = [];

  if ($addCash <= 0) {
    $errors[] = 'O valor de Cash deve ser maior que zero.';
  }

  // Verifica se a conta existe
  $stmt = $conn->prepare("SELECT login FROM account WHERE login = ?");
  $stmt->bind_param("s", $login);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    $errors[] = 'Essa conta não existe.';
  }
  $stmt->close();

  if (count($errors) > 0) {
    $_SESSION['errors'] = $errors;
    header('Location: add_cash.php');
    exit();
  }

  $stmt = $conn->prepare("UPDATE account SET cash = cash + ? WHERE login = ?");
  $stmt->bind_param("is", $addCash, $login);
  
  if ($stmt->execute()) {
    $_SESSION['add_cash'] = 'Cash adicionado com sucesso: ' . $addCash;
    
    if (isset($_SESSION['cash']) && strtolower($login) === strtolower($_SESSION['user'])) {
      $_SESSION['cash'] += $addCash;
    }
    
    header('Location: add_cash.php');
    exit();
  } else {
    $_SESSION['errors'] = ['Erro interno ao adicionar o cash no banco de dados.'];
    header('Location: add_cash.php');
    exit();
  }
}

$conn->close();
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../../css/style.css">
  <title>Metin2</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="../../index.php" class="navbar-brand"><img src="../../assets/metin2.png" class="img-fluid" alt="metin2"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse responsive" id="navbarText">
      <div class="links-navegator">
        <ul class="navbar-nav" id="mainNav">
          <li class="nav-item">
            <a class="nav-link active" href="../../index.php"><i class="bi bi-house-door"></i>Início</a>
          </li>
          <?php
            if (!$_SESSION['user']) {          
              echo '<li class="nav-item">';
              echo '<a class="nav-link" href="register.php"><i class="bi bi-person-plus"></i>Cadastrar</a>';
              echo '</li>';
            }
          ?>             
          <li class="nav-item">
            <a class="nav-link" href="../download.php"><i class="bi bi-cloud-arrow-down"></i>Download</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../ranking.php"><i class="bi bi-trophy"></i>Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../rules.php"><i class="bi bi-shield-shaded me-2"></i>Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../status.php"><i class="bi bi-info-circle"></i>Status</a>
          </li>
        </ul>
      </div>
      <div class="logar">
        <ul class="navbar-nav align-items-center pe-3 pe-md-4">
          <li class="nav-item">
            <?php if (!$_SESSION['user']): ?>
              <a class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold text-uppercase d-inline-flex align-items-center gap-2" 
                href="./pages/login.php" 
                style="letter-spacing: 0.5px; font-size: 0.85rem; transition: all 0.2s ease;">
                <i class="bi bi-box-arrow-in-right fs-5"></i>
                <span>Entrar</span>
              </a>
            <?php endif; ?>
          </li>
        </ul>
        <?php
        avatar($_SESSION['user'], $avatarBackgroundColor, '../logout.php', './change_password.php');
        ?>
      </div>
    </div>
  </nav>
  <main>
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
  <?php if (isset($_SESSION['add_cash'])): ?>
    <div id="toastCashSucesso" class="toast align-items-center text-white bg-success border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
      <div class="d-flex">
        <div class="toast-body fw-semibold">
          <i class="bi bi-person-fill-add me-2 fs-5"></i> <?= $_SESSION['add_cash']; ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
    <?php unset($_SESSION['add_cash']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['errors'])): ?>
    <?php foreach ($_SESSION['errors'] as $index => $erro): ?>
      <div id="toastCashErro_<?= $index; ?>" class="toast align-items-center text-white bg-danger border-0 shadow mb-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="7000">
        <div class="d-flex">
          <div class="toast-body fw-semibold">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $erro; ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
  <?php endif; ?>
</div>

<div class="content d-flex justify-content-center mt-4">
  <div class="card bg-dark text-light border-secondary w-100 p-4 shadow-lg rounded" style="max-width: 500px;">
    
    <div class="text-center mb-4">
      <h3 class="fw-bold text-primary text-uppercase tracking-wide mb-1" style="font-size: 1.5rem; letter-spacing: 1px;">
        <i class="bi bi-cash-coin me-2"></i>Adicionar Cash
      </h3>
      <p class="text-secondary small mb-0">Gerenciamento e injeção de saldo de moedas</p>
    </div>

    <form class="needs-validation" method="post" action="" novalidate>
      
      <div class="mb-3">
        <label Lothar for="account" class="form-label text-secondary-light small fw-semibold">
          <i class="bi bi-person-vcard me-1 text-primary"></i>Login da Conta
        </label>
        <div class="input-group has-validation">
          <input type="text" class="form-control bg-secondary bg-opacity-10 text-light border-secondary" id="account" name="account" placeholder="Ex: player_metin2" required>
          <div class="invalid-feedback">
            Campo obrigatório! Por favor, informe a conta destino.
          </div>
        </div>
      </div>

      <div class="mb-4">
        <label for="addCash" class="form-label text-secondary-light small fw-semibold">
          <i class="bi bi-plus-circle me-1 text-primary"></i>Quantidade de Coins
        </label>
        <div class="input-group has-validation">
          <input type="number" class="form-control bg-secondary bg-opacity-10 text-light border-secondary" id="addCash" name="addCash" min="1" placeholder="Ex: 1000" required>
          <div class="invalid-feedback">
            Campo obrigatório! Insira um valor maior que zero.
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary py-2 w-100 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2" style="letter-spacing: 0.5px;">
        <i class="bi bi-check2-circle fs-5"></i> Confirmar Injeção
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
  <script src="../../script/form.validation.js"></script>
  <script src="../../script/toast-message.js"></script>
</body>

</html>