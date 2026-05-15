<?php
session_start();
if (!isset($_SESSION['user'])) {
  // Usuário não logado, redireciona para a página de login
  header("Location: ../../index.php");
  exit;
}
?>
<div class="card mt-2">
  <div class="card-header">
    <div>
      <h6>Painel do Usuário</h6>
      <i class="bi bi-person-circle"></i>
      Olá <?php echo '<strong>' . strtoupper(htmlspecialchars($_SESSION['user'])) . '</strong>'; ?>, seja bem vindo ao painel do usuário!
    </div>
    <div>
      <i class="bi bi-cash-coin"></i>
      <?php echo number_format($_SESSION['cash']) ?>
    </div>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><?php echo '<i class="bi bi-lock me-1"></i><a href="./pages/change_password.php">Alterar senha</a>' ?></li>
    <?php if ($_SESSION['web'] == 1) echo '<li class="list-group-item"><i class="bi bi-cash-coin me-1"></i><a href="../pages/adm/add_cash.php">Adicionar Cash</a></li>' ?>
  </ul>
</div>