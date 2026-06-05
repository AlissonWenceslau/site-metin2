<div class="modal fade" id="modalExcluirNoticia" tabindex="-1" aria-labelledby="modalExcluirNoticiaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-danger shadow-lg" style="border-radius: 10px;">
            
            <div class="modal-header border-secondary border-opacity-20">
                <h5 class="modal-title text-danger fw-bold d-flex align-items-center gap-2" id="modalExcluirNoticiaLabel">
                    <i class="bi bi-exclamation-triangle-fill"></i> Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            
            <div class="modal-body py-4">
                <p class="fs-5 mb-2 text-white fw-semibold">
                    Deseja mesmo remover esta publicação?
                </p>
                <p class="text-white-50 small mb-4">
                    Esta ação não poderá ser desfeita. A notícia selecionada será apagada permanentemente do banco de dados do seu servidor.
                </p>
                
                <div class="alert bg-danger bg-opacity-5 border border-danger border-opacity-15 text-light rounded p-3 mb-0 small">
                    <div class="d-flex align-items-center gap-2 mb-1 text-danger fw-bold">
                        <i class="bi bi-shield-lock-fill text-light"></i>
                        <span class="text-light">REQUISITO DO SISTEMA:</span>
                    </div>
                    <p class="mb-0 text-white-50">
                        O comunicado sairá do mural do site para todos os jogadores no exato milissegundo em que você confirmar a ação.
                    </p>
                </div>
            </div>
            
            <div class="modal-footer border-secondary border-opacity-20">
                <button type="button" class="btn btn-secondary fw-semibold text-uppercase px-3 small" data-bs-dismiss="modal">Cancelar</button>
                <a id="btnConfirmarExclusao" href="#" class="btn btn-danger fw-bold text-white text-uppercase px-4 shadow-sm small">
                    <i class="bi bi-trash-fill me-1"></i> Deletar Agora
                </a>
            </div>

        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalExcluir = document.getElementById('modalExcluirNoticia');
    
    if (modalExcluir) {
        modalExcluir.addEventListener('show.bs.modal', function (event) {
            // Botão que disparou o modal
            var button = event.relatedTarget;
            
            // Extrai a URL do atributo data-url
            var targetUrl = button.getAttribute('data-url');
            
            // Atualiza o link do botão de confirmação dentro do modal
            var modalActionBtn = modalExcluir.querySelector('#btnConfirmarExclusao');
            modalActionBtn.setAttribute('href', targetUrl);
        });
    }
});
</script>