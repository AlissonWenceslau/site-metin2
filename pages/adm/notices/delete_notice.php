<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['web']) || $_SESSION['web'] != 1) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    
    require_once '../../../connection/conn.php';

    $dsn = "mysql:host=$servername;dbname=$dbaccount;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $idExcluir = (int)$_GET['id'];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);

        $stmt = $pdo->prepare("DELETE FROM noticias WHERE id = :id");
        $stmt->execute(['id' => $idExcluir]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['sucesso_sistema'] = "🗑️ A notícia foi excluída do banco de dados com sucesso!";
        } else {
            $_SESSION['erro_sistema'] = "⚠️ A notícia solicitada não foi encontrada ou já havia sido excluída.";
        }

    } catch (\PDOException $e) {
        $_SESSION['erro_sistema'] = "❌ Erro técnico ao excluir: " . $e->getMessage();
    }
} else {
    $_SESSION['erro_sistema'] = "❌ ID de notícia inválido ou não fornecido.";
}

header("Location: ../../../index.php");
exit();
?>