<?php
session_start();

include 'conn.php';

// Conectar ao banco
$conn = new mysqli($servername, $username, $password, $dbaccount);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $hash = '*' . strtoupper(sha1(sha1($password, true))); // Criptografa como no banco

    $stmt = $conn->prepare("SELECT * FROM account WHERE login = ? AND password = ?");
    $stmt->bind_param("ss", $login, $hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['user'] = $login;
        header("Location: index.php");
        exit;
        // Redirecionar para painel protegido, se desejar
    } else {
        $_SESSION['error'] = 'Credenciais Inválidas';
        header('Location: login.php');
        exit();
    }

    $stmt->close();
}

$conn->close();
