<?php
include '../connectDB.php';
$id = $_GET['pid'];
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
            <a class="navbar-brand" href="publisher.php">Back</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="container">
        <form>
            <?php
            if (isset($id)) {
                $sql = $conn->prepare("SELECT * FROM publisher WHERE id=?");
                $sql->execute([$id]);
                $sql_run = $sql->fetchAll();
                if ($sql_run) {
                    foreach ($sql_run as $row) { ?>
            <div class="row">
                <div class="col-lg-5">
                    <div class="card mb-4">
                        <div class="card-body">
                            <table class="table">
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Publisher Name:</td>
                                        <td class="text-end">
                                            <?php echo $row['name_publisher']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">URL:</td>
                                        <td class="text-primary text-end">
                                            <?php echo $row['url_publisher']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">CRAWLED:</td>
                                        <td class="text-end">
                                            <?php echo $row['crawled']; ?>
                                        </td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="2">Created date:</td>
                                        <td class="text-end">
                                            <?php echo $row['created_date']; ?>
                                        </td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="2">Modifided date:</td>
                                        <td class="text-end">
                                            <?php echo $row['modified_date']; ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php
                    }
                }
            } else {
                header('location:publisher.php');
            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>