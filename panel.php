<div class="card mt-5" style="width: 18rem;">
  <div class="card-header">
    Olá <?php echo '<strong>' . htmlspecialchars($_SESSION['user']) . '</strong>'; ?>, seja bem vindo ao painel do usuário!
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><?php echo '<a href="./change_password.php">Alterar senha da conta </a>' ?></li>
    <li class="list-group-item"><?php echo '<a href="./logout.php" class="text-danger">Sair da Conta</a>' ?></li>
  </ul>
</div>