<?php
session_start();
include '../connectDB.php';
$id = $_GET['pid'];

$sql = $conn->prepare("SELECT * FROM user WHERE id=?");
$sql->execute([$id]);
$sql_run = $sql->fetchAll();
foreach ($sql_run as $row) {
    $fname = $row['firstname'];
    $lname = $row['lastname'];
    $email = $row['email'];
    $role = $row['role'];
}

// -------------------------------
if ($_SESSION['role'] != 0) {
    if (isset($_POST['submit']) && $_POST["firstname"] != '' && $_POST["lastname"] != '' && $_POST["email"] != '') {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $update = "UPDATE user SET firstname=? ,lastname=?, email=?,role=?  WHERE id=? ";
        $sql_update = $conn->prepare($update);
        $sql_update->execute([$firstname, $lastname, $email, $role, $id]);
        if ($sql_update) {
            $_SESSION['edit-user'] = "Sửa thành công";
            header('location:user.php');
        }
    }
} else {
    $_SESSION['hack_edit'] = "Bạn không có quyền thay đổi!";
    header('location:user.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <form action="" method="POST">
            <input type="hidden" name="id" id="id_user">
            <div class="form-group">
                <label for="">First Name</label>
                <input name="firstname" type="text" class="form-control" id="" aria-describedby="emailHelp"
                    placeholder="Enter name" value="<?php echo $fname ?>">
            </div>
            <div class="form-group">
                <label for="">Last Name</label>
                <input name="lastname" type="text" class="form-control" id="" aria-describedby="emailHelp"
                    placeholder="Enter name" value="<?php echo $lname ?>">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input name="email" type="email" class="form-control" id="" aria-describedby="emailHelp"
                    placeholder="Enter name" value="<?php echo $email ?>">
            </div>
            <div class="form-group">
                <label for="">Role</label>
                <select class="form-select" aria-label="Default select example" name="role">
                    <option value="<?php echo $role == 0 ? "0" : "1" ?>" selected><?php echo $role == 0 ? "User" : "Admin";?></option>
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Save</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>