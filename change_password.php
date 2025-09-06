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
              <svg xmlns='http://www.w3.org/2000/svg' style='display: none;' viewBox='0 0 16 16'>
                <symbol id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
                  <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                </symbol>
              </svg>
               <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
              ";
        echo $_SESSION['password_updated'];
        echo "</div>";
      }
      unset($_SESSION['password_updated']);

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
        <label for="actualPassword">Senha atual</label>
        <input type="password" class="form-control campo-senha" id="actualPassword" name="actualPassword" required>
        <div class="invalid-feedback">
          Campo obrigatório!
        </div>
        <label for="newPassword">Nova senha</label>
        <div class="d-flex">
          <input type="password" class="form-control campo-senha" id="newPassword" name="newPassword" required>
          <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="Deve conter no mínimo 8 catacter<br>Deve ter no máximo 12 caracter<br>Deve conter 1 letra maiúscula<br>Deve conter 1 letra minúscula<br>Deve conter 1 caractere especial<br>Deve conter 1 número">
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