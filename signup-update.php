<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Signin</title>
    <?php require('includes/header.php'); ?>
</head>

<?php
    if (!isset($_SESSION['login'])) {
        header("Location: signin.php");
        exit();
    }

    $username = $_SESSION['login'];
    $sql = "SELECT * FROM signup WHERE username = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $currentProfileImage = $row['profile_image'];
    } else {
        echo "User not found.";
        exit();
    }

    $successMessage = '';
    $errorMessages = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Initialize variables for update
        $updateFields = array();
        $updateValues = array();
        $updateParams = '';

        // Process username
        $newUsername = mysqli_real_escape_string($con, $_POST["newUsername"]);
        if ($newUsername !== $username) {
            $updateFields[] = "username = ?";
            $updateValues[] = $newUsername;
            $successMessage = "Username updated successfully.";
        }

        // Process email
        $newEmail = mysqli_real_escape_string($con, $_POST["newEmail"]);
        if (!empty($newEmail) && $newEmail !== $email) {
            $updateFields[] = "email = ?";
            $updateValues[] = $newEmail;
            $successMessage = "Email updated successfully.";
        }

        // File upload handling
        if (!empty($_FILES["newProfileImage"]["name"])) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . uniqid() . basename($_FILES["newProfileImage"]["name"]);
            if (move_uploaded_file($_FILES["newProfileImage"]["tmp_name"], $targetFile)) {
                $updateFields[] = "profile_image = ?";
                $updateValues[] = $targetFile;
                $successMessage = "Profile image updated successfully.";
            } else {
                $errorMessages[] = "Sorry, there was an error uploading your file.";
            }
        }

        // Update user information
        if (!empty($updateFields)) {
            $updateParams = implode(", ", $updateFields);
            $updateSql = "UPDATE signup SET $updateParams WHERE username = ?";
            $stmt = $con->prepare($updateSql);
            $updateValues[] = $username;
            $stmt->bind_param(str_repeat('s', count($updateValues)), ...$updateValues);

            if (!$stmt->execute()) {
                $errorMessages[] = "Error updating user information: " . $stmt->error;
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
                <form method="post" action="signup-update.php" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="newUsername"><b>Username:</b></label>
                        <input type="text" name="newUsername" class="form-control" id="newUsername" value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="newEmail"><b>Email:</b></label>
                        <input type="email" name="newEmail" class="form-control" id="newEmail" value="<?php echo $email; ?>">
                    </div>


                    <div class="form-group mb-4">
                        <label for="profile_image"><b>Profile Image:</b></label>
                        <div id="imagePreview" class="mt-2">
                            <?php if (!empty($currentProfileImage)) : ?>
                                <img src="<?php echo $currentProfileImage; ?>" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            <?php endif; ?>
                        </div>
                        <input type="file" name="newProfileImage" class="form-control" id="profile_image" onchange="previewImage(this)">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Update Profile</button>
                </form>

                <?php if ($errorMessages) : ?>
                    <div id="error-message" class="alert alert-danger mt-3">
                        <?php foreach ($errorMessages as $errorMessage) : ?>
                            <?php echo $errorMessage; ?><br>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                <?php if ($successMessage) : ?>
                    <div id="success-message" class="alert alert-success mt-3"><?php echo $successMessage; ?></div>
                    <script>
                        setTimeout(function() {
                            document.getElementById('success-message').style.display = 'none';
                            window.location.href = 'index.php';
                        }, 3000);
                    </script>
                <?php endif; ?>
            </div>
    </div>
            <!-- Footer Start -->
            <?php require('includes/footer.php'); ?>
            <!-- Footer end -->
            <script>
                function previewImage(input) {
                    var previewContainer = document.getElementById('imagePreview');
                    previewContainer.innerHTML = '';

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var imgElement = document.createElement('img');
                            imgElement.setAttribute('src', e.target.result);
                            imgElement.setAttribute('class', 'img-thumbnail');
                            imgElement.setAttribute('style', 'max-width: 200px; max-height: 200px;');
                            previewContainer.appendChild(imgElement);
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>

</body>
</html>