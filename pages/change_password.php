<?php
session_start();
require './utils/utils.php';
if (!isset($_SESSION['user'])) {
  // Usuário não logado, redireciona para a página de login
  header("Location: ./login.php");
  exit;
}

require '../connection/conn.php';
require './utils/validation.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Metin2</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a href="../index.php" class="navbar-brand"><img src="../assets/metin2.png" class="img-fluid ms-1"
                alt="metin2"></a>
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
        avatar($_SESSION['user'], $avatarBackgroundColor, 'logout.php', './change_password.php');
        ?>
            </div>
        </div>
    </nav>
    <main>
        <!-- Container de Toasts (Fica fixo no topo direito da tela, sem quebrar o design) -->
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
            <?php if (isset($_SESSION['password_updated'])): ?>
            <div id="toastSenhaSucesso" class="toast align-items-center text-white bg-success border-0 shadow"
                role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">
                        <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['password_updated']; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            <?php unset($_SESSION['password_updated']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['errors'])): ?>
            <?php foreach ($_SESSION['errors'] as $index => $erro): ?>
            <div id="toastSenhaErro_<?= $index; ?>"
                class="toast align-items-center text-white bg-danger border-0 shadow mb-2" role="alert"
                aria-live="assertive" aria-atomic="true" data-bs-delay="7000">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $erro; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>
        </div>

        <!-- Formulário Clean -->
        <div class="d-flex justify-content-center mt-4">
            <div class="card bg-dark text-light border-secondary w-100 p-4 shadow-lg rounded" style="max-width: 500px;">

                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary text-uppercase tracking-wide mb-2"
                        style="font-size: 1.5rem; letter-spacing: 1px;">
                        <i class="bi bi-shield-lock me-2"></i>Alterar minha senha
                    </h3>
                    <span class="badge bg-secondary text-light text-uppercase p-2"
                        style="font-size: 0.8rem; letter-spacing: 0.5px;">
                        <i class="bi bi-person me-1"></i>Conta: <span
                            class="text-warning"><?= htmlspecialchars($_SESSION['user']); ?></span>
                    </span>
                </div>

                <form class="needs-validation" method="post" action="" novalidate>

                    <div class="mb-3">
                        <label for="actualPassword" class="form-label text-secondary-light small fw-semibold">
                            <i class="bi bi-lock me-1 text-primary"></i>Senha atual
                        </label>
                        <div class="input-group has-validation">
                            <input type="password"
                                class="form-control bg-secondary bg-opacity-10 text-light border-secondary campo-senha"
                                id="actualPassword" name="actualPassword" required>
                            <div class="invalid-feedback">
                                Campo obrigatório!
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="newPassword" class="form-label text-secondary-light small fw-semibold">
                            <i class="bi bi-key me-1 text-primary"></i>Nova senha
                        </label>
                        <div class="input-group has-validation">
                            <input type="password"
                                class="form-control bg-secondary bg-opacity-10 text-light border-secondary campo-senha"
                                id="newPassword" name="newPassword" required>
                            <button type="button" class="btn btn-outline-secondary border-secondary text-light px-3"
                                data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                data-bs-html="true"
                                data-bs-content="<div class='small text-start'>• Mínimo 8 caracteres<br>• Máximo 12 caracteres<br>• 1 letra maiúscula<br>• 1 letra minúscula<br>• 1 caractere especial<br>• 1 número</div>">
                                <i class="bi bi-info-circle"></i>
                            </button>
                            <div class="invalid-feedback">
                                Campo obrigatório!
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="newConfirmPassword" class="form-label text-secondary-light small fw-semibold">
                            <i class="bi bi-shield-check me-1 text-primary"></i>Confirmar Senha
                        </label>
                        <div class="input-group has-validation">
                            <input type="password"
                                class="form-control bg-secondary bg-opacity-10 text-light border-secondary campo-senha"
                                id="newConfirmPassword" name="newConfirmPassword" required>
                            <div class="invalid-feedback">
                                Campo obrigatório!
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input bg-secondary bg-opacity-10 border-secondary" type="checkbox"
                            value="" id="showPasword" style="cursor: pointer;">
                        <label class="form-check-label text-secondary-light small" for="showPasword"
                            style="cursor: pointer; user-select: none;">
                            Mostrar as senhas digitadas
                        </label>
                    </div>

                    <button type="submit"
                        class="btn btn-primary py-2 w-100 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2"
                        style="letter-spacing: 0.5px;">
                        <i class="bi bi-arrow-repeat fs-5"></i> Alterar Senha
                    </button>

                </form>
            </div>
        </div>

        <!-- Script no fim da página para disparar os Toasts automaticamente se eles existirem na sessão -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa e exibe o toast de sucesso se ele existir
            var toastSucessoEl = document.getElementById('toastSenhaSucesso');
            if (toastSucessoEl) {
                var toastSucesso = new bootstrap.Toast(toastSucessoEl);
                toastSucesso.show();
            }

            // Inicializa e exibe todos os toasts de erro se existirem
            var toastErroEls = document.querySelectorAll('[id^="toastSenhaErro_"]');
            toastErroEls.forEach(function(element) {
                var toastErro = new bootstrap.Toast(element);
                toastErro.show();
            });
        });
        </script>
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
    <script src="../script/form.validation.js"></script>
</body>

</html>