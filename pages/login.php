<?php
session_start();
if (isset($_SESSION['user'])) {
    // Usuário não logado, redireciona para a página de login
    header("Location: ../index.php");
    exit;
}
require './utils/utils.php'
    ?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Metin2</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a href="../index.php" class="navbar-brand"><img src="../assets/metin2.png" class="img-fluid ms-1"
                alt="metin2"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse responsive" id="navbarText">
            <div class="links-navegator">
                <ul class="navbar-nav">
                    <li class="nav-item" id="mainNav">
                        <a class="nav-link" href="../index.php"><i class="bi bi-house-door"></i>Início</a>
                    </li>
                    <?php
                    if (!$_SESSION['user']) {
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="register.php"><i class="bi bi-person-plus"></i>Cadastrar</a>';
                        echo '</li>';
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="download.php"><i class="bi bi-cloud-arrow-down"></i>Download</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ranking.php"><i class="bi bi-trophy"></i>Ranking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rules.php"><i class="bi bi-shield-shaded me-2"></i>Regras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="status.php"><i class="bi bi-info-circle"></i>Status</a>
                    </li>
                </ul>
            </div>
            <?php
            avatar($_SESSION['user'], $avatarBackgroundColor, 'logout.php');
            ?>
        </div>
        </div>
    </nav>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['error'])):
            ?>
            <div id="toastLoginErro" class="toast align-items-center text-white bg-danger border-0 shadow" role="alert"
                aria-live="assertive" aria-atomic="true" data-bs-delay="6000">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">
                        <i class="bi bi-person-fill-x me-2 fs-5"></i> <?= htmlspecialchars($_SESSION['error']); ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['error'])):
            ?>
            <div id="toastLoginErro" class="toast align-items-center text-white bg-danger border-0 shadow" role="alert"
                aria-live="assertive" aria-atomic="true" data-bs-delay="6000">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">
                        <i class="bi bi-person-fill-x me-2 fs-5"></i> <?= htmlspecialchars($_SESSION['error']); ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>

    <main class="bg-light text-light min-vh-100 py-5 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-7 col-lg-5 col-xl-4">

                    <div class="text-center mb-4 bg-dark p-4 rounded border border-secondary shadow-sm">
                        <h2 class="h4 text-white text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">
                            <i class="bi bi-box-arrow-in-right me-2 text-primary"></i>Acesse sua Conta
                        </h2>
                        <p class="text-white-50 small mb-0">Insira suas credenciais para entrar no painel.</p>
                    </div>

                    <div class="card bg-dark text-light border-secondary p-4 rounded shadow-lg">

                        <form class="needs-validation" method="post" action="./validation/validate_login.php"
                            novalidate>

                            <div class="mb-3">
                                <label for="login"
                                    class="form-label fw-semibold text-secondary-light small text-uppercase">
                                    <i class="bi bi-person-vcard me-1 text-primary"></i>Login
                                </label>
                                <input type="text"
                                    class="form-control bg-secondary bg-opacity-10 text-white border-secondary custom-input-dark"
                                    id="login" name="login" placeholder="Seu usuário" required>
                                <div class="invalid-feedback">
                                    Campo obrigatório!
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password"
                                    class="form-label fw-semibold text-secondary-light small text-uppercase">
                                    <i class="bi bi-lock me-1 text-primary"></i>Senha
                                </label>
                                <input type="password"
                                    class="form-control bg-secondary bg-opacity-10 text-white border-secondary campo-senha custom-input-dark"
                                    id="password" name="password" placeholder="Sua senha" required>
                                <div class="invalid-feedback">
                                    Campo obrigatório!
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input bg-secondary bg-opacity-10 border-secondary"
                                    type="checkbox" value="" id="showPasword" style="cursor: pointer;">
                                <label class="form-check-label text-secondary-light small user-select-none"
                                    for="showPasword" style="cursor: pointer;">
                                    Mostrar senha
                                </label>
                            </div>

                            <button type="submit" id="btnEntrar"
                                class="btn btn-primary btn-lg w-100 fw-bold text-uppercase login-btn d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-box-arrow-in-right"></i>
                                <span>Entrar</span>
                                <span id="spinner" class="spinner-border spinner-border-sm visually-hidden"
                                    role="status" aria-hidden="true"></span>
                            </button>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastLoginEl = document.getElementById('toastLoginErro');
            if (toastLoginEl) {
                var toastLogin = new bootstrap.Toast(toastLoginEl);
                toastLogin.show();
            }
        });
    </script>

    <style>
        .login-btn {
            transition: all 0.2s ease-in-out;
        }

        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.15);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* SOLUÇÃO DEFINITIVA DO PROBLEMA: Força o placeholder a ficar branco puro e visível */
        .custom-input-dark::placeholder {
            color: #ffffff !important;
            opacity: 1 !important;
        }

        .custom-input-dark::-webkit-input-placeholder {
            color: #ffffff !important;
            opacity: 1 !important;
        }

        .custom-input-dark::-moz-placeholder {
            color: #ffffff !important;
            opacity: 1 !important;
        }

        .custom-input-dark:-ms-input-placeholder {
            color: #ffffff !important;
            opacity: 1 !important;
        }
    </style>
    <footer class="rodape">
        <!-- Direitos Autorais no meio -->
        <div class="direitos">
            &copy; <?php echo date("Y"); ?> Todos os direitos reservados!
        </div>

        <!-- Redes Sociais na direita -->
        <div class="redes-sociais">
            <a href="<?= $social['youtube'] ?>" target="_blank"><i class="bi bi-youtube"></i></a>
            <a href="<?= $social['instagram'] ?>" target="_blank"><i class="bi bi-instagram"></i></a>
        </div>
    </footer>
    <script src="../script/form.validation.js"></script>
    <script src="../script/dynamic-icons.js"></script>
</body>

</html>