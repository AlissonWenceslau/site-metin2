<?php
session_start();
include './utils/utils.php';

if (!isset($_SESSION['user'])) {
  // Usuário não logado, redireciona para a página de login
  header("Location: login.php");
  exit;
}else if($_SESSION['web'] == 0){
    header("Location: logout.php");
  exit;
}

include 'conn.php';
include './utils/validation.php';

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
    header('Location: admin_add_cash.php');
    exit();
  }

  if ($result->num_rows === 1) {
    // Senha atual correta, atualiza para nova senha
    $stmt = $conn->prepare("UPDATE account SET cash = cash + ? WHERE login = ?");
    $stmt->bind_param("ss", $addCash, $login);
    if ($stmt->execute()) {
      $_SESSION['add_cash'] = 'Cash adicionado com sucesso: ' . $addCash ;
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
          <a class="nav-link active" href="index.php">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="download.php">Download</a>
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
        avatar($_SESSION['user'], $avatarBackgroundColor);
      ?>
    </div>
  </nav>
  <div class="content d-flex justify-content-center mt-5 align-items-sm-start mb-2">
    <div class="d-flex flex-column border p-2 w-25 rounded">
      <h3>Adicionar cash a uma conta</h3>
      <?php
      if (isset($_SESSION['add_cash'])) {
        echo "<div class='alert alert-success' id='alert' role='alert'>";
        echo "
              <svg xmlns='http://www.w3.org/2000/svg' style='display: none;' viewBox='0 0 16 16'>
                <symbol id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
                  <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                </symbol>
              </svg>
               <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
              ";
        echo $_SESSION['add_cash'];
        echo "</div>";
      }
      unset($_SESSION['add_cash']);

      if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $erro) {
          echo "<div class='alert alert-danger updated-password-fail alert-dismissible fade show' id='alert' role='alert'>";
          echo "
                <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
                  <symbol id='exclamation-triangle-fill' fill='currentColor' viewBox='0 0 16 16'>
                    <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
                  </symbol>
                </svg>
              <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              ";
          echo $erro;
          echo "</div>";
        }
      }
      unset($_SESSION['errors']);
      ?>
      <form class="needs-validation" method="post" action="" novalidate>
        <label for="actualPassword">Login</label>
        <input type="text" class="form-control campo-senha" id="account" name="account" required>
        <div class="invalid-feedback">
          Campo obrigatório!
        </div>
        <label for="addCash">Quantos de  Cash deseja adicionar a conta?</label>
        <div class="d-flex">
          <input type="number" class="form-control campo-senha" id="addCash" name="addCash" required>
        </div>
        <div class="invalid-feedback">
          Campo obrigatório!
        </div>
        <button type="submit" class="btn btn-primary mt-2">Adicionar Cash</button>
      </form>
    </div>
  </div>
  <footer id="sticky-footer" class="flex-shrink-0 py-3 bg-dark text-white-50">
    <div class="container text-center">
      <small>Todos os direitos reservados! Copyright &copy; <?php echo date("Y"); ?></small>
    </div>
  </footer>
  <script src="./script/bootstrap.bundle.min.js"></script>
  <script src="./script/form.validation.js"></script>
</body>

</html>