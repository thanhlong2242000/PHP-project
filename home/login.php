<?php
session_start();
if (isset($_SESSION["email"]) && $_SESSION["pass"]) {
    header("location:home.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet" />

</head>

<body>
    <div class="container">
        <form action="login_submit.php" method="POST">
            <?php
            if (isset($_SESSION['status'])) {
            ?>

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong></strong>
                <?php echo $_SESSION['status']; ?>
            </div>
            <?php
                unset($_SESSION['status']);
            }
            ?>
            <div class="form-outline mb-4">
                <input type="email" name="email" id="form2Example1" class="form-control" />
                <label class="form-label" for="form2Example1">Email address</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" name="pass" id="form2Example2" class="form-control" />
                <label class="form-label" for="form2Example2">Password</label>
            </div>
            <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="form2Example34" checked />
                        <label class="form-check-label" for="form2Example34"> Remember me </label>
                    </div>
                </div>

                <div class="col">
                    <a href="#!">Forgot password?</a>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
            <div class="text-center">
                <p>Not a member? <a href="register.php">Register</a></p>
                <p>or sign up with:</p>
                <button type="button" class="btn btn-primary btn-floating mx-1">
                    <i class="fab fa-facebook-f"></i>
                </button>

                <button type="button" class="btn btn-primary btn-floating mx-1">
                    <i class="fab fa-google"></i>
                </button>

                <button type="button" class="btn btn-primary btn-floating mx-1">
                    <i class="fab fa-twitter"></i>
                </button>

                <button type="button" class="btn btn-primary btn-floating mx-1">
                    <i class="fab fa-github"></i>
                </button>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>
</body>

</html>