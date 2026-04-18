<?php
require '../includes/conn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Conexão (deve vir antes da query)
    $conn = mysqli_connect($servername, $username, $password, $dbaccount);

    // 2. Coleta e validação básica
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['password-confirm'];
    $social_id = trim($_POST['character']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitização específica para email

    $errors = [];

    // Validações de tamanho e igualdade...
    if (strlen($username) < 5 || strlen($username) > 12) {
        $errors[] = 'Login inválido';
    }
    if (strlen($password) < 5 || strlen($password) > 12) {
        $errors[] = 'Password inválido';
    }
    if ($password !== $confirm_password) {
        $errors[] = 'As senhas não coincidem';
    }
    if (strlen($social_id) < 7 || strlen($social_id) > 7) {
        $errors[] = 'Senha do personagem inválida';
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header('Location: ../../index.php');
        exit();
    }

    // 3.SEGURANÇA: Prepared Statement
    // Usamos "?" como placeholders para os valores
    $sql = "INSERT INTO account (login, password, social_id, email) VALUES (?, PASSWORD(?), ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // "ssss" indica que estamos enviando 4 strings
        mysqli_stmt_bind_param($stmt, "ssss", $username, $password, $social_id, $email);

        try {
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success'] = "Sua conta foi criada com sucesso!";
                header("location: ../../index.php");
                exit; // Sempre use exit após um header de redirecionamento
            }
        } catch (mysqli_sql_exception $e) {
            // Verifica se o código do erro é 1062 (Duplicate entry no MySQL)
            if ($e->getCode() === 1062) {
                header("location: ../erro.php");
                exit; // Sempre use exit após um header de redirecionamento
            } else {
                echo "Ocorreu um erro inesperado: " . $e->getMessage();
            }
        } finally {
            mysqli_stmt_close($stmt);
        }
    }
}
