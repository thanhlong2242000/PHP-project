<?php
session_start();
include '../connectDB.php';
if ($_SESSION['role'] != 0) {
    if (isset($_POST['deletedata'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM publisher WHERE id=?";
        $sql_run = $conn->prepare($sql);
        $sql_run->execute([$id]);
        if ($sql_run) {
            $_SESSION['delete-publisher'] = "Xóa thành công";
            header('location:publisher.php');
        } else {
            echo "lỗi";
        }
    } else {
        echo "lỗi";
    }
} else {
    $_SESSION['hack-delete-pulisher'] = "Bạn không có quyền thay đổi!";
    header('location:publisher.php');
}

?>