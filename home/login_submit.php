<?php
session_start();
include 'connectDB.php';

if (isset($_POST['submit']) && $_POST['email'] != '' && $_POST['pass'] != '') {
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $password = md5($password);
    $sql = $conn->prepare("SELECT * FROM user WHERE email = ? AND pass = ? ");
    $sql->execute([$email, $password]);
    $data = $sql->fetchAll();
    if ($data) {
        $_SESSION["email"] = $email;
        $_SESSION["pass"] = $password;
        foreach ($data as $item) {
            $role = $item["role"];
        }
        $_SESSION["role"] = $role;
        var_dump($data);
        header("location:home.php");
    } else {
        echo "Nhập sai mật khẩu hoặc email";
    }
} else {
    header("location:login.php");
}
?>