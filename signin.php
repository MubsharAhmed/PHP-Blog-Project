<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Signin</title>
    <?php include('includes/header.php'); ?>
</head>

<?php
if (isset($_POST['signin'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $sql = mysqli_query($con, "SELECT email, password,profile_image, username FROM signup WHERE email='$email'");

    if ($sql) {
        $row = mysqli_fetch_array($sql);
        if ($row) {
            $hashpassword = $row['password'];

            if (password_verify($password, $hashpassword)) {
                $_SESSION['login'] = $row['username'];
                $_SESSION['name'] = $row['username'];
                $_SESSION['profile_image'] = $row['profile_image'];
                echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
            } else {
                echo "<script>alert('Wrong Password');</script>";
            }
        } else {
            echo "<script>alert('User not registered with us');</script>";
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<body>

    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <?php include('includes/loader.php'); ?>
        <!-- Spinner End -->

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                            </a>
                            <h3>Sign In</h3>
                        </div>
                        <form method="post" action="signin.php">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                                <a href="">Forgot Password</a>
                            </div>
                            <button type="submit" name="signin" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                            <!-- <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button> -->
                        </form>
                        <p class="text-center mb-0">Don't have an Account? <a href="signup.php">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <?php require('includes/footer.php'); ?>
</body>

</html>