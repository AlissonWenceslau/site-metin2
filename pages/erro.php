<?php
session_start();
require './utils/utils.php'
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="../assets/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/style.css">
  <title>Metin2</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="#" class="navbar-brand"><img src="../assets/metin2.png" class="img-fluid ms-1" alt="metin2"></a>
  </nav>
  <main class="d-flex flex-column erro-register">
    <h1 class="text text-primary text-center">Login ou e-mail já existente.</h1>
    <p><a class="btn btn-primary" href="../index.php">Voltar a página princial</a></p>
  </main>
  <footer class="rodape">   
      <!-- Direitos Autorais no meio -->
      <div class="direitos">
        &copy; <?php echo date("Y"); ?> Todos os direitos reservados!
      </div>
      
      <!-- Redes Sociais na direita -->
      <div class="redes-sociais">
          <a href="#" target="_blank"><i class="bi bi-youtube"></i></a>
          <a href="#" target="_blank"><i class="bi bi-instagram"></i></a>
      </div>
  </footer>
</body>

</html>