<?php
session_start();
include 'connectDB.php';
if (isset($_POST['submit']) && $_POST['firstname'] != '' && $_POST['lastname'] != '' && $_POST['email'] != '' && $_POST['pass'] != '' && $_POST['repass'] != '') {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $repassword = $_POST["repass"];
    $repassword = md5($repassword);
    $password = md5($password);

    //lấy dữ liệu ra để check trùng mail
    $sql1 = $conn->prepare("SELECT * FROM user");
    $sql1->execute();
    foreach ($sql1 as $item) {
        if ($item['email'] == $email) {
            $err = "mail đã tồn tại";
        }
    }
    if ($repassword == $password) {
        if (!isset($err)) {
            $sql = "INSERT INTO user (firstname, lastname, email, pass, repass) VALUES (?, ?, ?, ?, ?)";
            $sql_run = $conn->prepare($sql);
            $sql_run->execute([$firstname, $lastname, $email, $password, $repassword]);
            if ($sql_run) {
                $_SESSION['status'] = "Đăng ký thành công";
                header("location:login.php");
            }
        } else {
            echo "email đã tồn tại";
        }
    } else {
        echo "nhập lại mật khẩu";
    }
} else {
    header("location:register.php");
}
?>