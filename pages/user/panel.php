<?php
require_once __DIR__ . '/../../auth/auth.php';
protectPage('../login.php'); 
?>
<div class="card bg-dark border-0 shadow-lg mt-2 overflow-hidden text-light"
    style="border-radius: 12px; background: linear-gradient(145deg, #15181c, #0b0d10);">

    <div
        class="p-4 border-bottom border-secondary border-opacity-10 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <h6 class="mb-0 text-primary text-uppercase fw-bold tracking-wide" style="letter-spacing: 1px;">
                    <i class="bi bi-person-box me-1"></i> Painel do Usuário
                </h6>
                <?php if (isset($_SESSION['web']) && $_SESSION['web'] == 1): ?>
                    <span
                        class="badge bg-success bg-opacity-10 border border-success text-success px-2 py-1 fw-bold tracking-wider"
                        style="font-size: 0.65rem;">
                        <i class="bi bi-controller me-1"></i> ADMIN
                    </span>
                <?php endif; ?>
            </div>
            <div class="text-white-50 small">
                <i class="bi bi-person-circle text-primary me-1"></i>
                Olá <strong><?= strtoupper(htmlspecialchars($_SESSION['user'])) ?></strong>, seja bem-vindo ao seu
                painel!
            </div>
        </div>

        <div class="bg-black bg-opacity-40 border border-secondary border-opacity-20 rounded-3 p-3 d-flex align-items-center gap-3 shadow-sm"
            style="min-width: 200px;">
            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2.5 d-flex align-items-center justify-content-center border border-success border-opacity-20"
                style="width: 42px; height: 42px;">
                <i class="bi bi-cash-coin fs-5"></i>
            </div>
            <div>
                <span class="text-white-50 d-block small fw-semibold"
                    style="font-size: 0.7rem; letter-spacing: 0.5px; text-uppercase: uppercase;">Saldo Atual</span>
                <span class="text-success fw-bold fs-5 tracking-tight"><?= number_format($_SESSION['cash']) ?> <span
                        class="fs-7 text-success text-opacity-70 fw-medium">Cash</span></span>
            </div>
        </div>
    </div>

    <div class="p-4">
        <span class="text-white-50 fw-bold small text-uppercase d-block mb-3 tracking-wider"
            style="font-size: 0.7rem; letter-spacing: 0.5px;">Ações Disponíveis</span>

        <div class="row g-3">

            <div class="col-12 col-md-4">
                <a href="./pages/user/dashboard.php" class="card-action-link">
                    <div class="card-premium p-3 border border-secondary border-opacity-10">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="action-icon bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-white fw-bold">Seus Personagens</h6>
                                <p class="text-white-50 mb-0 card-desc">Gerenciar heróis e desbugar posição.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <?php if (isset($_SESSION['web']) && $_SESSION['web'] == 1): ?>
                <div class="col-12 col-md-4">
                    <a href="../pages/adm/add_cash.php" class="card-action-link">
                        <div class="card-premium p-3 border border-secondary border-opacity-10">
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    class="action-icon bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-white fw-bold">Adicionar Cash</h6>
                                    <p class="text-white-50 mb-0 card-desc">Injetar moedas nas contas do servidor.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['web']) && $_SESSION['web'] == 1): ?>
                <div class="col-12 col-md-4">
                    <?php if (isset($_SESSION['news_system']) && $_SESSION['news_system'] === 'success'): ?>
                        <a href="../pages/adm/news/add_news.php" class="card-action-link">
                            <div class="card-premium p-3 border border-secondary border-opacity-10">
                                <div class="d-flex align-items-center gap-3">
                                    <div
                                        class="action-icon bg-success bg-opacity-10 text-success border border-success border-opacity-20">
                                        <i class="bi bi-newspaper"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-white fw-bold">Publicar Notícia</h6>
                                        <p class="text-white-50 mb-0 card-desc">Gerenciar e criar novos comunicados.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php else: ?>
                        <a href="#" class="card-action-link" data-bs-toggle="modal" data-bs-target="#modalInstallNews">
                            <div class="card-premium p-3 border border-danger border-opacity-20 bg-danger bg-opacity-5">
                                <div class="d-flex align-items-center gap-3">
                                    <div
                                        class="action-icon bg-danger bg-opacity-10 text-danger border border-danger border-opacity-20">
                                        <i class="bi bi-gear-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-white fw-bold">Instalar Notícias</h6>
                                        <p class="text-danger-light mb-0 card-desc">Configurar tabelas do sistema de notícias.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
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