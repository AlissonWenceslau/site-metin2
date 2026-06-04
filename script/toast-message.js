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

//PÁGINA DE CADASTRO
document.addEventListener('DOMContentLoaded', function () {
    // Exibe toast de sucesso
    var toastSucessoEl = document.getElementById('toastRegSucesso');
    if (toastSucessoEl) {
    var toastSucesso = new bootstrap.Toast(toastSucessoEl);
    toastSucesso.show();
    }

    // Exibe lista de toasts de erro
    var toastErroEls = document.querySelectorAll('[id^="toastRegErro_"]');
    toastErroEls.forEach(function (element) {
    var toastErro = new bootstrap.Toast(element);
    toastErro.show();
    });
});

//PÁGINA ADICIONAR CASH
document.addEventListener('DOMContentLoaded', function () {
// Dispara toast de sucesso se houver
var toastSucessoEl = document.getElementById('toastCashSucesso');
if (toastSucessoEl) {
    var toastSucesso = new bootstrap.Toast(toastSucessoEl);
    toastSucesso.show();
}

// Dispara lista de toasts de erro se houver
var toastErroEls = document.querySelectorAll('[id^="toastCashErro_"]');
toastErroEls.forEach(function (element) {
    var toastErro = new bootstrap.Toast(element);
    toastErro.show();
});
});

//PÁGINA ALTERAR SENHA
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa e exibe o toast de sucesso se ele existir
    var toastSucessoEl = document.getElementById('toastSenhaSucesso');
    if (toastSucessoEl) {
        var toastSucesso = new bootstrap.Toast(toastSucessoEl);
        toastSucesso.show();
    }

    // Inicializa e exibe todos os toasts de erro se existirem
    var toastErroEls = document.querySelectorAll('[id^="toastSenhaErro_"]');
    toastErroEls.forEach(function(element) {
        var toastErro = new bootstrap.Toast(element);
        toastErro.show();
    });
});