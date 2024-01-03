<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Add Category</title>
<?php require('includes/header.php');?>

</head>
<?php
error_reporting(0);


if (strlen($_SESSION['login']) == 0) {
    header('location: signin.php');
} else {
    if (isset($_POST['submit'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $status = 1;
        $query = mysqli_query($con, "insert into tblcategory (CategoryName, Description, Is_Active) values('$category','$description','$status')");
        if ($query) {
            $msg = "Category created ";
            header('location: manage-category.php');
        } else {
            $error = "Something went wrong . Please try again.";
        }
    }
?>
<body>
    

    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
  <?php require('includes/loader.php');?>
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
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title"><b>Add Category </b></h4>
                            <hr />
                            <div class="row">
                                <div class="col-sm-6">
                                    <!---Success Message--->
                                    <?php if ($msg) { ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fa fa-exclamation-circle me-2"></i><strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php } ?>

                                    <!---Error Message--->
                                    <?php if ($error) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="container-fluid pt-4 px-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form class="form-horizontal" name="category" method="post">
                                            <!-- Category Input -->
                                            <div class="form-group">
                                                <label for="category" class="col-md-2 control-label">Category</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" id="category" name="category" required>
                                                </div>
                                            </div>
                                            <!-- Description Textarea -->
                                            <div class="form-group">
                                                <label for="description" class="col-md-2 control-label">Description</label>
                                                <div class="col-md-10">
                                                    <textarea class="form-control" rows="5" id="description" name="description" required></textarea>
                                                </div>
                                            </div>
                                          <!-- Submit Button -->
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">&nbsp;</label>
                                                <div class="col-md-10">
                                                    <button type="submit" class="btn btn-success" name="submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Button End -->
        </div>
        <!-- Content End -->
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
    <?php require('includes/footer.php'); ?>
<?php } ?>

</body>
</html>