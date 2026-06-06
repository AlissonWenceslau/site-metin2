<?php
// Evita iniciar a sessão duas vezes se ela já estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Protege uma página exigindo login.
 * Se o usuário não estiver logado, mata a execução e redireciona.
 */
function protectPage($path) {
    if (!isset($_SESSION["user"])) {
        header('Location: ' . $path); // Use o caminho absoluto da raiz do site
        exit(); // CRÍTICO: Para a execução do PHP imediatamente!
    }
}

/**
 * Protege uma página exigindo nível de Administrador.
 */
function protectPageAdmin($path) {
    // Primeiro garante que está logado
    protectPage($path);
    
    // Depois checa se é admin (usando a sua variável $_SESSION['web'])
    if (!isset($_SESSION['web']) || $_SESSION['web'] != 1) {
        // Se não for admin, joga para uma página de erro ou de volta pro painel comum
        header('Location: ' . $path); 
        exit();
    }
}