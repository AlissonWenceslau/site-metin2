<div class="modal fade" id="modalInstallNews" tabindex="-1" aria-labelledby="modalInstallNewsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-warning shadow-lg">

            <div class="modal-header border-secondary">
                <h5 class="modal-title text-warning fw-bold d-flex align-items-center gap-2" id="modalInstallNewsLabel">
                    <i class="bi bi-tools"></i> Assistente de Instalação
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Fechar"></button>
            </div>

            <div class="modal-body py-4">
                <p class="fs-5 mb-3 text-white fw-semibold">
                    Configuração do Sistema de Notícias
                </p>
                <p class="text-secondary small mb-4">
                    Este assistente automatiza a preparação do banco de dados para o módulo de notícias do site.
                </p>

                <div class="bg-secondary bg-opacity-10 border border-secondary rounded p-3 mb-4">
                    <h6 class="text-white fw-bold mb-3 small text-uppercase" style="letter-spacing: 0.5px;">
                        <i class="bi bi-info-circle text-primary me-1"></i> O que esta ação faz?
                    </h6>
                    <ul class="text-light small mb-0 ps-3 d-flex flex-column gap-2">
                        <li>Verifica e cria a estrutura da tabela de notícias.</li>
                        <li>Configura os gatilhos (triggers) automáticos de fuso horário.</li>
                        <li><span class="text-info fw-semibold">Atualiza as configurações</span> caso a tabela já exista
                            (sem apagar seus dados antigos).</li>
                        <li>Disponibilizará o link <span class="text-info fw-semibold">Publicar Nova Notícia</span> no seu painel.</li>
                    </ul>
                </div>

                <div
                    class="alert bg-warning bg-opacity-10 border border-warning border-opacity-50 text-light rounded p-3 mb-0">
                    <div class="d-flex align-items-center gap-2 mb-2 text-warning">
                        <i class="bi bi-database-fill-exclamation fs-5"></i>
                        <h6 class="fw-bold mb-0 text-uppercase" style="letter-spacing: 0.5px;">Local de Instalação:</h6>
                    </div>
                    <p class="mb-0 small">
                        As tabelas serão injetadas diretamente no banco de dados <strong
                            class="text-warning text-uppercase fw-bold bg-warning bg-opacity-25 px-2 py-0.5 rounded">account</strong>
                        do seu servidor de Metin2.
                    </p>
                </div>
            </div>

            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary fw-semibold text-uppercase px-3 small"
                    data-bs-dismiss="modal">Cancelar</button>
                <a href="../pages/adm/news/install_news.php"
                    class="btn btn-warning fw-bold text-dark text-uppercase px-4 shadow-sm small">
                    <i class="bi bi-play-fill me-1"></i> Executar Instalação
                </a>
            </div>

        </div>
    </div>
</div>