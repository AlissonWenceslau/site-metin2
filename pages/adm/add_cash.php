<?php
session_start();
require '../../connection/conn.php';;
require '../utils/validation.php';
require '../utils/utils.php';

if (!isset($_SESSION['user'])) {
  // Usuário não logado, redireciona para a página de login
  header("Location: ../login.php");
  exit;
} else if ($_SESSION['web'] == 0) {
  header("Location: ../logout.php");
  exit;
}


// Conectar ao banco
$conn = new mysqli($servername, $username, $password, $dbaccount);

if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $login = $_POST['account'];
  $addCash = $_POST['addCash'];

  // Verifica se a senha atual está correta
  $stmt = $conn->prepare("SELECT * FROM account WHERE login = ?");
  $stmt->bind_param("s", $login);
  $stmt->execute();
  $result = $stmt->get_result();

  $errors = [];

  if ($result->num_rows === 0) {
    $errors[] = 'Essa conta  não existe.';
  }

  if (count($errors) > 0) {
    $_SESSION['errors'] = $errors;
    header('Location: add_cash.php');
    exit();
  }

  if ($result->num_rows === 1) {
    // Senha atual correta, atualiza para nova senha
    $stmt = $conn->prepare("UPDATE account SET cash = cash + ? WHERE login = ?");
    $stmt->bind_param("ss", $addCash, $login);
    if ($stmt->execute()) {
      $_SESSION['add_cash'] = 'Cash adicionado com sucesso: ' . $addCash;
    } else {
      echo "Erro ao colocar cash.";
    }
    $stmt->close();
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
            <a class="nav-link" href="../rules.php"><i class="bi bi-book"></i>Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../status.php"><i class="bi bi-info-circle"></i>Status</a>
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
        avatar($_SESSION['user'], $avatarBackgroundColor, '../logout.php');
        ?>
      </div>
    </div>
  </nav>
  <main>
    <div class="content d-flex justify-content-center">
      <div class="d-flex flex-column border p-2 m-2 w-100 rounded">
        <h3 class="text text-primary text-center">Adicionar cash</h3>
        <?php
        if (isset($_SESSION['add_cash'])) {
          echo "<div class='alert alert-success' id='alert' role='alert'>";
          echo '<i class="bi bi-person-fill-add me-1"></i>';
          echo $_SESSION['add_cash'];
          echo "</div>";
        }
        unset($_SESSION['add_cash']);
        if (isset($_SESSION['errors'])) {
          foreach ($_SESSION['errors'] as $erro) {
            echo "<div class='alert alert-warning updated-password-fail alert-dismissible fade show' id='alert' role='alert'>";
            echo '<i class="bi bi-exclamation-triangle-fill me-1"></i>';
            echo $erro;
            echo "</div>";
          }
        }
        unset($_SESSION['errors']);
        ?>
        <form class="needs-validation" method="post" action="" novalidate>
          <label for="actualPassword"><i class="bi bi-person-vcard me-1"></i>Login</label>
          <input type="text" class="form-control campo-senha" id="account" name="account" required>
          <div class="invalid-feedback">
            Campo obrigatório!
          </div>
          <label for="addCash"><i class="bi bi-cash-coin me-1"></i>Quantidade</label>
          <div class="d-flex">
            <input type="number" class="form-control campo-senha" id="addCash" name="addCash" required>
          </div>
          <div class="invalid-feedback">
            Campo obrigatório!
          </div>
          <button type="submit" class="btn btn-primary mt-2 w-100">
            <i class="bi bi-cash-coin"></i>
            Adicionar Cash
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
</body>

</html>