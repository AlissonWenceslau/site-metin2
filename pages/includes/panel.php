<div class="card mt-2">
  <div class="card-header">
    <h6>Espaço do Usuário</h6>
    <i class="bi bi-person-circle"></i>
    Olá <?php echo '<strong>' . strtoupper(htmlspecialchars($_SESSION['user'])) . '</strong>'; ?>, seja bem vindo ao painel do usuário!
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><?php echo '<a href="./pages/change_password.php">Alterar senha da conta </a>' ?></li>
    <?php if ($_SESSION['web'] == 1) echo '<li class="list-group-item"><a href="../pages/adm/add_cash.php">Adicionar Cash</a></li>' ?>
    <li class="list-group-item"><?php echo '<a href="./pages/logout.php" class="text-danger">Sair da Conta</a>' ?></li>
  </ul>
</div>