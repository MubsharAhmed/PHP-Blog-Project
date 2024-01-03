<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signup</title>
<?php require('includes/header.php');?>
</head>
<body>

<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO signup (username, email, password, profile_image) VALUES ('$username', '$email', '$password', '')";


    if ($con->query($sql) === TRUE) {

    
        $_SESSION['login'] = $username;

        echo "<script>
                setTimeout(function() {
                    document.getElementById('success-message').style.display = 'none';
                }, 3000);
              </script>";
        header("Location: signin.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>

<div class="container-xxl position-relative bg-white d-flex p-0">
    <!-- Spinner Start -->
    <?php require('includes/loader.php'); ?>
    <!-- Spinner End -->


    <!-- Sign Up Start -->
    <div class="container-fluid">

        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="index.html" class="">
                            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                        </a>
                        <h3>Sign Up</h3>

                    </div>
                    <div id="success-message" class="alert alert-success" style="display: none;">
                        <strong>Success!</strong> Account created successfully.
                    </div>
                    <form method="post" action="signup.php">
                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control" id="floatingText" placeholder="jhondoe">
                            <label for="floatingText">Username</label>
                        </div>
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
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                    </form>

                    <p class="text-center mb-0">Already have an Account? <a href="signin.php">Sign In</a></p>
                </div>

            </div>
        </div>
    </div>
    <!-- Sign Up End -->
</div>

<?php require('includes/footer.php'); ?>

</body>
</html>