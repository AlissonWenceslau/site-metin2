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
              <a class="nav-link" href="rules.php"><i class="bi bi-book"></i>Regras</a>
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
          avatar($_SESSION['user'], $avatarBackgroundColor, 'logout.php');
          ?>
        </div>
      </div>
    </nav>
    <main class="d-flex justify-content-center">
      <div class="form container">
        <h2 class="text text-primary">Faça seu cadastro</h2>
        <form class="needs-validation" method="post" action="/pages/validation/validate_register.php" novalidate>
          <?php
          // Verifica se há erros na sessão e exibe-os
          if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $erro) {
              echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
              echo '<i class="bi bi-person-fill-x me-1"></i>';
              echo '<strong class="me-1">Alerta!</strong>';
              echo $erro;
              echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
              echo '</div>';
            }
          }
          // Limpa as mensagens de erro para evitar que apareçam novamente
          unset($_SESSION['errors']);

          if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success" id="alert" role="alert">';
            echo '<i class="bi bi-person-fill-add"></i>';
            echo $_SESSION['success'];
            echo '</div>';
          }
          unset($_SESSION['success'])
          ?>
          <div class="mb-3">
            <label for="username" class="form-label"><i class="bi bi-person-vcard me-1"></i>Login</label>
            <div class="d-flex input-group has-validation">
              <input type="text" class="form-control" maxlength="12" aria-label="default input example" id="username" name="username" required>
              <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-title="Requisitos" data-bs-content="Deve conter no mínimo 8 caracter<br>Deve ter no máximo 12 caracter ">
                ?
              </button>
              <div class="invalid-feedback">
                Campo obrigatório!
              </div>
            </div>
            <label for="exampleFormControlInput1" class="form-label"><i class="bi bi-envelope-plus me-1"></i>Endereço de Email</label>
            <div class="d-flex input-group has-validation">
              <input type="email" class="form-control" maxlength="50" id="exampleFormControlInput1" name="email" data-bs-toggle="tooltip" data-bs-placement="top" title="email@example.com" required>
              <div class="invalid-feedback">
                Campo obrigatório!
              </div>
            </div>
            <label for="password" class="form-label"><i class="bi bi-lock me-1"></i>Senha</label>
            <div class="d-flex input-group has-validation">
              <input type="password" maxlength="12" class="form-control" id="password" name="password" required>
              <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-title="Requisitos" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="Deve conter no mínimo 8 catacter<br>Deve ter no máximo 12 caracter<br>Deve conter 1 letra maiúscula<br>Deve conter 1 letra minúscula<br>Deve conter 1 caracter especial<br>Deve conter 1 número">
                ?
              </button>
              <div class="invalid-feedback">
                Campo obrigatório!
              </div>
            </div>
            <label for="password-confirm" class="form-label"><i class="bi bi-arrow-clockwise me-1"></i>Confirmar Senha</label>
            <div class="d-flex input-group has-validation">
              <input type="password" maxlength="12" class="form-control" id="password-confirm" name="password-confirm" required>
              <div class="invalid-feedback">
                Campo obrigatório!
              </div>
            </div>
            <label for="password-character" class="form-label"><i class="bi bi-key"></i>Senha do Personagem</label>
            <div class="d-flex input-group has-validation">
              <input class="form-control" maxlength="7" type="number" value="1234567" aria-label="default input example" id="password-character" name="character" required>
              <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-title="Requisitos" data-bs-content="Deve conter no exatamente 7 dígitos">
                ?
              </button>
              <div class="invalid-feedback">
                Campo obrigatório!
              </div>
            </div>
          </div>
          <div class="form-check mt-2 mb-2">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              Estou ciente e aceito os <a href="./pages/rules.php" target="_blank" class="text-primary">termos</a> de uso
              do servidor
            </label>
          </div>
          <button type="submit" class="btn btn-primary w-100 mb-2 mt-2" disabled id="submit">
            <i class="bi bi-person-fill-add"></i>
            Cadastrar</button>
        </form>
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
    <script src="../script/dynamic-icons.js"></script>
    <script src="../script/form.validation.js"></script>   
  </body>
</html>