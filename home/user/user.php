<?php
session_start();
include '../connectDB.php';
//phân trang publisher
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = $conn->prepare("SELECT * FROM user WHERE firstname LIKE ?"); //tính toán lại phân trang
$sea = array("%$search%");
$sql->execute($sea);

$count = $sql->rowCount();

$limit = 5;

$total_page = ceil($count / $limit);

$cr_page = (isset($_GET['page']) ? $_GET['page'] : 1);

$start = ($cr_page - 1) * $limit;

$email = $_SESSION['email'];

//quyền user/admin
if (isset($_SESSION['email'])) {
    $email = $_SESSION["email"];

    $sql1 = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $sql1->execute([$email]);
    $data = $sql1->fetchAll();
    foreach ($data as $item) {
        $role = $item['role'];
    }
} else {
    header('location:../home.php');
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
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid mx-5">
            <a class="navbar-brand" href="../home.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form action="" method="GET" class="d-flex" role="search">
                    <input class="form-control me-2" name="search" type="search" placeholder="Search"
                        aria-label="Search" value="<?php if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            echo $search;
                        } ?>">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page">
                            <?php echo $role == 0 ? "User:" : "Admin:" ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <?php echo $email ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../publisher/publisher.php">Publisher Managerment</a>
                            </li>
                            <li><a class="dropdown-item" href="user.php">User Publisher</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>USER</h1>
        <div class="<?php if ($role == 0) {
            echo "d-none";
        } ?>">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                data-whatever="@getbootstrap">+ Thêm mới</button>
        </div>
        <!-- ------------------------------------------------------------------------------------------------------ -->
        <?php
        if (isset($_SESSION['add-user'])) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['add-user'];
            ?>
        </div>
        <?php
            unset($_SESSION['add-user']);
        }
        ?>
        <!-- ------------------------------------------------------------------------------------------------------ -->
        <?php
        if (isset($_SESSION['edit-user'])) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['edit-user'];
            ?>
        </div>
        <?php
            unset($_SESSION['edit-user']);
        }
        ?>
        <!-- ------------------------------------------------------------------------------------------------------ -->
        <?php
        if (isset($_SESSION['delete-user'])) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['delete-user'];
            ?>
        </div>
        <?php
            unset($_SESSION['delete-user']);
        }
        ?>
        <!-- ------------------------------------------------------------------------------------------------------ -->
        <?php
        if (isset($_SESSION['hack_add'])) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['hack_add'];
            ?>
        </div>
        <?php
            unset($_SESSION['hack_add']);
        }
        ?>
        <!-- ------------------------------------------------------------------------------------------------------ -->
        <?php
        if (isset($_SESSION['hack_delete'])) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['hack_delete'];
            ?>
        </div>
        <?php
            unset($_SESSION['hack_delete']);
        }
        ?>
        <!-- ------------------------------------------------------------------------------------------------------ -->
        <?php
        if (isset($_SESSION['hack_edit'])) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['hack_edit'];
            ?>
        </div>
        <?php
            unset($_SESSION['hack_edit']);
        }
        ?>

        <!-- ------------------------------------------------------------------------------------------------------ -->
        <form action="export-file.php" method="POST" class="d-inline-block" enctype="multipart/form-data">
            <div class="d-flex">

                <button class="btn btn-outline-primary" name="export_excel_btn" type="submit">Export</button>
                <select name="export_file_type" class="form-control">
                    <option value="csv">CSV</option>
                    <option value="xls">XLS</option>
                    <option value="xlsx">XLSX</option>
                </select>
            </div>
        </form>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                    </div>
                    <form action="add-user.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">First Name</label>
                                <input type="text" name="firstname" class="form-control" placeholder="nhập họ"
                                    id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Last Name</label>
                                <input type="text" name="lastname" class="form-control" placeholder="nhập tên"
                                    id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Email</label>
                                <input type="mail" name="email" class="form-control" placeholder="nhập email"
                                    id="recipient-name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" name="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------------------------------------ -->
        <content>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <?php
                if ($role == 0) {
                    if (isset($_GET['search'])) {
                        $filter = $_GET['search'];
                        $sql = $conn->prepare("SELECT * FROM user WHERE role = 0 AND firstname LIKE :filter LIMIT :start, :limit");
                        $sql->bindValue(":filter", "%$filter%");
                        $sql->bindValue(":start", $start, PDO::PARAM_INT);
                        $sql->bindValue(":limit", $limit, PDO::PARAM_INT);
                        $sql->execute();
                        $sql_run = $sql->rowCount();
                        if ($sql_run > 0) {
                            foreach ($sql as $row) {
                ?>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $row['id']; ?>
                        </td>
                        <td>
                            <?php echo $row['firstname']; ?>
                        </td>
                        <td>
                            <?php echo $row['lastname']; ?>
                        </td>
                        <td>
                            <?php echo $row['email']; ?>
                        </td>
                        <td>
                            <?php echo $row['role'] == 1 ? "Admin" : "user"; ?>
                        </td>
                        <td>
                            <a href="view-user.php?pid=<?php echo $row['id'] ?>"><button type="submit"
                                    class="btn btn-primary">VIEW</button></a>
                        </td>
                    </tr>
                </tbody>
                <?php
                            }
                        }
                    } else {
                        $sql = $conn->prepare("SELECT * FROM user WHERE role = 0  LIMIT :start, :limit"); //Phân trang
                        $sql->bindValue(":start", $start, PDO::PARAM_INT);
                        $sql->bindValue(":limit", $limit, PDO::PARAM_INT);
                        $sql->execute();
                        $sql_run = $sql->fetchAll();
                        if ($sql_run) {
                            foreach ($sql_run as $row) {
                ?>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $row['id'] ?>
                        </td>
                        <td>
                            <?php echo $row['firstname']; ?>
                        </td>
                        <td>
                            <?php echo $row['lastname']; ?>
                        </td>
                        <td>
                            <?php echo $row['email']; ?>
                        </td>
                        <td>
                            <?php echo $row['role'] == 1 ? "Admin" : "user"; ?>
                        </td>
                        <td>
                            <a href="view-user.php?pid=<?php echo $row['id'] ?>"><button type="submit"
                                    class="btn btn-primary">VIEW</button></a>
                        </td>
                    </tr>
                </tbody>
                <?php
                            }
                        }
                    }
                } elseif ($role == 1) {
                    if (isset($_GET['search'])) {
                        $filter = $_GET['search'];
                        $sql = $conn->prepare("SELECT * FROM user WHERE role = 0 AND firstname LIKE :filter LIMIT :start, :limit");
                        $sql->bindValue(":filter", "%$filter%");
                        $sql->bindValue(":start", $start, PDO::PARAM_INT);
                        $sql->bindValue(":limit", $limit, PDO::PARAM_INT);
                        $sql->execute();
                        $sql_run = $sql->rowCount();
                        if ($sql_run > 0) {
                            foreach ($sql as $row) {
                ?>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $row['id']; ?>
                        </td>
                        <td>
                            <?php echo $row['firstname']; ?>
                        </td>
                        <td>
                            <?php echo $row['lastname']; ?>
                        </td>
                        <td>
                            <?php echo $row['email']; ?>
                        </td>
                        <td>
                            <?php echo $row['role'] == 1 ? "Admin" : "user"; ?>
                        </td>
                        <td>
                            <a href="view-user.php?pid=<?php echo $row['id'] ?>"><button type="submit"
                                    class="btn btn-primary">VIEW</button></a>
                        </td>
                        <td>
                            <a href="edit-user.php?pid=<?php echo $row['id'] ?>"><button type="button"
                                    class="btn btn-primary">EDIT</button></a>
                        </td>
                        <td>
                            <a href="delete-user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">DELETE</a>
                        </td>
                    </tr>
                </tbody>
                <?php
                            }
                        }
                    } else {
                        $sql = $conn->prepare("SELECT * FROM user WHERE role = 0  LIMIT :start, :limit"); //Phân trang
                        $sql->bindValue(":start", $start, PDO::PARAM_INT);
                        $sql->bindValue(":limit", $limit, PDO::PARAM_INT);
                        $sql->execute();
                        $sql_run = $sql->fetchAll();
                        if ($sql_run) {
                            foreach ($sql_run as $row) {
                ?>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $row['id'] ?>
                        </td>
                        <td>
                            <?php echo $row['firstname']; ?>
                        </td>
                        <td>
                            <?php echo $row['lastname']; ?>
                        </td>
                        <td>
                            <?php echo $row['email']; ?>
                        </td>
                        <td>
                            <?php echo $row['role'] == 1 ? "Admin" : "user"; ?>
                        </td>
                        <td>
                            <a href="view-user.php?pid=<?php echo $row['id'] ?>"><button type="submit"
                                    class="btn btn-primary">VIEW</button></a>
                        </td>
                        <td>
                            <a href="edit-user.php?pid=<?php echo $row['id'] ?>"><button type=" button"
                                    class="btn btn-primary">EDIT</button></a>
                        </td>
                        <td>
                            <a href="delete-user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">DELETE</a>
                        </td>
                    </tr>
                </tbody>
                <?php
                            }
                        }
                    }
                }
                ?>
            </table>
        </content>
        <!-- ------------------------------------------------------------------------------------------------------ -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- nếu page hiện tại > 1 thì chạy điều kiện trong if -->
                <?php if ($cr_page > 1) { ?>
                <li class="page-item">
                    <a class="page-link"
                        href="user.php?page=<?php echo $cr_page - 1 ?><?php echo ($search != '') ? "&search=$search" : '' ?>"
                        aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <?php } ?>
                <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                <li class="<?php echo (($cr_page == $i) ? 'active' : "") ?>"><a class="page-link"
                        href="user.php?page=<?php echo $i ?><?php echo ($search != '') ? "&search=$search" : '' ?>">
                        <?php echo $i ?>
                    </a></li>
                <?php
                } ?>
                <!-- nếu page hiện tại + 1 <= số page thì chạy điều kiện trong if -->
                <?php if ($cr_page < $total_page) { ?>
                <li class="page-item">
                    <a class="page-link"
                        href="user.php?page=<?php echo $cr_page + 1 ?><?php echo ($search != '') ? "&search=$search" : '' ?>"
                        aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
    <!-- ------------------------------------------------------------------------------------------------------ -->
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