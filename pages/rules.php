<?php
session_start();
require './utils/utils.php'
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
            <a class="nav-link" href="download.php"><i class="bi bi-cloud-arrow-down"></i>Download</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ranking.php"><i class="bi bi-trophy"></i>Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="rules.php"><i class="bi bi-shield-shaded me-2"></i>Regras</a>
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
  <main>
    <div class="content d-flex align-items-center mt-5 mb-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8">

            <div class="text-center mb-5">
              <h2 class="h3 text-primary text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">
                <i class="bi bi-shield-shaded me-2"></i>Diretrizes e Regras do Servidor
              </h2>
              <p class="text-white-50 small">Siga as regras para garantir uma comunidade justa e divertida para todos os
                guerreiros.</p>
            </div>

            <div class="accordion accordion-flush shadow" id="accordionRegras">

              <div class="accordion-item bg-dark text-light border border-secondary mb-2 rounded">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed bg-dark text-white fw-semibold" type="button"
                    data-bs-toggle="collapse" data-bs-target="#regra1" aria-expanded="false" aria-controls="regra1">
                    <span class="badge bg-danger me-3">01</span>
                    <i class="bi bi-cpu-fill text-danger me-2"></i> Uso de Hacks / Bots
                  </button>
                </h2>
                <div id="regra1" class="accordion-collapse collapse" data-bs-parent="#accordionRegras">
                  <div class="accordion-body border-top border-secondary text-white-50 bg-secondary bg-opacity-10 py-4">
                    É proibido usar programas externos para ganhar vantagem (auto-farm, speed, etc). O uso acarreta em
                    punição severa e permanente.
                  </div>
                </div>
              </div>

              <div class="accordion-item bg-dark text-light border border-secondary mb-2 rounded">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed bg-dark text-white fw-semibold" type="button"
                    data-bs-toggle="collapse" data-bs-target="#regra2" aria-expanded="false" aria-controls="regra2">
                    <span class="badge bg-danger me-3">02</span>
                    <i class="bi bi-cash-stack text-warning me-2"></i> Comércio por Dinheiro Real (RMT)
                  </button>
                </h2>
                <div id="regra2" class="accordion-collapse collapse" data-bs-parent="#accordionRegras">
                  <div class="accordion-body border-top border-secondary text-white-50 bg-secondary bg-opacity-10 py-4">
                    Vender ou comprar itens, contas ou moedas do jogo por dinheiro real é terminantemente proibido e
                    monitorado pelos logs do sistema.
                  </div>
                </div>
              </div>

              <div class="accordion-item bg-dark text-light border border-secondary mb-2 rounded">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed bg-dark text-white fw-semibold" type="button"
                    data-bs-toggle="collapse" data-bs-target="#regra3" aria-expanded="false" aria-controls="regra3">
                    <span class="badge bg-danger me-3">03</span>
                    <i class="bi bi-bug-fill text-info me-2"></i> Abuso de Bugs
                  </button>
                </h2>
                <div id="regra3" class="accordion-collapse collapse" data-bs-parent="#accordionRegras">
                  <div class="accordion-body border-top border-secondary text-white-50 bg-secondary bg-opacity-10 py-4">
                    Explorar falhas e vulnerabilidades no jogo ou mapa para benefício próprio ou de terceiros pode levar
                    ao banimento imediato da conta. Reporte os bugs encontrados à Staff.
                  </div>
                </div>
              </div>

              <div class="accordion-item bg-dark text-light border border-secondary mb-2 rounded">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed bg-dark text-white fw-semibold" type="button"
                    data-bs-toggle="collapse" data-bs-target="#regra4" aria-expanded="false" aria-controls="regra4">
                    <span class="badge bg-danger me-3">04</span>
                    <i class="bi bi-chat-square-quote-fill text-primary me-2"></i> Ofensas e Discurso de Ódio
                  </button>
                </h2>
                <div id="regra4" class="accordion-collapse collapse" data-bs-parent="#accordionRegras">
                  <div class="accordion-body border-top border-secondary text-white-50 bg-secondary bg-opacity-10 py-4">
                    Não é permitido insultar outros jogadores, criar intrigas generalizadas ou usar linguagem ofensiva,
                    racista, preconceituosa e tóxica. Mantenha o respeito mútuo.
                  </div>
                </div>
              </div>

              <div class="accordion-item bg-dark text-light border border-secondary mb-2 rounded">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed bg-dark text-white fw-semibold" type="button"
                    data-bs-toggle="collapse" data-bs-target="#regra5" aria-expanded="false" aria-controls="regra5">
                    <span class="badge bg-danger me-3">05</span>
                    <i class="bi bi-person-exclamation text-danger me-2"></i> Fake de Staff / Admin
                  </button>
                </h2>
                <div id="regra5" class="accordion-collapse collapse" data-bs-parent="#accordionRegras">
                  <div class="accordion-body border-top border-secondary text-white-50 bg-secondary bg-opacity-10 py-4">
                    Fingir ser parte da equipe do servidor (GM, GA, ADM), criar nicks parecidos ou solicitar dados
                    cadastrais de outros jogadores é crime virtual e passível de ban por IP.
                  </div>
                </div>
              </div>

              <div class="accordion-item bg-dark text-light border border-secondary mb-2 rounded">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed bg-dark text-white fw-semibold" type="button"
                    data-bs-toggle="collapse" data-bs-target="#regra6" aria-expanded="false" aria-controls="regra6">
                    <span class="badge bg-danger me-3">06</span>
                    <i class="bi bi-megaphone-fill text-warning Tri me-2"></i> Spam e Flood no Chat
                  </button>
                </h2>
                <div id="regra6" class="accordion-collapse collapse" data-bs-parent="#accordionRegras">
                  <div class="accordion-body border-top border-secondary text-white-50 bg-secondary bg-opacity-10 py-4">
                    Enviar mensagens idênticas ou sem sentido repetidas vezes nos canais globais, de comércio ou chat
                    comum polui a tela e é proibido.
                  </div>
                </div>
              </div>

              <div class="accordion-item bg-dark text-light border border-secondary mb-2 rounded">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed bg-dark text-white fw-semibold" type="button"
                    data-bs-toggle="collapse" data-bs-target="#regra7" aria-expanded="false" aria-controls="regra7">
                    <span class="badge bg-danger me-3">07</span>
                    <i class="bi bi-sword text-secondary me-2"></i> KS (Kill Steal)
                  </button>
                </h2>
                <div id="regra7" class="accordion-collapse collapse" data-bs-parent="#accordionRegras">
                  <div class="accordion-body border-top border-secondary text-white-50 bg-secondary bg-opacity-10 py-4">
                    Roubar propositalmente monstros, chefes ou pedras Metin que outro jogador já está enfrentando
                    ativamente é contra a conduta ética do servidor.
                  </div>
                </div>
              </div>

              <div class="accordion-item bg-dark text-light border border-secondary mb-2 rounded">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed bg-dark text-white fw-semibold" type="button"
                    data-bs-toggle="collapse" data-bs-target="#regra8" aria-expanded="false" aria-controls="regra8">
                    <span class="badge bg-danger me-3">08</span>
                    <i class="bi bi-broadcast text-info me-2"></i> Divulgação de outros Servidores
                  </button>
                </h2>
                <div id="regra8" class="accordion-collapse collapse" data-bs-parent="#accordionRegras">
                  <div class="accordion-body border-top border-secondary text-white-50 bg-secondary bg-opacity-10 py-4">
                    Fazer propaganda, citar ou divulgar links de outros servidores de Metin2 dentro de qualquer canal de
                    comunicação do nosso jogo acarretará banimento imediato.
                  </div>
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
      <a href="#" target="_blank"><i class="bi bi-youtube"></i></a>
      <a href="#" target="_blank"><i class="bi bi-instagram"></i></a>
    </div>
  </footer>
</body>

</html>