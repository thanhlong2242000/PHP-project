<?php
session_start();
include '../connectDB.php';
if ($_SESSION['role'] != 0) {
    if (isset($_POST['submit']) && $_POST["name_publisher"] != '' && $_POST["url_publisher"] != '' && $_POST["crawled"] != '') {
        $name = $_POST["name_publisher"];
        $url = $_POST["url_publisher"];
        $crawled = $_POST["crawled"];
        $created_date = gmdate("Y-m-d H:i:s");
        $sql = "INSERT INTO publisher (name_publisher, url_publisher, crawled , created_date) VALUES (?, ?, ?, ?)";
        $sql_run = $conn->prepare($sql);
        $sql_run->execute([$name ,$url, $crawled, $created_date]);
        if ($sql_run) {
            $_SESSION['add-publisher'] = "Thêm mới thành công";
            header('location:publisher.php');
        }
    } else {
        header('location:publisher.php');
        $_SESSION['error-add-pulisher'] = "Chưa điền đủ thông tin!";
    }
} else {
    $_SESSION['hack-add-pulisher'] = "Bạn không có quyền thay đổi!";
    header('location:publisher.php');
}
?>