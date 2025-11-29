<?php
session_start();
?>
<div class="col-lg-6 offset-lg-3">
  <form class="needs-validation" method="post" action="./validate_register.php" novalidate>
    <h2>Faça seu cadastro</h2>
    <?php
    // Verifica se há erros na sessão e exibe-os
    if (isset($_SESSION['errors'])) {
      foreach ($_SESSION['errors'] as $erro) {
        echo "<div class='alert alert-danger alert-dismissible fade show' id='alert' role='alert'>";
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
    // Limpa as mensagens de erro para evitar que apareçam novamente
    unset($_SESSION['errors']);

    if (isset($_SESSION['success'])) {
      echo "<div class='alert alert-success' id='alert' role='alert'>";
      echo "
          <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-check-fill' viewBox='0 0 16 16'>
          <path fill-rule='evenodd' d='M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0'/>
          <path d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6'/>
          </svg>
          ";
      echo $_SESSION['success'];
      echo "</div>";
    }
    unset($_SESSION['success'])
    ?>
    <div class="mb-3">
      <label for="username" class="form-label">Login</label>
      <div class="d-flex">
        <input type="text" class="form-control" maxlength="12" aria-label="default input example" id="username" name="username" required>
        <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="Deve conter no mínimo 8 caracter<br>Deve ter no máximo 12 caracter ">
          ?
        </button>
      </div>
      <div class="invalid-feedback">
        Campo obrigatório!
      </div>
      <label for="exampleFormControlInput1" class="form-label">Endereço de Email</label>
      <input type="email" maxlength="50" class="form-control" id="exampleFormControlInput1" name="email" data-bs-toggle="tooltip" data-bs-placement="top" title="email@example.com" required>
      <div class="invalid-feedback">
        Campo obrigatório!
      </div>
      <label for="password" class="form-label">Senha</label>
      <div class="d-flex">
        <input type="password" maxlength="12" class="form-control" id="password" name="password" required>
        <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="Deve conter no mínimo 8 catacter<br>Deve ter no máximo 12 caracter<br>Deve conter 1 letra maiúscula<br>Deve conter 1 letra minúscula<br>Deve conter 1 caracter especial<br>Deve conter 1 número">
          ?
        </button>
      </div>
      <div class="invalid-feedback">
        Campo obrigatório!
      </div>
      <label for="password-confirm" class="form-label">Confirmar Senha</label>
      <div class="d-flex">
        <input type="password" maxlength="12" class="form-control" id="password-confirm" name="password-confirm" required>
      </div>
      <div class="invalid-feedback">
        Campo obrigatório!
      </div>
      <label for="password-character" class="form-label">Senha do Personagem</label>
      <div class="d-flex">
        <input class="form-control" maxlength="7" type="number" aria-label="default input example" id="password-character" name="character" required>
        <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="Deve conter no exatamente 7 dígitos">
          ?
        </button>
      </div>
      <div class="invalid-feedback">
        Campo obrigatório!
      </div>
    </div>
    <div class="form-check mt-2 mb-2">
      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
      <label class="form-check-label" for="flexCheckDefault">
        Estou ciente e aceito os <a href="rules.php" target="_blank" class="text-primary">termos</a> de uso
        do servidor
      </label>
    </div>
    <button type="submit" class="btn btn-primary w-100 mb-2 mt-2" disabled id="submit">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
        <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
      </svg>
      Cadastrar</button>
  </form>
</div>
<script src="./script/form.validation.js"></script>