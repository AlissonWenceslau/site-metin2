<?php
session_start();

include 'conn.php';



try {
    // Conectar ao banco
    $conn = new mysqli($servername, $username, $password, $dbaccount);
} catch (mysqli_sql_exception $e) {
    // captura o erro e lida com ele
    $_SESSION['error'] = "Erro na conexão com o banco de dados: " . $e->getMessage() . " <a href='status.php'>Status</a>";
    http_response_code(500);
    header('Location: login.php');
    // error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
    // echo "Erro ao conectar ao banco de dados. Tente novamente mais tarde.";
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
