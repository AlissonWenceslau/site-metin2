<div class="card bg-dark text-light border-secondary mt-2 shadow-sm">

    <div class="card-header border-secondary bg-secondary bg-opacity-10 p-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0 text-primary text-uppercase fw-bold" style="letter-spacing: 0.5px;">
                <i class="bi bi-person-box me-1"></i> Painel do Usuário
            </h6>

            <span class="badge bg-success text-white p-2 fw-semibold fs-7 shadow-sm">
                <i class="bi bi-cash-coin me-1"></i>
                <?= number_format($_SESSION['cash']) ?> Cash
            </span>
        </div>
        <?php if (isset($_SESSION['web']) && $_SESSION['web'] == 1): ?>
            <div class="badge bg-success bg-opacity-25 border border-success text-success px-2.5 py-1.5 fw-bold">
                <i class="bi bi-controller me-1"></i> ADMIN
            </div>
        <?php endif; ?>

        <div class="text-white mt-2 small">
            <i class="bi bi-person-circle text-primary me-1"></i>
            Olá <?php echo '<strong>' . strtoupper(htmlspecialchars($_SESSION['user'])) . '</strong>'; ?>, seja
            bem-vindo ao seu painel!
        </div>

    </div>

    <ul class="list-group list-group-flush bg-transparent border-secondary">

        <li class="list-group-item bg-dark border-secondary py-3">
            <i class="bi bi-people me-2 text-primary"></i>
            <a href="./pages/user/dashboard.php" class="text-white text-decoration-none hover-link">Seus Personagens</a>
        </li>

        <?php if (isset($_SESSION['web']) && $_SESSION['web'] == 1): ?>
            <li class="list-group-item bg-dark border-secondary py-3">
                <i class="bi bi-cash-coin me-2 text-warning"></i>
                <a href="../pages/adm/add_cash.php" class="text-white text-decoration-none hover-link">Adicionar Cash</a>
            </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['web']) && $_SESSION['web'] == 1): ?>

            <?php if (isset($_SESSION['news_system']) && $_SESSION['news_system'] === 'success'): ?>
                <li class="list-group-item bg-dark border-secondary py-3">
                    <i class="bi bi-newspaper me-2 text-warning"></i>
                    <a href="../pages/adm/news/add_news.php" class="text-white text-decoration-none hover-link">Publicar Nova
                        Notícia</a>
                </li>
            <?php else: ?>
                <li class="list-group-item bg-dark border-secondary py-3">
                    <a href="#" class="text-white text-decoration-none hover-link d-inline-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#modalInstallNews">
                        <i class="bi bi-gear-fill text-warning"></i> Instalar sistema de notícia
                    </a>
                </li>
            <?php endif; ?>

        <?php endif; ?>
    </ul>
</div>
<?php
// Forçamos o uso do caminho real relativo ao diretório deste arquivo
$caminho_modal = __DIR__ . '/../adm/news/modais/modal-install-news.php';

if (file_exists($caminho_modal)) {
    include_once $caminho_modal;
} else {
    // Se o arquivo sumir, este aviso vai aparecer no HTML em formato de comentário para você debugar o caminho
    echo "";
}
?>

<style>
    .hover-link {
        transition: color 0.2s ease;
    }

    .hover-link:hover {
        color: #0d6efd !important;
        /* Brilha em azul ao passar o mouse */
        text-decoration: underline !important;
    }

    .fs-7 {
        font-size: 0.85rem;
    }
</style>