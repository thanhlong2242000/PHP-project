<?php
session_start();
include '../connectDB.php';
if ($_SESSION["role"] != 0) {
    if (isset($_POST['update_data']) && $_POST["name_publisher"] != '' && $_POST["url_publisher"] != '' && $_POST["crawled"] != '') {
        $id = $_POST["id"];
        $name = $_POST["name_publisher"];
        $url = $_POST["url_publisher"];
        $crawled = $_POST["crawled"];
        $modified_date = gmdate("Y-m-d H:i:s");
        $sql = "UPDATE publisher SET name_publisher=?, url_publisher=?, crawled=?, modified_date=? WHERE id=?";
        $sql_run = $conn->prepare($sql);
        $sql_run->execute([$name, $url, $crawled, $modified_date, $id]);
        if ($sql_run) {
            $_SESSION['edit-publisher'] = "Sửa thành công";
            header('location:publisher.php');
        } else {
            echo "Thông tin bị trùng";
        }
    }else{
        header('location:publisher.php');
        $_SESSION['error-add-pulisher'] = "Chưa điền đủ thông tin";
    }
} else {
    $_SESSION['hack-edit-publisher'] = "Bạn không có quyền";
    header('location:publisher.php');
}
?>