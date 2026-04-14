<?php
session_start();
?>
<div class="form">
  <h2 class="text text-primary">Faça seu cadastro</h2>
  <form class="needs-validation" method="post" action="./validate_register.php" novalidate>
    <?php
    // Verifica se há erros na sessão e exibe-os
    if (isset($_SESSION['errors'])) {
      foreach ($_SESSION['errors'] as $erro) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
        echo '<i class="bi bi-person-fill-x me-1"></i>';
        echo '<strong class="me-1">Erro!</strong>';
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
      <label for="username" class="form-label">Login</label>
      <div class="d-flex input-group has-validation">
        <input type="text" class="form-control" maxlength="12" aria-label="default input example" id="username" name="username" required>
        <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-title="Requisitos" data-bs-content="Deve conter no mínimo 8 caracter<br>Deve ter no máximo 12 caracter ">
          ?
        </button>
        <div class="invalid-feedback">
          Campo obrigatório!
        </div>
      </div>
      <label for="exampleFormControlInput1" class="form-label">Endereço de Email</label>
      <div class="d-flex input-group has-validation">
        <input type="email" class="form-control" maxlength="50" id="exampleFormControlInput1" name="email" data-bs-toggle="tooltip" data-bs-placement="top" title="email@example.com" required>
        <div class="invalid-feedback">
          Campo obrigatório!
        </div>
      </div>
      <label for="password" class="form-label">Senha</label>
      <div class="d-flex input-group has-validation">
        <input type="password" maxlength="12" class="form-control" id="password" name="password" required>
        <button type="button" class="btn btn-primary ms-1" data-bs-container="body" data-bs-title="Requisitos" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="Deve conter no mínimo 8 catacter<br>Deve ter no máximo 12 caracter<br>Deve conter 1 letra maiúscula<br>Deve conter 1 letra minúscula<br>Deve conter 1 caracter especial<br>Deve conter 1 número">
          ?
        </button>
        <div class="invalid-feedback">
          Campo obrigatório!
        </div>
      </div>
      <label for="password-confirm" class="form-label">Confirmar Senha</label>
      <div class="d-flex input-group has-validation">
        <input type="password" maxlength="12" class="form-control" id="password-confirm" name="password-confirm" required>
        <div class="invalid-feedback">
          Campo obrigatório!
        </div>
      </div>
      <label for="password-character" class="form-label">Senha do Personagem</label>
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
        Estou ciente e aceito os <a href="rules.php" target="_blank" class="text-primary">termos</a> de uso
        do servidor
      </label>
    </div>
    <button type="submit" class="btn btn-primary w-100 mb-2 mt-2" disabled id="submit">
      <i class="bi bi-person-fill-add"></i>
      Cadastrar</button>
  </form>
</div>
<script src="./script/form.validation.js"></script>