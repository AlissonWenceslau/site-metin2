<?php
session_start();
require './utils/utils.php';

// --- INÍCIO DA LÓGICA DE PAGINAÇÃO ---
require_once '../connection/conn.php';
$dsn = "mysql:host=$servername;dbname=$dbaccount;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Configurações de exibição
$limitePorPagina = 5;
$paginaAtual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($paginaAtual < 1) {
    $paginaAtual = 1;
}

// Define o ponto inicial do banco de dados (OFFSET)
$offset = ($paginaAtual - 1) * $limitePorPagina;

$noticias = [];
$totalPaginas = 1;

try {
    $pdo = new PDO($dsn, $username, $password, $options);

    // 1. Conta o total de notícias existentes para calcular as páginas
    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM noticias");
    $totalNoticias = $stmtTotal->fetchColumn();
    $totalPaginas = ceil($totalNoticias / $limitePorPagina);
    if ($totalPaginas < 1) {
        $totalPaginas = 1;
    }

    // Garante que o usuário não tente acessar uma página além do limite existente
    if ($paginaAtual > $totalPaginas) {
        $paginaAtual = $totalPaginas;
        $offset = ($paginaAtual - 1) * $limitePorPagina;
    }

    // 2. Busca apenas as 5 notícias da página atual
    $stmt = $pdo->prepare("SELECT * FROM noticias ORDER BY data_publicacao DESC LIMIT :limite OFFSET :offset");
    $stmt->bindValue(':limite', $limitePorPagina, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $noticias = $stmt->fetchAll();

} catch (PDOException $e) {
    // Se a tabela não existir, silencia o erro para manter o site Metin2 online
    $noticias = [];
    $totalPaginas = 1;
}
// --- FIM DA LÓGICA DE PAGINAÇÃO ---
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
        <a href="../index.php" class="navbar-brand"><img src="../assets/metin2.png" class="img-fluid ms-1"
                alt="metin2"></a>
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
                        <a class="nav-link" href="rules.php"><i class="bi bi-book"></i>Regras</a>
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
                                href="./login.php"
                                style="letter-spacing: 0.5px; font-size: 0.85rem; transition: all 0.2s ease;">
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

    <main class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <h2 class="h3 mb-4 text-primary text-uppercase fw-bold"><i
                        class="bi bi-newspaper text-primary me-2"></i>Mural de Notícias</h2>

                <?php if (!empty($noticias)): ?>

                    <?php foreach ($noticias as $index => $item): ?>
                        <?php $isUltimaNoticia = ($index === 0 && $paginaAtual === 1); ?>

                        <div class="card bg-dark text-light border-secondary mb-3 shadow-sm hover-zoom"
                            style="transition: transform 0.2s; cursor: pointer;" data-bs-toggle="modal"
                            data-bs-target="#modalNoticia<?= $item['id']; ?>">

                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <?php if ($isUltimaNoticia): ?>
                                            <span class="badge bg-danger text-uppercase mb-2"
                                                style="font-size: 0.75rem; letter-spacing: 1px;">🔥 NOVIDADE</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary text-uppercase mb-2" style="font-size: 0.75rem;">📰
                                                Notícia</span>
                                        <?php endif; ?>
                                        <h4 class="card-title h5 mb-0 text-light fw-semibold">
                                            <?= htmlspecialchars($item['titulo']); ?>
                                        </h4>
                                    </div>
                                    <div class="text-end">
                                        <span
                                            class="text-light small d-block mb-1"><?= date('d/m/Y', strtotime($item['data_publicacao'])); ?></span>
                                    </div>
                                </div>

                                <?php if (isset($_SESSION['web']) && $_SESSION['web'] == 1): ?>
                                    <div class="text-end mt-3 border-top border-secondary pt-2 d-flex justify-content-end gap-2">
                                        <a href="/pages/adm/news/edit_new.php?id=<?= $item['id']; ?>"
                                            class="btn btn-outline-warning btn-sm p-1 px-2 fw-semibold" style="font-size: 0.8rem;"
                                            onclick="event.stopPropagation();">
                                            <i class="bi bi-pencil me-1"></i> Editar
                                        </a>
                                        <a href="excluir_noticia.php?id=<?= $item['id']; ?>"
                                            class="btn btn-outline-danger btn-sm p-1 px-2 fw-semibold" style="font-size: 0.8rem;"
                                            onclick="event.stopPropagation(); return confirm('⚠️ Tem certeza que deseja excluir esta notícia?\n\nEsta ação não poderá ser desfeita!');">
                                            <i class="bi bi-trash me-1"></i> Excluir
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="modal fade" id="modalNoticia<?= $item['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content bg-dark text-light border-secondary">

                                    <!-- Cabeçalho ajustado: d-flex modificado para alinhar itens no topo (start) -->
                                    <div class="modal-header border-secondary d-flex align-items-start justify-content-between">
                                        <div>
                                            <!-- Título Dinâmico -->
                                            <h5 class="modal-title text-warning fw-bold text-uppercase mb-1"
                                                id="modalNoticiaLabel<?= $item['id']; ?>">
                                                <?= htmlspecialchars($item['titulo']); ?>
                                            </h5>

                                            <!-- Linha de autoria movida para cá (Abaixo do título) -->
                                            <p class="text-white-50 small mb-0" style="font-size: 0.85rem;">
                                                Publicado por <strong
                                                    class="text-white fw-semibold"><?= htmlspecialchars($item['autor']); ?></strong>
                                                em <?= date('d/m/Y \à\s H:i', strtotime($item['data_publicacao'])); ?>
                                            </p>
                                        </div>

                                        <!-- Botão de fechar alinhado corretamente à direita -->
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Corpo do Modal limpo e focado no conteúdo -->
                                    <div class="modal-body" style="font-size: 1.05rem; line-height: 1.6;">
                                        <div class="text-break text-light-50">
                                            <?= nl2br(htmlspecialchars($item['conteudo'])); ?>
                                        </div>
                                    </div>

                                    <!-- Rodapé do Modal -->
                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($totalPaginas > 1): ?>
                        <nav aria-label="Navegação de páginas" class="mt-4">
                            <ul class="pagination justify-content-center">

                                <li class="page-item <?= $paginaAtual <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-value page-link bg-dark border-secondary text-light"
                                        href="?pagina=<?= $paginaAtual - 1; ?>" aria-label="Anterior">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>

                                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                    <li class="page-item <?= $paginaAtual === $i ? 'active' : ''; ?>">
                                        <a class="page-link border-secondary <?= $paginaAtual === $i ? 'bg-primary text-white border-primary' : 'bg-dark text-light'; ?>"
                                            href="?pagina=<?= $i; ?>">
                                            <?= $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <li class="page-item <?= $paginaAtual >= $totalPaginas ? 'disabled' : ''; ?>">
                                    <a class="page-value page-link bg-dark border-secondary text-light"
                                        href="?pagina=<?= $paginaAtual + 1; ?>" aria-label="Próximo">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>

                            </ul>
                        </nav>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="text-center text-light py-5 border border-secondary rounded bg-dark bg-opacity-25">
                        <p class="fs-5 mb-1">📡 Nenhuma notícia encontrada no momento.</p>
                        <small>Fique atento ao nosso mural para futuras atualizações!</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="rodape">
        <div class="direitos">
            &copy; <?php echo date("Y"); ?> Todos os direitos reservados!
        </div>

        <div class="redes-sociais">
            <a href="<?= $social['youtube'] ?>" target="_blank"><i class="bi bi-youtube"></i></a>
            <a href="<?= $social['instagram'] ?>" target="_blank"><i class="bi bi-instagram"></i></a>
        </div>
    </footer>
    <script src="../script/dynamic-icons.js"></script>
</body>

</html>