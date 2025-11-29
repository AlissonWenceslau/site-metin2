<div class="card col-lg-6 offset-lg-5 mt-5" style="width: 18rem;">
  <div class="card-header">
    <h6>Espaço do Usuário</h6>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
      <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
      <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
    </svg>
    Olá <?php echo '<strong>' . strtoupper(htmlspecialchars($_SESSION['user'])) . '</strong>'; ?>, seja bem vindo ao painel do usuário!
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><?php echo '<a href="./change_password.php">Alterar senha da conta </a>' ?></li>
    <?php if ($_SESSION['web'] == 1) echo '<li class="list-group-item"><a href="./admin_add_cash.php">Adicionar Cash</a></li>' ?>
    <li class="list-group-item"><?php echo '<a href="./logout.php" class="text-danger">Sair da Conta</a>' ?></li>
  </ul>
</div>