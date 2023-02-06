<?php
session_start();
include '../connectDB.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = $conn->prepare("SELECT * FROM publisher WHERE name_publisher LIKE ?"); //tính toán lại phân trang
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
    header('location:../login.php');
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
                            <li><a class="dropdown-item" href="publisher.php">Publisher Management</a></li>
                            <li><a class="dropdown-item" href="../user/user.php">User Publisher</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>PUBLISHER</h1>
        <!-- ----------------------------------------------------------------------------------------------- -->
        <!-- hiển thị thông báo khi thêm hoặc sửa -->
        <?php
        if (isset($_SESSION['import-publisher'])) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['import-publisher'];
            ?>
        </div>
        <?php
            unset($_SESSION['import-publisher']);
        }
        ?>
        <!-- ----------------------------------------------------------------------------------------------- -->
        <?php
        if (isset($_SESSION['add-publisher'])) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['add-publisher'];
            ?>
        </div>
        <?php
            unset($_SESSION['add-publisher']);
        }
        ?>
        <!-- ----------------------------------------------------------------------------------------------- -->
        <?php
        if (isset($_SESSION['edit-publisher'])) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['edit-publisher'];
            ?>
        </div>
        <?php
            unset($_SESSION['edit-publisher']);
        }
        ?>
        <!-- ----------------------------------------------------------------------------------------------- -->
        <?php
        if (isset($_SESSION['delete-publisher'])) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['delete-publisher'];
            ?>
        </div>
        <?php
            unset($_SESSION['delete-publisher']);
        }
        ?>
        <!-- ----------------------------------------------------------------------------------------------- -->
        <?php
        if (isset($_SESSION['message_error_import'])) {
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo "Không thể import vì thiếu dữ liệu ở:" . $_SESSION['message_error_import'];
            ?>
        </div>
        <?php
            unset($_SESSION['message_error_import']);
        }
        ?>
        <!-- ----------------------------------------------------------------------------------------------- -->
        <?php
        if (isset($_SESSION['file_error'])) {
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['file_error'];
            ?>
        </div>
        <?php
            unset($_SESSION['file_error']);
        }
        ?>
        <!-- ----------------------------------------------------------------------------------------------- -->
        <?php
        if (isset($_SESSION['error-add-pulisher'])) {
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['error-add-pulisher'];
            ?>
        </div>
        <?php
            unset($_SESSION['error-add-pulisher']);
        }
        ?>
        <!-- --------------------------------------------- -->
        <?php
        if (isset($_SESSION['hack-add-pulisher'])) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['hack-add-pulisher'];
            ?>
        </div>
        <?php
            unset($_SESSION['hack-add-pulisher']);
        }
        ?>
        <!-- --------------------------------------------- -->
        <?php
        if (isset($_SESSION['hack-edit-publisher'])) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['hack-edit-publisher'];
            ?>
        </div>
        <?php
            unset($_SESSION['hack-edit-publisher']);
        }
        ?>
        <!-- --------------------------------------------- -->
        <?php
        if (isset($_SESSION['hack-delete-pulisher'])) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong></strong>
            <?php echo $_SESSION['hack-delete-pulisher'];
            ?>
        </div>
        <?php
            unset($_SESSION['hack-delete-pulisher']);
        }
        ?>
        <!-- ----------------------------------------------------------------------------------------------- -->
        <div class="d-flex">
            <div class="<?php if ($role == 0) {
                echo "d-none";
            } ?>">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                    data-whatever="@getbootstrap">+ Thêm mới</button>
            </div>
            <form action="import_export_file.php" method="POST" class="d-inline-block" enctype="multipart/form-data">
                <div class="<?php echo $role == 0 ? "d-none" : "d-flex" ?>">
                    <button class="btn btn-outline-primary" name="save_excel_data" type="submit">Import</button>
                    <input class="form-control me-2" name="import_file" type="file" placeholder="No file cheems">
                </div>
                <div class="d-flex">

                    <button class="btn btn-outline-primary" name="export_excel_btn" type="submit">Export</button>
                    <select name="export_file_type" class="form-control">
                        <option value="csv">CSV</option>
                        <option value="xls">XLS</option>
                        <option value="xlsx">XLSX</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                    </div>
                    <form action="add-publisher.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Name</label>
                                <input type="text" name="name_publisher" class="form-control" placeholder="nhập tên"
                                    id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">URL</label>
                                <input type="text" name="url_publisher" class="form-control" placeholder="nhập url"
                                    id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Crawled</label>
                                <input type="text" name="crawled" class="form-control" placeholder="nhập crawled"
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
        <!-- Edit modal -->
        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sửa thông tin</h5>
                    </div>
                    <form action="edit-publisher.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id_publisher">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Name</label>
                                <input type="text" name="name_publisher" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">URL</label>
                                <input type="text" name="url_publisher" class="form-control" id="url">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Crawled</label>
                                <input type="text" name="crawled" class="form-control" id="crawled">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" name="update_data" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ---------------------------------------------------------------------------------------------- -->
        <!-- DELETE MODAL -->
        <div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa thông tin</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="delete-publisher.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            Bạn có thực sự muốn xóa không?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="deletedata" class="btn btn-danger">YES</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------------------------------------------------------------------------------- -->
        <content>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>URL</th>
                        <th>Crawled</th>
                        <th>Created Date</th>
                        <th>Modified Date</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <?php
                if ($role == 0) {
                    if (isset($_GET['search'])) {
                        $filter = $_GET['search'];
                        $sql = $conn->prepare("SELECT * FROM publisher WHERE name_publisher LIKE :filter LIMIT :start , :limit");
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
                            <?php echo $row['name_publisher']; ?>
                        </td>
                        <td>
                            <?php echo $row['url_publisher']; ?>
                        </td>
                        <td>
                            <?php echo $row['crawled']; ?>
                        </td>
                        <td>
                            <?php echo $row['created_date']; ?>
                        </td>
                        <td>
                            <?php echo $row['modified_date']; ?>
                        </td>
                        <td>
                            <a href="view_publisher.php?pid=<?php echo $row['id'] ?>"><button type="submit"
                                    class="btn btn-primary">VIEW</button></a>
                        </td>
                    </tr>
                </tbody>
                <?php
                            }
                        }
                    } else {
                        $sql = $conn->prepare("SELECT * FROM publisher LIMIT :start ,:limit"); //Phân trang
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
                            <?php echo $row['name_publisher']; ?>
                        </td>
                        <td>
                            <?php echo $row['url_publisher']; ?>
                        </td>
                        <td>
                            <?php echo $row['crawled']; ?>
                        </td>
                        <td>
                            <?php echo $row['created_date']; ?>
                        </td>
                        <td>
                            <?php echo $row['modified_date']; ?>
                        </td>
                        <td>
                            <a href="view_publisher.php?pid=<?php echo $row['id'] ?>"><button type="submit"
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
                        $sql = $conn->prepare("SELECT * FROM publisher WHERE name_publisher LIKE :filter LIMIT :start , :limit");
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
                            <?php echo $row['name_publisher']; ?>
                        </td>
                        <td>
                            <?php echo $row['url_publisher']; ?>
                        </td>
                        <td>
                            <?php echo $row['crawled']; ?>
                        </td>
                        <td>
                            <?php echo $row['created_date']; ?>
                        </td>
                        <td>
                            <?php echo $row['modified_date']; ?>
                        </td>
                        <td>
                            <a href="view_publisher.php?pid=<?php echo $row['id'] ?>"><button type="submit"
                                    class="btn btn-primary">VIEW</button></a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary editbtn">EDIT</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger deletebtn"> DELETE</button>
                        </td>
                    </tr>
                </tbody>
                <?php
                            }
                        }
                    } else {
                        $sql = $conn->prepare("SELECT * FROM publisher LIMIT :start ,:limit"); //Phân trang
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
                            <?php echo $row['name_publisher']; ?>
                        </td>
                        <td>
                            <?php echo $row['url_publisher']; ?>
                        </td>
                        <td>
                            <?php echo $row['crawled']; ?>
                        </td>
                        <td>
                            <?php echo $row['created_date']; ?>
                        </td>
                        <td>
                            <?php echo $row['modified_date']; ?>
                        </td>
                        <td>
                            <a href="view_publisher.php?pid=<?php echo $row['id'] ?>"><button type="submit"
                                    class="btn btn-primary">VIEW</button></a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary editbtn">EDIT</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger deletebtn"> DELETE</button>
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
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- nếu page hiện tại > 1 thì chạy điều kiện trong if -->
                <?php if ($cr_page > 1) { ?>
                <li class="page-item">
                    <a class="page-link"
                        href="publisher.php?page=<?php echo $cr_page - 1 ?><?php echo ($search != '') ? "&search=$search" : '' ?>"
                        aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <?php } ?>
                <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                <li class="<?php echo (($cr_page == $i) ? 'active' : "") ?>"><a class="page-link"
                        href="publisher.php?page=<?php echo $i ?><?php echo ($search != '') ? "&search=$search" : '' ?>">
                        <?php echo $i ?>
                    </a></li>
                <?php
                } ?>
                <!-- nếu page hiện tại + 1 <= số page thì chạy điều kiện trong if -->
                <?php if ($cr_page < $total_page) { ?>
                <li class="page-item">
                    <a class="page-link"
                        href="publisher.php?page=<?php echo $cr_page + 1 ?><?php echo ($search != '') ? "&search=$search" : '' ?>"
                        aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </nav>
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
    <script>
        $(document).ready(function () {
            $('.editbtn').on('click', function () {
                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text().trim();
                }).get();
                console.log(data);
                $('#id_publisher').val(data[0]);
                $('#name').val(data[1]);
                $('#url').val(data[2]);
                $('#crawled').val(data[3]);
                $('#created_date').val(data[4]);
                $('#modified_date').val(data[5]);
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.deletebtn').on('click', function () {
                $('#deletemodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text().trim();
                }).get();
                console.log(data);
                $('#id').val(data[0]);
            });
        });
    </script>
</body>

</html>