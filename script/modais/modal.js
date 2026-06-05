//MODAL DO PAINEL dashboard.php
document.addEventListener('DOMContentLoaded', function () {
    var modalConfirmar = document.getElementById('modalConfirmarTeleporte');

    if (modalConfirmar) {
        modalConfirmar.addEventListener('show.bs.modal', function (event) {
            // Botão que disparou o modal
            var button = event.relatedTarget;

            // Extrai as informações dos atributos data-*
            var charName = button.getAttribute('data-charname');
            var targetUrl = button.getAttribute('data-url');

            // Atualiza os elementos internos do modal
            var modalTitleChar = modalConfirmar.querySelector('#modalCharName');
            var modalActionBtn = modalConfirmar.querySelector('#btnConfirmarTeleporte');

            modalTitleChar.textContent = charName;
            modalActionBtn.setAttribute('href', targetUrl);
        });
    }
});