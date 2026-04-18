<?php
session_start();
require '../utils/utils.php';
if (!isset($_SESSION['user'])) {
  // Usuário não logado, redireciona para a página de login
  header("Location: ../login.php");
  exit;
}

require './includes/conn.php';
require '../utils/validation.php';

// Conectar ao banco
$conn = new mysqli($servername, $username, $password, $dbaccount);

if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $login = $_SESSION['user'];
  $senhaAtual = $_POST['actualPassword'];
  $novaSenha = $_POST['newPassword'];
  $newConfirmPassword = $_POST['newConfirmPassword'];

  // Criptografa a senha atual e nova no formato MySQL
  $senhaAtualHash = '*' . strtoupper(sha1(sha1($senhaAtual, true)));
  $novaSenhaHash  = '*' . strtoupper(sha1(sha1($novaSenha, true)));

  // Verifica se a senha atual está correta
  $stmt = $conn->prepare("SELECT * FROM account WHERE login = ? AND password = ?");
  $stmt->bind_param("ss", $login, $senhaAtualHash);
  $stmt->execute();
  $result = $stmt->get_result();

  $errorsValidatePassword = validatePassword($novaSenha);
  $errorsValidadeNewConfirmPassword = validateNewConfirmPassword($novaSenha, $newConfirmPassword);
  $errors = array_merge($errorsValidatePassword, $errorsValidadeNewConfirmPassword);

  if ($result->num_rows === 0) {
    $errors[] = 'Senha atual incorreta';
  }

  if (count($errors) > 0) {
    $_SESSION['errors'] = $errors;
    header('Location: change_password.php');
    exit();
  }

  if ($result->num_rows === 1) {
    // Senha atual correta, atualiza para nova senha
    $stmt = $conn->prepare("UPDATE account SET password = ? WHERE login = ?");
    $stmt->bind_param("ss", $novaSenhaHash, $login);
    if ($stmt->execute()) {
      $_SESSION['password_updated'] = 'Senha alterada com sucesso!';
    } else {
      echo "Erro ao atualizar senha.";
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
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="../index.php">Início</a>
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
  <main>
    <div class="d-flex justify-content-center mt-2">
      <div class="d-flex flex-column border p-2 m-2 w-100 rounded">
        <h3 class="text text-primary text-center">Alterar minha senha</h3>
        <span class="badge text-bg-secondary mb-1 bg bg-primary"><?php echo 'Conta: ' . htmlspecialchars($_SESSION['user']) ?> </span>
        <?php
        if (isset($_SESSION['password_updated'])) {
          echo "<div class='alert alert-success' id='alert' role='alert'>";
          echo '<i class="bi bi-check-circle-fill me-1"></i>';
          echo $_SESSION['password_updated'];
          echo "</div>";
        }
        unset($_SESSION['password_updated']);
        if (isset($_SESSION['errors'])) {
          foreach ($_SESSION['errors'] as $erro) {
            echo '<div class="alert alert-warning updated-password-fail alert-dismissible fade show" id="alert" role="alert">';
            echo '<i class="bi bi-exclamation-triangle-fill me-1"></i>';
            echo $erro;
            echo '</div>';
          }
        }
        unset($_SESSION['errors']);
        ?>
        <form class="needs-validation" method="post" action="" novalidate>
          <label for="actualPassword">Senha atual</label>
          <div class="d-flex input-group has-validation">
            <input type="password" class="form-control campo-senha" id="actualPassword" name="actualPassword" required>
            <div class="invalid-feedback">
              Campo obrigatório!
            </div>
          </div>
          <label for="newPassword">Nova senha</label>
          <div class="d-flex input-group has-validation">
            <input type="password" class="form-control campo-senha" id="newPassword" name="newPassword" required>
            <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="Deve conter no mínimo 8 catacter<br>Deve ter no máximo 12 caracter<br>Deve conter 1 letra maiúscula<br>Deve conter 1 letra minúscula<br>Deve conter 1 caractere especial<br>Deve conter 1 número">
              ?
            </button>
            <div class="invalid-feedback">
              Campo obrigatório!
            </div>
          </div>
          <label for="newConfirmPassword">Confirmar Senha</label>
          <div class="d-flex input-group has-validation">
            <input type="password" class="form-control campo-senha" id="newConfirmPassword" name="newConfirmPassword" required>
            <div class="invalid-feedback">
              Campo obrigatório!
            </div>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="showPasword">
            <label class="form-check-label" for="showPasword">
              Mostrar senha
            </label>
          </div>
          <button type="submit" class="btn btn-primary mt-2 w-100">
            <i class="bi bi-arrow-repeat"></i>
            Alterar
          </button>
        </form>
      </div>
    </div>
  </main>
  <footer id="sticky-footer" class="flex-shrink-0 py-3 bg-dark text-white-50">
    <div class="container text-center">
      <small>Todos os direitos reservados! Copyright &copy; <?php echo date("Y"); ?></small>
    </div>
  </footer>
  <script src="../script/form.validation.js"></script>
</body>

</html>