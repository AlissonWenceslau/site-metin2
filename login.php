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
            <a class="nav-link" href="rules.php">Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="status.php">Status</a>
          </li>
      </div>
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
      if ($_SESSION['user']) {
        echo '<a href="index.php" class="rounded-circle border d-flex justify-content-center align-items-center text-light bg-primary link-offset-2 link-underline link-underline-opacity-0"
        style="width:50px;height:50px"
        alt="Avatar">';
        echo htmlspecialchars(strtoupper($_SESSION['user'])[0]) . '</a>';

        '</a>';
      }
      ?>
    </div>
  </nav>
  <div class="content d-flex justify-content-center align-items-sm-start mt-5">
    <div class="d-fex border border-dark p-5 rounded">
      <h3>Faça o seu login</h3>
      <?php
      session_start();
      // Verifica se há erros na sessão e exibe-os
      if (isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger' id='alert' role='alert'>";
        echo "
              <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-fill-x' viewBox='0 0 16 16'>
                <path d='M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4'/>
                <path d='M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708'/>
              </svg>
              ";
        echo $_SESSION['error'];
        echo "</div>";
        // Limpa as mensagens de erro para evitar que apareçam novamente
        unset($_SESSION['error']);
      }
      ?>
      <form class="needs-validation" method="post" action="./validate_login.php" novalidate>
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
        <button type="submit" id="btnEntrar" class="btn btn-primary mt-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
          </svg>
          Entrar
          <span id="spinner" class="spinner-border spinner-border-sm visually-hidden" role="status" aria-hidden="true"></span>
        </button>
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