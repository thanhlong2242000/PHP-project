<?php
session_start();
include '../connectDB.php';
$id = $_GET['id'];
if ($_SESSION['role'] != 0) {
    if (isset($id)) {
        $sql = "DELETE FROM user WHERE id=?";
        $sql_run = $conn->prepare($sql);
        $sql_run->execute([$id]);
        if ($sql_run) {
            $_SESSION['delete-user'] = "Xóa thành công";
            header('location:user.php');
        } else {
            echo "Lỗi";
        }
    } else {
        echo "Chưa nhập đủ thông tin";
    }
} else {
    $_SESSION['hack_delete'] = "Bạn không có quyền xóa!";
    header('location:user.php');
}
?>