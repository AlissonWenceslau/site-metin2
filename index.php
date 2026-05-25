<?php
session_start();
require './pages/utils/utils.php';
require './connection/conn.php';

// Exemplo de conexão PDO
$pdo = new PDO("mysql:host=$servername;dbname=$dbaccount", "$username", "$password");

// Prepara e executa a busca
$sql = "SELECT id, titulo, conteudo, data_publicacao FROM noticias ORDER BY data_publicacao DESC LIMIT 5";
$query = $pdo->query($sql);
$noticias = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="./assets/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./css/style.css">
  <title>Metin2</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="index.php" class="navbar-brand"><img src="./assets/metin2.png" class="img-fluid ms-1" alt="metin2"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse responsive" id="navbarText">
      <div class="links-navegator">
        <ul class="navbar-nav" id="mainNav">
          <li class="nav-item">
            <a class="nav-link active" href="index.php"><i class="bi bi-house-door"></i>Início</a>
          </li>
          <?php
            if (!$_SESSION['user']) {          
              echo '<li class="nav-item">';
              echo '<a class="nav-link" href="./pages/register.php"><i class="bi bi-person-plus"></i>Cadastrar</a>';
              echo '</li>';
            }
          ?>
          <li class="nav-item">
            <a class="nav-link" href="./pages/download.php"><i class="bi bi-cloud-arrow-down"></i>Download</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pages/ranking.php"><i class="bi bi-trophy"></i>Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pages/rules.php"><i class="bi bi-book"></i>Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pages/status.php"><i class="bi bi-info-circle"></i>Status</a>
          </li>
        </ul>
      </div>
      <div class="logar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <?php
            if (!$_SESSION['user']) {
              echo '<a class="btn btn-primary me-2" href="./pages/login.php">';
              echo '<i class="bi bi-box-arrow-in-right me-1"></i>';
              echo 'Entrar';
              echo '</a>';
            }
            ?>
          </li>
        </ul>
        <?php
        avatar($_SESSION['user'], $avatarBackgroundColor, './pages/logout.php');
        ?>
      </div>
    </div>
  </nav>
  <main>
    <div class="d-flex flex-column">
      <div class="container">
        <?php
          if ($_SESSION['user']) {
            require './pages/includes/panel.php';
          } else {
            echo '<div class="d-flex justify-content-center align-items-center flex-column">';
            echo '<h2 class="text text-primary">Apresentação do Servidor</h2>';
            echo '<div class="ratio ratio-21x9"><iframe src="https://www.youtube.com/embed/CAwasAQvgZQ?rel=0" title="YouTube video" allowfullscreen></iframe></div>';
            echo '</div>';
          }
        ?>
        <div class="container mt-5 mb-2">
          <div class="d-flex align-items-center justify-content-center mb-4">
              <hr class="flex-grow-1 border-secondary opacity-25 d-none d-sm-block">
              <h2 class="px-3 text-uppercase fw-bold text-center tracking-wide text text-primary" style="letter-spacing: 2px;">
                  🎮 Últimas Notícias
              </h2>
              <hr class="flex-grow-1 border-secondary opacity-25 d-none d-sm-block">
          </div>

            <div class="row justify-content-center g-4">
                <?php foreach ($noticias as $index => $item): ?>
                    
                    <!-- CARD DA NOTÍCIA (Gatilho para abrir o Modal) -->
                    <div class="col-12 col-md-10 col-lg-8">
                        <!-- Observe os atributos data-bs-toggle e data-bs-target -->
                        <div class="card bg-dark text-light border-secondary h-100 shadow-sm hover-zoom" 
                            style="transition: transform 0.2s; cursor: pointer;"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalNoticia<?= $item['id']; ?>">
                            
                            <div class="card-body d-flex align-items-center justify-content-between p-4">
                                <div>
                                  <?php if ($index === 0): ?>
                                          <!-- Destaca em vermelho (bg-danger) apenas a última notícia -->
                                          <span class="badge bg-danger text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 1px; animation: pulse 2s infinite;">🔥NOVIDADE</span>
                                      <?php else: ?>
                                          <!-- As outras notícias ganham um tom neutro -->
                                          <span class="badge bg-secondary text-uppercase mb-2" style="font-size: 0.75rem;">Notícia</span>
                                  <?php endif; ?>
                                    <h4 class="card-title h5 mb-0 text-light fw-semibold">
                                        <?= htmlspecialchars(utf8_encode($item['titulo'])); ?>
                                    </h4>
                                </div>
                                <div class="text-end">
                                    <span class="text-light small"><?= date('d/m/Y', strtotime($item['data_publicacao'])); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL ESPECÍFICO DESTA NOTÍCIA -->
                    <div class="modal fade" id="modalNoticia<?= $item['id']; ?>" tabindex="-1" aria-labelledby="labelModal<?= $item['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content bg-dark text-light border-secondary">
                                
                                <!-- Cabeçalho do Modal -->
                                <div class="modal-header border-secondary">
                                    <div>
                                  <?php if ($index === 0): ?>
                                          <!-- Destaca em vermelho (bg-danger) apenas a última notícia -->
                                          <span class="badge bg-danger text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 1px; animation: pulse 2s infinite;">🔥NOVIDADE</span>
                                      <?php else: ?>
                                          <!-- As outras notícias ganham um tom neutro -->
                                          <span class="badge bg-secondary text-uppercase mb-2" style="font-size: 0.75rem;">Notícia</span>
                                  <?php endif; ?>
                                        <h5 class="modal-title fw-bold text-warning" id="labelModal<?= $item['id']; ?>">
                                            <?= htmlspecialchars(utf8_encode($item['titulo'])); ?>
                                        </h5>
                                        <small class="text-light">Publicado em <?= date('d/m/Y à\s H:i', strtotime($item['data_publicacao'])); ?></small>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <!-- Corpo do Modal (Conteúdo Completo) -->
                                <div class="modal-body fs-5 lh-base text-secondary-light" style="max-height: 70vh; overflow-y: auto;">
                                    <!-- Busque o campo 'conteudo' na sua query para exibi-lo aqui -->
                                    <?= nl2br(htmlspecialchars(utf8_encode($item['conteudo']))); ?>
                                </div>
                                
                                <!-- Rodapé do Modal -->
                                <div class="modal-footer border-secondary">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- FIM DO MODAL -->

                <?php endforeach; ?>
            </div>
        </div>
    </div>
  </main>
  <footer class="rodape">   
      <!-- Direitos Autorais no meio -->
      <div class="direitos">
        &copy; <?php echo date("Y"); ?> Todos os direitos reservados!
      </div>
      
      <!-- Redes Sociais na direita -->
      <div class="redes-sociais">
          <a href="#" target="_blank"><i class="bi bi-youtube"></i></a>
          <a href="#" target="_blank"><i class="bi bi-instagram"></i></a>
      </div>
  </footer>
  <script src="./script/dynamic-icons.js"></script>
</body>

</html>