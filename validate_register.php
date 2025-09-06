<?php
include 'conn.php';
include './utils/validation.php';

session_start();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username_account = $_POST['username'];
    $password_account = $_POST['password'];
    $confirm_password_account = $_POST['password-confirm'];
    $social_id = $_POST['character'];
    $email = $_POST['email'];
} 

// Query
$sql = "INSERT INTO account (login, password, social_id, email) VALUES ('$username_account',PASSWORD('$password_account'),'$social_id','$email')";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbaccount);

$errors_login = validateMax12Alphanumeric($username_account);
$errors_password = validatePassword($password_account);
$errors_password_confirm = validateConfirmPassword($confirm_password_account);
$errors_password_delete_character = validateMax7Alphanumeric($social_id);

$errors = array_merge($errors_login, $errors_password, $errors_password_confirm, $errors_password_delete_character);

try{
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
    $errors[] = $e->getMessage();
    $_SESSION['errors'] = $errors;
    header('Location: index.php');
}
?>