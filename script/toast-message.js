document.addEventListener("DOMContentLoaded", function() {
    // Procura se o toast de sucesso existe na página e o exibe
    var eleSucesso = document.getElementById('toastSucesso');
    if (eleSucesso) {
        var toastSucesso = new bootstrap.Toast(eleSucesso);
        toastSucesso.show();
    }

    // Procura se o toast de erro existe na página e o exibe
    var eleErro = document.getElementById('toastErro');
    if (eleErro) {
        var toastErro = new bootstrap.Toast(eleErro);
        toastErro.show();
    }
});