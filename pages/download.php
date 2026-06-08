<?php
session_start();
require './utils/utils.php';
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="../assets/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/style.css">
  <title>Metin2</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="../index.php" class="navbar-brand"><img src="../assets/metin2.png" class="img-fluid ms-1" alt="metin2"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
      aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse responsive" id="navbarText">
      <div class="links-navegator">
        <ul class="navbar-nav" id="mainNav">
          <li class="nav-item">
            <a class="nav-link" href="../index.php"><i class="bi bi-house-door"></i>Início</a>
          </li>
          <?php
          if (!$_SESSION['user']) {
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="register.php"><i class="bi bi-person-plus"></i>Cadastrar</a>';
            echo '</li>';
          }
          ?>
          <li class="nav-item">
            <a class="nav-link active" href="download.php"><i class="bi bi-cloud-arrow-down"></i>Download</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ranking.php"><i class="bi bi-trophy"></i>Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="rules.php"><i class="bi bi-shield-shaded me-2"></i>Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="status.php"><i class="bi bi-info-circle"></i>Status</a>
          </li>
        </ul>
      </div>
      <div class="logar">
        <ul class="navbar-nav align-items-center pe-3 pe-md-4">
          <li class="nav-item">
            <?php if (!$_SESSION['user']): ?>
              <a class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold text-uppercase d-inline-flex align-items-center gap-2"
                href="./login.php" style="letter-spacing: 0.5px; font-size: 0.85rem; transition: all 0.2s ease;">
                <i class="bi bi-box-arrow-in-right fs-5"></i>
                <span>Entrar</span>
              </a>
            <?php endif; ?>
          </li>
        </ul>
        <?php
        avatar($_SESSION['user'], $avatarBackgroundColor, 'logout.php', './change_password.php');
        ?>
      </div>
    </div>
  </nav>
  <main class="bg-white text-dark min-vh-100 py-5">
    <div class="content">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8">

            <div class="text-center mb-5 bg-dark p-4 rounded border border-secondary shadow-sm">
              <h2 class="h3 text-white text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">
                <i class="bi bi-cloud-arrow-down-fill me-2 text-primary"></i>Central de Download
              </h2>
              <p class="text-white-50 small mb-0">Baixe o cliente oficial e comece sua jornada hoje mesmo.</p>
            </div>

            <div class="text-center mb-5 p-4 rounded bg-light border border-secondary-subtle shadow-sm">
              <p class="fw-semibold text-ligth mb-2 small text-uppercase" style="letter-spacing: 0.5px;">Cliente Oficial
                Completo</p>
              <a class="btn btn-primary btn-lg px-5 py-3 fw-bold text-uppercase d-inline-flex align-items-center gap-2 download-btn shadow"
                href="#LinkAqui" role="button">
                <i class="bi bi-download fs-5"></i> Fazer Download do Jogo
              </a>
              <div class="text-ligth small mt-2">
                <i class="bi bi-shield-check text-success me-1"></i> Arquivo verificado e seguro contra vírus.
              </div>
            </div>

            <div class="card bg-dark text-light border-secondary shadow-sm">
              <div class="card-header bg-transparent border-secondary py-3">
                <h3 class="h6 text-uppercase fw-bold text-primary mb-0 d-flex align-items-center gap-2"
                  style="letter-spacing: 0.5px;">
                  <i class="bi bi-cpu text-warning"></i> Requisitos Recomendados do Sistema
                </h3>
              </div>

              <div class="card-body p-0">
                <div class="row g-0 spec-row border-bottom border-secondary-subtle">
                  <div
                    class="col-4 p-3 fw-bold text-ligth text-uppercase small bg-secondary bg-opacity-10 d-flex align-items-center">
                    <i class="bi bi-windows me-2 text-info"></i> Sistema
                  </div>
                  <div class="col-8 p-3 text-white fw-medium">Windows 10+</div>
                </div>

                <div class="row g-0 spec-row border-bottom border-secondary-subtle">
                  <div
                    class="col-4 p-3 fw-bold text-ligth text-uppercase small bg-secondary bg-opacity-10 d-flex align-items-center">
                    <i class="bi bi-cpu-fill me-2 text-primary"></i> Processador
                  </div>
                  <div class="col-8 p-3 text-white fw-medium">Intel Core i5 ou equivalente</div>
                </div>

                <div class="row g-0 spec-row border-bottom border-secondary-subtle">
                  <div
                    class="col-4 p-3 fw-bold text-ligth text-uppercase small bg-secondary bg-opacity-10 d-flex align-items-center">
                    <i class="bi bi-memory me-2 text-danger"></i> Memória RAM
                  </div>
                  <div class="col-8 p-3 text-white fw-medium">4 GB de RAM</div>
                </div>

                <div class="row g-0 spec-row border-bottom border-secondary-subtle">
                  <div
                    class="col-4 p-3 fw-bold text-ligth text-uppercase small bg-secondary bg-opacity-10 d-flex align-items-center">
                    <i class="bi bi-gpu-card me-2 text-success"></i> Placa de Vídeo
                  </div>
                  <div class="col-8 p-3 text-white fw-medium">NVIDIA GeForce GTX 1060</div>
                </div>

                <div class="row g-0 spec-row border-bottom border-secondary-subtle">
                  <div
                    class="col-4 p-3 fw-bold text-ligth text-uppercase small bg-secondary bg-opacity-10 d-flex align-items-center">
                    <i class="bi bi-box-seam me-2 text-warning"></i> DirectX
                  </div>
                  <div class="col-8 p-3 text-white fw-medium">DirectX 9.0c ou mais recente</div>
                </div>

                <div class="row g-0 spec-row border-bottom border-secondary-subtle">
                  <div
                    class="col-4 p-3 fw-bold text-ligth text-uppercase small bg-secondary bg-opacity-10 d-flex align-items-center">
                    <i class="bi bi-hdd-fill me-2 text-info"></i> Disco Rígido
                  </div>
                  <div class="col-8 p-3 text-white fw-medium">8 GB de espaço livre</div>
                </div>

                <div class="row g-0 spec-row">
                  <div
                    class="col-4 p-3 fw-bold text-ligth text-uppercase small bg-secondary bg-opacity-10 d-flex align-items-center">
                    <i class="bi bi-router-fill me-2 text-light"></i> Internet
                  </div>
                  <div class="col-8 p-3 text-white fw-medium">Conexão de Banda Larga</div>
                </div>
              </div>
            </div>

          </div>
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
      <a href="<?= $social['youtube']?>" target="_blank"><i class="bi bi-youtube"></i></a>
      <a href="<?= $social['instagram'] ?>" target="_blank"><i class="bi bi-instagram"></i></a>
    </div>
  </footer>
  <script src="../script/dynamic-icons.js"></script>

</html>