<?php
session_start();
require '../../connection/conn.php';

try {
    $conn = new mysqli($servername, $username, $password, $dbaccount);
} catch (mysqli_sql_exception $e) {
    $_SESSION['error'] = "Erro na conexão com o banco de dados: " . $e->getMessage() . " - <a href='status.php'>Status</a>";
    http_response_code(500);
    header('Location: ../login.php');
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validação básica
    if (empty($_POST['login']) || empty($_POST['password'])) {
        $_SESSION['error'] = 'Preencha todos os campos.';
        header('Location: ../login.php');
        exit;
    }

    $login = trim($_POST['login']);
    $password = $_POST['password'];
    $hash = '*' . strtoupper(sha1(sha1($password, true))); // mantém compatível com o banco

    // Busca apenas pelo login
    $stmt = $conn->prepare("SELECT id, login, password, web_admin, coins FROM account WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Compara senha no PHP
        if (hash_equals($user['password'], $hash)) {

            // Segurança: regeneração de sessão
            session_regenerate_id(true);

            $_SESSION['user'] = $user['login'];
            $_SESSION['web'] = $user['web_admin'];
            $_SESSION['cash'] = $user['coins'];
            $_SESSION['account_id'] = $user['id'];

            header("Location: ../../index.php");
            exit;
        }
    }

    // Se chegou aqui, falhou
    $_SESSION['error'] = 'Credenciais Inválidas';
    header('Location: ../login.php');
    exit();
}


$conn->close();
