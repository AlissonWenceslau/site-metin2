<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="/assets/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <title>Metin2 - Simple Page</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="index.php" class="navbar-brand"><img src="./assets/metin2.png" class="img-fluid" alt="metin2"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Cadastro</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="donwload.php">Download</a>
        </li>
      </ul>
    </div>
  </nav>
  <main>
    <div class="col-lg-6 offset-lg-3">
      <form class="needs-validation" method="post" action="./register.php" novalidate>
        <h2 class="text text-primary">Faça seu cadastro</h2>
        <?php
        // Verifica se há erros na sessão e exibe-os
        if (isset($_SESSION['errors'])) {
          foreach ($_SESSION['errors'] as $erro) {
            echo "<div class='alert alert-danger' id='alert' role='alert'>";
            echo "<i class='bi bi-person-fill-x'></i>";
            echo $erro;
            echo "</div>";
          }
        }
        // Limpa as mensagens de erro para evitar que apareçam novamente
        unset($_SESSION['errors']);

        if (isset($_SESSION['success'])) {
          echo "<div class='alert alert-success' id='alert' role='alert'>";
          echo "<i class='bi bi-person-add'></i>";
          echo $_SESSION['success'];
          echo "</div>";
        }
        unset($_SESSION['success'])
        ?>
        <div class="mb-3">
          <label for="username" class="form-label">Login</label>
          <input type="text" class="form-control" maxlength="12" placeholder="Mínimo 5 e Máximo 12 caracteres" pattern="[a-zA-Z0-9]+" aria-label="default input example" id="username" name="username" required>
          <div class="invalid-feedback">
            Campo obrigatório!
          </div>
          <label for="exampleFormControlInput1" class="form-label">Endereço de Email</label>
          <input type="email" maxlength="50" class="form-control" id="exampleFormControlInput1" placeholder="email@example.com" name="email" required>
          <div class="invalid-feedback">
            Campo obrigatório!
          </div>
          <label for="password" class="form-label">Senha</label>
          <input type="password" maxlength="12" class="form-control" placeholder="Mínimo 5 e Máximo 12 caracteres" pattern="[a-zA-Z0-9]+" id="password" name="password" required>
          <div class="invalid-feedback">
            Campo obrigatório!
          </div>
          <label for="password-confirm" class="form-label">Confirmar Senha</label>
          <input type="password" maxlength="12" class="form-control" placeholder="Mínimo 5 e Máximo 12 caracteres" pattern="[a-zA-Z0-9]+" id="password-confirm" name="password-confirm" required>
          <div class="invalid-feedback">
            Campo obrigatório!
          </div>
          <label for="password-character" class="form-label">Senha do Personagem</label>
          <input class="form-control" maxlength="7" type="text" pattern="[a-zA-Z0-9]+" placeholder="Mínimo 7 caracteres" aria-label="default input example" id="password-character" name="character" value="1234567" required>
          <div class="invalid-feedback">
            Campo obrigatório!
          </div>
        </div>
        <button type="submit" class="bi bi-person-add btn btn-primary w-100 mb-2">
            Cadastrar
        </button>
      </form>
    </div>
  </main>
  <footer id="sticky-footer" class="flex-shrink-0 py-3 bg-dark text-white-50">
    <div class="container text-center">
      <small>Copyright &copy; <?php echo date("Y"); ?></small>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="./script/validations.js"></script>
</body>

</html>