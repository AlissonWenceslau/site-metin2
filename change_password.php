<?php
session_start();

if (!isset($_SESSION['user'])) {
  // Usuário não logado, redireciona para a página de login
  header("Location: login.php");
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
          <a class="nav-link" href="login.php"><?php if (!$_SESSION['user']) {
                                                  echo 'Entrar';
                                                } ?></a>
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
  </nav>
  <div class="content d-flex justify-content-center mt-5 align-items-sm-start mb-2">
    <div class="d-flex flex-column border p-2 w-25 rounded">
      <h3>Alterar minha senha</h3>
      <span class="badge text-bg-secondary mb-1 bg bg-primary"><?php echo 'Conta: ' . htmlspecialchars($_SESSION['user']) ?> </span>
      <?php
      if (isset($_SESSION['password_updated'])) {
        echo "<div class='alert alert-success' id='alert' role='alert'>";
        echo "
              <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-check-fill' viewBox='0 0 16 16'>
              <path fill-rule='evenodd' d='M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0'/>
              <path d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6'/>
              </svg>
              ";
        echo $_SESSION['password_updated'];
        echo "</div>";
      }
      unset($_SESSION['password_updated']);

      if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $erro) {
          echo "<div class='alert alert-danger updated-password-fail alert-dismissible fade show' id='alert' role='alert'>";
          echo "
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-fill-x' viewBox='0 0 16 16'>
                  <path d='M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4'/>
                  <path d='M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708'/>
                </svg>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                ";
          echo $erro;
          echo "</div>";
        }
      }
      unset($_SESSION['errors']);
      ?>
      <form class="needs-validation" method="post" action="" novalidate>
        <label for="actualPassword">Senha atual</label>
        <input type="password" class="form-control campo-senha" id="actualPassword" name="actualPassword" required>
        <div class="invalid-feedback">
          Campo obrigatório!
        </div>
        <label for="newPassword">Nova senha</label>
        <div class="d-flex">
          <input type="password" class="form-control campo-senha" id="newPassword" name="newPassword" required>
          <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="Deve conter 1 letra maiúscula<br>Deve conter 1 letra minúscula<br>Deve conter 1 caractere especial<br>Deve conter 1 número">
            ?
          </button>
        </div>
        <div class="invalid-feedback">
          Campo obrigatório!
        </div>
        <label for="newConfirmPassword">Confirmar Senha</label>
        <div class="d-flex">
          <input type="password" class="form-control campo-senha" id="newConfirmPassword" name="newConfirmPassword" required>
        </div>
        <div class="invalid-feedback">
          Campo obrigatório!
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="showPasword">
          <label class="form-check-label" for="showPasword">
            Mostrar senha
          </label>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Alterar</button>
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