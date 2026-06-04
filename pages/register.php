<?php
session_start();
require './utils/utils.php';
if (isset($_SESSION['user'])) {
  // Usuário não logado, redireciona para a página de login
  header("Location: ../index.php");
  exit;
}
?>
<!doctype html>
<html lang="pt-br">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/favicon.ico">  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
                echo '<a class="nav-link active" href="register.php"><i class="bi bi-person-plus"></i>Cadastrar</a>';
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
        <ul class="navbar-nav align-items-center pe-3 pe-md-4">
          <li class="nav-item">
            <?php if (!$_SESSION['user']): ?>
              <a class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold text-uppercase d-inline-flex align-items-center gap-2" 
                href="./login.php" 
                style="letter-spacing: 0.5px; font-size: 0.85rem; transition: all 0.2s ease;">
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
      <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
          <?php
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          if (isset($_SESSION['errors'])) {
              foreach ($_SESSION['errors'] as $index => $erro) {
                  echo '<div id="toastRegErro_' . $index . '" class="toast align-items-center text-white bg-danger border-0 mb-2 shadow" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="6000">';
                  echo '  <div class="d-flex">';
                  echo '    <div class="toast-body fw-semibold">';
                  echo '      <i class="bi bi-exclamation-triangle-fill me-2"></i>' . htmlspecialchars($erro);
                  echo '    </div>';
                  echo '    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>';
                  echo '  </div>';
                  echo '</div>';
              }
              unset($_SESSION['errors']);
          }

          if (isset($_SESSION['success'])) {
              echo '<div id="toastRegSucesso" class="toast align-items-center text-white bg-success border-0 mb-2 shadow" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="7000">';
              echo '  <div class="d-flex">';
              echo '    <div class="toast-body fw-semibold">';
              echo '      <i class="bi bi-check-circle-fill me-2"></i>' . htmlspecialchars($_SESSION['success']);
              echo '    </div>';
              echo '    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>';
              echo '  </div>';
              echo '</div>';
              unset($_SESSION['success']);
          }
          ?>
      </div>

      <main class="bg-light text-light min-vh-100 py-5 d-flex align-items-center">
          <div class="container">
              <div class="row justify-content-center">
                  <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                      <div class="text-center mb-4 bg-dark p-4 rounded border border-secondary shadow-sm">
                          <h2 class="h4 text-primary text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">
                              <i class="bi bi-person-plus-fill me-2"></i>Faça seu cadastro
                          </h2>
                          <p class="text-secondary small mb-0">Crie sua conta em poucos segundos e comece a jogar.</p>
                      </div>

                      <div class="card bg-dark text-light border-secondary p-4 rounded shadow-lg">
                          <form class="needs-validation" method="post" action="/pages/validation/validate_register.php" novalidate>
                              
                              <div class="mb-3">
                                  <label for="username" class="form-label fw-semibold text-secondary-light small text-uppercase">
                                      <i class="bi bi-person-vcard me-1 text-primary"></i>Login
                                  </label>
                                  <div class="input-group has-validation">
                                      <input type="text" class="form-control bg-secondary bg-opacity-10 text-white border-secondary custom-placeholder" maxlength="12" id="username" name="username" placeholder="Digite seu usuário" required>
                                      <button type="button" class="btn btn-outline-secondary border-secondary bg-secondary bg-opacity-10 text-secondary-light" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-title="Requisitos do Login" data-bs-content="• Mínimo: 8 caracteres<br>• Máximo: 12 caracteres">
                                          <i class="bi bi-question-circle"></i>
                                      </button>
                                      <div class="invalid-feedback">Campo obrigatório!</div>
                                  </div>
                              </div>
                              
                              <div class="mb-3">
                                  <label for="email" class="form-label fw-semibold text-secondary-light small text-uppercase">
                                      <i class="bi bi-envelope-plus me-1 text-primary"></i>Endereço de Email
                                  </label>
                                  <div class="input-group has-validation">
                                      <input type="email" class="form-control bg-secondary bg-opacity-10 text-white border-secondary custom-placeholder" maxlength="50" id="email" name="email" placeholder="guerreiro@exemplo.com" data-bs-toggle="tooltip" data-bs-placement="top" title="email@example.com" required>
                                      <div class="invalid-feedback">Por favor, insira um e-mail válido!</div>
                                  </div>
                              </div>
                              
                              <div class="mb-3">
                                  <label for="password" class="form-label fw-semibold text-secondary-light small text-uppercase">
                                      <i class="bi bi-lock me-1 text-primary"></i>Senha
                                  </label>
                                  <div class="input-group has-validation">
                                      <input type="password" maxlength="12" class="form-control bg-secondary bg-opacity-10 text-white border-secondary custom-placeholder" id="password" name="password" placeholder="Digite sua senha" required>
                                      <button type="button" class="btn btn-outline-secondary border-secondary bg-secondary bg-opacity-10 text-secondary-light" data-bs-container="body" data-bs-title="Requisitos da Senha" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="• Mínimo 8 e máximo 12 caracteres<br>• 1 letra maiúscula<br>• 1 letra minúscula<br>• 1 caractere especial<br>• 1 número">
                                          <i class="bi bi-question-circle"></i>
                                      </button>
                                      <div class="invalid-feedback">Campo obrigatório!</div>
                                  </div>
                              </div>
                              
                              <div class="mb-3">
                                  <label for="password-confirm" class="form-label fw-semibold text-secondary-light small text-uppercase">
                                      <i class="bi bi-arrow-clockwise me-1 text-primary"></i>Confirmar Senha
                                  </label>
                                  <div class="input-group has-validation">
                                      <input type="password" maxlength="12" class="form-control bg-secondary bg-opacity-10 text-white border-secondary custom-placeholder" id="password-confirm" name="password-confirm" placeholder="Repita a senha" required>
                                      <div class="invalid-feedback">Campo obrigatório!</div>
                                  </div>
                              </div>
                              
                              <div class="mb-4">
                                  <label for="password-character" class="form-label fw-semibold text-secondary-light small text-uppercase">
                                      <i class="bi bi-key me-1 text-primary"></i>Senha do Personagem
                                  </label>
                                  <div class="input-group has-validation">
                                      <input class="form-control bg-secondary bg-opacity-10 text-white border-secondary custom-placeholder" maxlength="7" type="number" value="1234567" id="password-character" name="character" required>
                                      <button type="button" class="btn btn-outline-secondary border-secondary bg-secondary bg-opacity-10 text-secondary-light" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-title="Código de Deleção" data-bs-content="• Deve conter exatamente 7 dígitos numéricos.<br>• Usado para apagar personagens dentro do jogo.">
                                          <i class="bi bi-question-circle"></i>
                                      </button>
                                      <div class="invalid-feedback">Campo obrigatório!</div>
                                  </div>
                              </div>
                              
                              <div class="form-check mb-4">
                                  <input class="form-check-input bg-secondary bg-opacity-10 border-secondary" type="checkbox" value="" id="flexCheckDefault" style="cursor: pointer;">
                                  <label class="form-check-label text-secondary-light small user-select-none" for="flexCheckDefault" style="cursor: pointer;">
                                      Estou ciente e aceito os <a href="rules.php" target="_blank" class="text-primary fw-semibold link-underline-opacity-25">termos de uso</a> do servidor.
                                  </label>
                              </div>
                              
                              <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold text-uppercase signup-btn d-flex align-items-center justify-content-center gap-2" disabled id="submit" style="letter-spacing: 0.5px;">
                                  <i class="bi bi-person-fill-add fs-5"></i> Finalizar Cadastro
                              </button>
                          </form>
                      </div>

                  </div>
              </div>
          </div>
      </main>

      <script>
        document.addEventListener('DOMContentLoaded', function () {
          // Exibe toast de sucesso
          var toastSucessoEl = document.getElementById('toastRegSucesso');
          if (toastSucessoEl) {
            var toastSucesso = new bootstrap.Toast(toastSucessoEl);
            toastSucesso.show();
          }

          // Exibe lista de toasts de erro
          var toastErroEls = document.querySelectorAll('[id^="toastRegErro_"]');
          toastErroEls.forEach(function (element) {
            var toastErro = new bootstrap.Toast(element);
            toastErro.show();
          });
        });
      </script>

      <style>
          .signup-btn {
              transition: all 0.2s ease-in-out;
          }
          .signup-btn:hover:not(:disabled) {
              transform: translateY(-1px);
              box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.15);
          }
          
          /* Regra para garantir o placeholder em branco absoluto */
          .custom-placeholder::placeholder {
              color: #ffffff !important;
              opacity: 1 !important;
          }
          .custom-placeholder::-webkit-input-placeholder {
              color: #ffffff !important;
              opacity: 1 !important;
          }
          .custom-placeholder::-moz-placeholder {
              color: #ffffff !important;
              opacity: 1 !important;
          }
          .custom-placeholder:-ms-input-placeholder {
              color: #ffffff !important;
              opacity: 1 !important;
          }
      </style>
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
    <script src="../script/form.validation.js"></script>   
    <script src="../script/toast-message.js"></script>   
  </body>
</html>