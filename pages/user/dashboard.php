<?php
session_start();
require '../utils/utils.php'
  ?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../../css/style.css">
  <title>Metin2</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="index.php" class="navbar-brand"><img src="../../assets/metin2.png" class="img-fluid ms-1" alt="metin2"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
      aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse responsive" id="navbarText">
      <div class="links-navegator">
        <ul class="navbar-nav" id="mainNav">
          <li class="nav-item">
            <a class="nav-link" href="../../index.php"><i class="bi bi-house-door"></i>Início</a>
          </li>
          <?php
          if (!$_SESSION['user']) {
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="../register.php"><i class="bi bi-person-plus"></i>Cadastrar</a>';
            echo '</li>';
          }
          ?>
          <li class="nav-item">
            <a class="nav-link" href="../download.php"><i class="bi bi-cloud-arrow-down"></i>Download</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../ranking.php"><i class="bi bi-trophy"></i>Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../rules.php"><i class="bi bi-shield-shaded me-2"></i>Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../status.php"><i class="bi bi-info-circle"></i>Status</a>
          </li>
        </ul>
      </div>
      <div class="logar">
        <ul class="navbar-nav align-items-center pe-3 pe-md-4">
          <li class="nav-item">
            <?php if (!$_SESSION['user']): ?>
              <a class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold text-uppercase d-inline-flex align-items-center gap-2"
                href="./pages/login.php" style="letter-spacing: 0.5px; font-size: 0.85rem; transition: all 0.2s ease;">
                <i class="bi bi-box-arrow-in-right fs-5"></i>
                <span>Entrar</span>
              </a>
            <?php endif; ?>
          </li>
        </ul>
        <?php
        avatar($_SESSION['user'], $avatarBackgroundColor, '../logout.php', '../change_password.php');
        ?>
      </div>
    </div>
  </nav>
  <main class="bg-light text-light min-vh-100 py-5">
    <div class="container">

      <?php
      // 1. Incluir a conexão existente e pegar o ID da conta logada
      require_once '../../connection/conn.php';

      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }

      $account_id = $_SESSION['account_id'] ?? null;

      if (!$account_id) {
        echo "<div class='alert alert-danger border-0 shadow-sm'>Erro: Usuário não autenticado.</div>";
        echo "</main>";
        exit;
      }

      try {
        // Criar conexões PDO para o banco player
        $pdo_player = new PDO("mysql:host=$servername;dbname=player;charset=utf8mb4", $username, $password);
        $pdo_player->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 2. LÓGICA DE TELETRANSPORTE (Processa quando o botão/link é clicado)
        if (isset($_GET['action']) && $_GET['action'] === 'unbug' && isset($_GET['char_name'])) {
          $char_name = $_GET['char_name'];

          // Primeiro, buscamos o reino (empire) para saber para qual cidade mandar
          $stmt_empire = $pdo_player->prepare("SELECT empire FROM player_index WHERE id = :account_id LIMIT 1");
          $stmt_empire->execute(['account_id' => $account_id]);
          $empire_data = $stmt_empire->fetch(PDO::FETCH_ASSOC);
          $empire_id = $empire_data['empire'] ?? 0;

          // Define as coordenadas padrão da Cidade 1 de cada Reino
          $map_index = 90;
          $x = 469300;
          $y = 964200; // Padrão Shinsoo
      
          if ($empire_id == 2) {
            $map_index = 21;
            $x = 55700;
            $y = 157900; // Chunjo
          } elseif ($empire_id == 3) {
            $map_index = 91;
            $x = 469300;
            $y = 964200; // Jinno
          }

          // Atualiza o personagem no banco (Garante que só altera se pertencer à conta logada por segurança)
          $stmt_unbug = $pdo_player->prepare("UPDATE player SET x = :x, y = :y, map_index = :map_index, exit_x = :x, exit_y = :y, exit_map_index = :map_index WHERE name = :char_name AND account_id = :account_id");
          $stmt_unbug->execute([
            'x' => $x,
            'y' => $y,
            'map_index' => $map_index,
            'char_name' => $char_name,
            'account_id' => $account_id
          ]);

          if ($stmt_unbug->rowCount() > 0) {
            echo "<div class='alert alert-success border-0 shadow-sm mb-4'><i class='bi bi-check-circle-fill me-2'></i> O personagem <strong>" . htmlspecialchars($char_name) . "</strong> foi enviado para a Cidade 1 com sucesso! Entre no jogo novamente daqui 15 minutos.</div>";
          }
        }

        // 3. Buscar o Reino (Empire) para exibição do Painel
        $stmt_empire = $pdo_player->prepare("SELECT empire FROM player_index WHERE id = :account_id LIMIT 1");
        $stmt_empire->execute(['account_id' => $account_id]);
        $empire_data = $stmt_empire->fetch(PDO::FETCH_ASSOC);
        $empire_id = $empire_data['empire'] ?? 0;

        switch ($empire_id) {
          case 1:
            $reino_nome = "Shinsoo";
            $reino_badge = "bg-danger";
            break;
          case 2:
            $reino_nome = "Chunjo";
            $reino_badge = "bg-warning text-dark";
            break;
          case 3:
            $reino_nome = "Jinno";
            $reino_badge = "bg-primary";
            break;
          default:
            $reino_nome = "Nenhum Reino";
            $reino_badge = "bg-secondary";
            break;
        }

        // 4. Buscar os Personagens ativos
        $stmt_chars = $pdo_player->prepare("SELECT name, level FROM player WHERE account_id = :account_id ORDER BY level DESC");
        $stmt_chars->execute(['account_id' => $account_id]);
        $personagens = $stmt_chars->fetchAll(PDO::FETCH_ASSOC);

      } catch (PDOException $e) {
        echo "<div class='alert alert-danger border-0 shadow-sm'>Erro de Conexão: " . htmlspecialchars($e->getMessage()) . "</div>";
        $personagens = [];
      }
      ?>

      <div class="row g-4 justify-content-center">
        <div class="col-12 col-lg-10">

          <div class="card bg-dark border-secondary p-4 rounded shadow-lg mb-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
              <div>
                <h2 class="h3 text-white fw-bold mb-1">
                  <i class="bi bi-grid-1x2-fill me-2 text-primary"></i>Painel do Personagem
                </h2>
                <p class="text-secondary small mb-0">Gerencie e destrave os heróis da sua conta.</p>
              </div>
              <div class="text-sm-end">
                <span class="text-secondary small text-uppercase fw-semibold d-block mb-1">Seu Reino</span>
                <span class="badge <?= $reino_badge; ?> fs-6 px-3 py-2 fw-bold text-uppercase rounded-pill shadow-sm">
                  <i class="bi bi-flag-fill me-1"></i> <?= $reino_nome; ?>
                </span>
              </div>
            </div>
          </div>

          <div class="card bg-dark text-light border-secondary p-4 rounded shadow-lg">
            <h3 class="h5 text-white-50 fw-semibold text-uppercase mb-4" style="letter-spacing: 0.5px;">
              <i class="bi bi-people me-2 text-primary"></i>Seus Personagens (<?= count($personagens); ?>/4)
            </h3>

            <?php if (empty($personagens)): ?>
              <div class="text-center py-5 border border-secondary border-dashed rounded bg-secondary bg-opacity-10">
                <i class="bi bi-person-exclamation fs-1 text-secondary-light"></i>
                <p class="text-secondary mt-2 mb-0">Nenhum personagem encontrado nesta conta.</p>
              </div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-dark table-hover align-middle border-secondary mb-0">
                  <thead>
                    <tr class="text-secondary small text-uppercase">
                      <th scope="col" class="pb-3" style="width: 80px;">Classe</th>
                      <th scope="col" class="pb-3">Nome do Herói</th>
                      <th scope="col" class="pb-3 text-center">Nível</th>
                      <th scope="col" class="pb-3 text-end">Ações de Suporte</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($personagens as $char): ?>
                      <tr>
                        <td>
                          <div
                            class="bg-secondary bg-opacity-25 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 42px; height: 42px;">
                            <i class="bi bi-shield-shaded fs-5"></i>
                          </div>
                        </td>
                        <td>
                          <span class="text-white fw-bold fs-6 d-block"><?= htmlspecialchars($char['name']); ?></span>
                          <span class="text-secondary small">ID da Conta: #<?= $account_id; ?></span>
                        </td>
                        <td class="text-center">
                          <span class="badge bg-secondary border border-secondary text-white fw-bold px-3 py-2 rounded">
                            Lv. <?= (int) $char['level']; ?>
                          </span>
                        </td>
                        <td class="text-end">
                          <a href="?action=unbug&char_name=<?= urlencode($char['name']); ?>"
                            class="btn btn-outline-warning btn-sm fw-semibold py-2 px-3 action-btn d-inline-flex align-items-center gap-1 shadow-sm"
                            onclick="return confirm('Tem certeza que deseja enviar <?= htmlspecialchars($char['name']); ?> para a Cidade 1? Certifique-se de estar deslogado do jogo.');">
                            <i class="bi bi-geo-alt-fill"></i> Mandar para Cidade
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>

          </div>

        </div>
      </div>
    </div>
  </main>

  <style>
    .border-dashed {
      border-style: dashed !important;
    }

    .table-hover tbody tr:hover {
      background-color: rgba(255, 255, 255, 0.03) !important;
      transition: background-color 0.15s ease-in-out;
    }

    /* Estilização suave para o botão de ação */
    .action-btn {
      transition: all 0.2s ease-in-out;
      border-color: rgba(255, 193, 7, 0.4);
    }

    .action-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 0.25rem 0.75rem rgba(255, 193, 7, 0.15);
    }
  </style>
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