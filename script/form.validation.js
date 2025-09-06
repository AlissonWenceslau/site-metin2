// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()

setTimeout(function () {
  var mensagensErro = document.querySelectorAll('.alert-success');
  mensagensErro.forEach(function (mensagem) {
    mensagem.style.display = 'none';
  });
}, 5000);


// Validação do checkbox de termos
let checkBoxTerms = document.querySelector('.form-check-input');
if (checkBoxTerms) {
  checkBoxTerms.addEventListener('click', () => {
    let submitButton = document.querySelector('#submit');
    if (submitButton) {
      submitButton.disabled = !checkBoxTerms.checked;
    }
  });
}

// Mostrar/ocultar senha
let checkBoxShowPassword = document.getElementById('showPasword');
if (checkBoxShowPassword) {
  checkBoxShowPassword.addEventListener('click', function () {
    let inputs = document.querySelectorAll('input[type="password"], input[type="text"].campo-senha');
    inputs.forEach(input => {
      input.type = this.checked ? 'text' : 'password';
    });
  });
}