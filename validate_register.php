<?php
include 'conn.php';
include './utils/validation.php';

session_start();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username_account = validateMax12Alphanumeric($_POST['username']);
    $password_account = validatePassword($_POST['password']);
    $confirm_password_account = validatePassword($_POST['password-confirm']);
    $social_id = validateMax7Alphanumeric($_POST['character']);
    $email = $_POST['email'];
} 

// Query
$sql = "INSERT INTO account (login, password, social_id, email) VALUES ('$username_account',PASSWORD('$password_account'),'$social_id','$email')";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbaccount);

try{
    $errors = validateMax12Alphanumeric($username_account);
    $errors = validatePassword($password_account);
    $errors = validatePassword($confirm_password_account);
    $errors = validateMax7Alphanumeric($social_id);
    if(count($errors) > 0){
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit();
    }

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Sua conta foi criada com sucesso!";
        header("location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}catch (Exception $e) {
    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
}
?>