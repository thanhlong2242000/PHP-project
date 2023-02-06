<?php
session_start();
include '../connectDB.php';
if ($_SESSION['role'] != 0) {
    if (isset($_POST['submit']) && $_POST['firstname'] != '' && $_POST['lastname'] != '' && $_POST['email'] != '') {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];

        $sql = $conn->prepare("INSERT INTO user (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
        $sql->bindParam(':firstname', $firstname);
        $sql->bindParam(':lastname', $lastname);
        $sql->bindParam(':email', $email);
        $sql->execute();
        if ($sql) {
            $_SESSION['add-user'] = "Thêm mới thành công";
            header('location:user.php');
        }
        var_dump($_SESSION['add']);
    } else {
        echo "Chưa nhập đủ thông tin";
    }
} else {
    $_SESSION['hack_add'] = "Bạn không có quyền thay đổi!";
    header('location:user.php');
}
?>