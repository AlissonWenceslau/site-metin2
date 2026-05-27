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
    <?php if (isset($_SESSION['web']) && $_SESSION['web'] == 1): ?>
        
        <?php if (isset($_SESSION['news_system']) && $_SESSION['news_system'] === 'success'): ?>
            <li class="list-group-item">
                <i class="bi bi-newspaper me-1"></i>
                <a href="../pages/adm/register_news.php">Adicionar Notícia</a>
            </li>
        <?php else: ?>
            <li class="list-group-item">
                <i class="bi bi-newspaper me-1"></i>
                <a href="../pages/adm/install_notices.php" onclick="return confirm('Atenção! Esta ação irá verificar e criar a tabela de notícias e os gatilhos de fuso horário no seu banco de dados.\n\nSe a tabela já existir, as configurações serão atualizadas.\n\nDeseja prosseguir com a instalação do sistema de notícias?')">
                    Instalar sistema de notícia
                </a>
            </li>
        <?php endif; ?>

    <?php endif; ?>   
  </ul>
</div>