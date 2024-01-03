<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Change Password</title>
    <?php require('includes/header.php'); ?>

</head>

<?php 
    $errors = array();
    if (!isset($_SESSION['login'])) {
        header("Location: signin.php");
        exit();
    }
    $username = $_SESSION['login'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $currentPassword = $_POST["currentPassword"];
        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];
        $sql = "SELECT password FROM signup WHERE username = '$username'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];
            if (!password_verify($currentPassword, $hashedPassword)) {
                $errors['currentPassword'] = "Current password is incorrect.";
            }
        } else {
            $errors['userNotFound'] = "User not found.";
        }
        if ($newPassword !== $confirmPassword) {
            $errors['passwordMismatch'] = "New password and confirm password do not match.";
        }
        if (empty($errors)) {
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE signup SET password = '$newHashedPassword' WHERE username = '$username'";
            if ($con->query($updateSql) === TRUE) {
                header("Location: change-password.php?success=password_updated");
                exit();
            } else {
                $errors['updateFailed'] = "Error updating password: " . $con->error;
            }
        }
    }
    $con->close();
?>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <?php require('includes/loader.php'); ?>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <?php require('includes/sidebar.php'); ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php include('includes/navbar.php'); ?>
            <!-- Navbar End -->
            <div class="container-fluid pt-4 px-4">
                <div class="container">
                    <div class="card border-0 shadow-lg p-5 mx-auto" style="max-width: 500px;">
                        <?php if (isset($_GET['success']) && $_GET['success'] === 'password_updated') : ?>
                            <div id="successMessage" class="alert alert-success mt-3" role="alert">
                                <strong>Success!</strong> Password changed successfully.
                            </div>
                        <?php endif; ?>
                        <h2 class="card-title text-center mb-4">Change Password</h2>
                        <form method="post" action="change-password.php">

                            <!-- Current Password -->
                            <div class="mb-4">
                                <label for="currentPassword" class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="currentPassword" placeholder="Current Password" name="currentPassword" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="bi bi-eye-slash" id="toggleCurrentPassword"></i>
                                        </span>
                                    </div>
                                </div>
                                <?php if (!empty($errors['currentPassword'])) : ?>
                                    <div class="text-danger"><?php echo $errors['currentPassword']; ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- New Password -->
                            <div class="mb-4">
                                <label for="newPassword" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="newPassword" placeholder="New Password" name="newPassword" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="bi bi-eye-slash" id="toggleNewPassword"></i>
                                        </span>
                                    </div>
                                </div>
                                <?php if (!empty($errors['passwordMismatch'])) : ?>
                                    <div class="text-danger"><?php echo $errors['passwordMismatch']; ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="bi bi-eye-slash" id="toggleConfirmPassword"></i>
                                        </span>
                                    </div>
                                </div>
                                <?php if (!empty($errors['updateFailed'])) : ?>
                                    <div class="text-danger"><?php echo $errors['updateFailed']; ?></div>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
      

        <?php require('includes/footer.php'); ?>
        <script>
            // Add a script to hide the success message after 3 seconds and redirect
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'none';
                // window.location.href = 'index.php'; // Redirect to index.php
            }, 5000);

            // Toggle password visibility
            document.getElementById('toggleCurrentPassword').addEventListener('click', togglePasswordVisibility.bind(null, 'currentPassword'));
            document.getElementById('toggleNewPassword').addEventListener('click', togglePasswordVisibility.bind(null, 'newPassword'));
            document.getElementById('toggleConfirmPassword').addEventListener('click', togglePasswordVisibility.bind(null, 'confirmPassword'));

            function togglePasswordVisibility(inputId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(`toggle${inputId.charAt(0).toUpperCase() + inputId.slice(1)}`);

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            }
        </script>
</body>
</html>