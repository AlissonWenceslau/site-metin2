<?php
session_start();
require '../utils/utils.php'
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
    <a href="../index.php" class="navbar-brand"><img src="../assets/metin2.png" class="img-fluid" alt="metin2"></a>
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
    <div class="content d-flex justify-content-center align-items-sm-start mt-5">
      <div class="card-login border border-dark p-5 m-2 w-100 rounded">
        <h3 class="text text-primary text-center">Faça o seu login</h3>
        <?php
        session_start();
        // Verifica se há erros na sessão e exibe-os
        if (isset($_SESSION['error'])) {
          echo "<div class='alert alert-danger' id='alert' role='alert'>";
          echo '<i class="bi bi-person-fill-x me-1"></i>';
          echo $_SESSION['error'];
          echo "</div>";
          // Limpa as mensagens de erro para evitar que apareçam novamente
          unset($_SESSION['error']);
        }
        ?>
        <form class="needs-validation" method="post" action="./validation/validate_login.php" novalidate>
          <div class="form-group">
            <label for="login">Login</label>
            <input type="text" class="form-control" id="login" name="login" required>
            <div class="invalid-feedback">
              Campo obrigatório!
            </div>
          </div>
          <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" class="form-control campo-senha" id="password" name="password" required>
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
          <button type="submit" id="btnEntrar" class="btn btn-primary mt-2 w-100">
            <i class="bi bi-box-arrow-in-right"></i>
            Entrar
            <span id="spinner" class="spinner-border spinner-border-sm visually-hidden" role="status" aria-hidden="true"></span>
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
  <script>
    const form = document.querySelector('form');
    const spinner = document.getElementById('spinner');
    const btn = document.getElementById('btnEntrar');

    form.addEventListener('submit', function(event) {
      if (!form.checkValidity()) {
        // Formulário inválido → impede envio e mantém spinner oculto
        event.preventDefault();
        event.stopPropagation();
      } else {
        // Formulário válido → mostra spinner e desativa botão
        spinner.classList.remove('visually-hidden');
        btn.disabled = true;
      }

      // Aplica classes de validação do Bootstrap
      form.classList.add('was-validated');
    });
  </script>
</body>

</html>