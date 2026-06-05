<div class="modal fade" id="modalConfirmarTeleporte" tabindex="-1" aria-labelledby="modalConfirmarTeleporteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-warning shadow-lg">

            <div class="modal-header border-secondary">
                <h5 class="modal-title text-warning fw-bold d-flex align-items-center gap-2"
                    id="modalConfirmarTeleporteLabel">
                    <i class="bi bi-exclamation-triangle-fill"></i> ATENÇÃO: Confirmar Ação
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p class="fs-5 mb-3 text-white">
                    Deseja enviar o personagem <strong id="modalCharName"
                        class="text-warning text-decoration-underline"></strong> para a Cidade 1?
                </p>

                <div class="alert bg-warning bg-opacity-10 border border-warning border-opacity-50 rounded p-3 mb-0">
                    <h6 class="text-warning fw-bold mb-2 d-flex align-items-center gap-1"
                        style="letter-spacing: 0.5px;">
                        <i class="bi bi-clock-history fs-5"></i> REGRA CRUCIAL:
                    </h6>
                    <p class="text-light mb-2 small">
                        Seu personagem <strong class="text-warning fw-bold">DEVE estar totalmente DESLOGADO</strong> do
                        jogo por
                        pelo menos <strong class="text-warning fw-bold">2 MINUTOS</strong>.
                    </p>
                    <p class="text-white-50 mb-0 small">
                        Se você deslogou agora ou está com o jogo aberto, feche-o, feche este aviso, aguarde o tempo e
                        tente
                        novamente. Caso contrário, a ação não surtirá efeito.
                    </p>
                </div>
            </div>

            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary fw-semibold text-uppercase px-3"
                    data-bs-dismiss="modal">Cancelar</button>
                <a id="btnConfirmarTeleporte" href="#"
                    class="btn btn-warning fw-bold text-dark text-uppercase px-4 shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Confirmar e Enviar
                </a>
            </div>

        </div>
    </div>
</div>