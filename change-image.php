<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Change Image</title>
    <?php require 'includes/header.php'; ?>
</head>
<?php
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location: index.php');
} else {
    if (isset($_POST['update'])) {
        $imgfile = $_FILES["postimage"]["name"];
        // get the image extension
        $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
        // allowed extensions
        $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");

        // Validation for allowed extensions .in_array() function searches an array for a specific value.
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            // rename the image file
            $imgnewfile = md5($imgfile) . $extension;

            // Code for move image into directory
            move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile);

            $postid = intval($_GET['pid']);
            $query = mysqli_query($con, "UPDATE tblpost SET PostImage='$imgnewfile' WHERE id='$postid'");

            if ($query) {
                $msg = "Post Feature Image updated";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
?>

    <body>
        <div class="container-xxl position-relative bg-white d-flex p-0">
            <!-- Spinner Start -->
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- Spinner End -->
            <!-- Sidebar Start -->
            <?php require('includes/sidebar.php'); ?>
            <!-- Sidebar End -->
            <!-- Content Start -->
            <div class="content">
                <!-- Navbar Start -->
                <?php require('includes/navbar.php'); ?>
                <!-- Navbar End -->
                <!-- Button Start -->
                <div class="row">
                    <div class="col-sm-6">
                        <!---Success Message--->
                        <?php if ($msg) { ?>
                            <div id="successMessage" class="alert alert-success" role="alert">
                                <?php echo htmlentities($msg); ?>
                            </div>
                            <script>
                                setTimeout(function() {
                                    // Redirect to another page after 3 seconds
                                    window.location.href = 'edit-post.php';
                                }, 3000); // 3000 milliseconds = 3 seconds
                            </script>
                        <?php } ?>
                        <!---Error Message--->
                        <?php if ($error) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlentities($error); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <form name="addpost" method="post" enctype="multipart/form-data">
                    <?php
                    $postid = intval($_GET['pid']);
                    $query = mysqli_query($con, "select PostImage,PostTitle from tblpost where id='$postid' and Is_Active=1 ");
                    while ($row = mysqli_fetch_array($query)) {
                    ?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="p-6">
                                    <div class="">
                                        <form name="addpost" method="post">
                                            <div class="form-group m-b-20">
                                                <label for="exampleInputEmail1">Post Title</label>
                                                <input type="text" class="form-control" id="posttitle" value="<?php echo htmlentities($row['PostTitle']); ?>" name="posttitle" readonly>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card-box">
                                                        <h4 class="m-b-30 m-t-0 header-title"><b>Current Post Image</b></h4>
                                                        <img src="postimages/<?php echo htmlentities($row['PostImage']); ?>" width="300" />
                                                        <br />

                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box">
                                                    <h4 class="m-b-30 m-t-0 header-title"><b>New Feature Image</b></h4>
                                                    <input type="file" class="form-control" id="postimage" name="postimage" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="update" class="btn btn-success waves-effect waves-light">Update </button>
                                        </form>

                                    <?php } ?>
                                    <?php require('includes/footer.php'); ?>
                                    <script>
                                        $(document).ready(function() {
                                            $('#summernote').summernote();
                                        });
                                    </script>

    </body>

</html>