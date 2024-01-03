<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "includes/header.php"; ?>
</head>

<?php

        if (!isset($_SESSION["login"])) {
            header("Location: signin.php");
            exit();
        }

        $userCountQuery = mysqli_query(
            $con,
            "SELECT COUNT(*) as totalUsers FROM signup"
        );
        $categoryCountQuery = mysqli_query(
            $con,
            "SELECT COUNT(*) as totalCategories FROM tblcategory"
        );
        $postCountQuery = mysqli_query(
            $con,
            "SELECT COUNT(*) as totalPost FROM tblpost"
        );

        $userCount = mysqli_fetch_assoc($userCountQuery)["totalUsers"];
        $categoryCount = mysqli_fetch_assoc($categoryCountQuery)["totalCategories"];
        $postCount = mysqli_fetch_assoc($postCountQuery)["totalPost"];
?>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <?php require "includes/loader.php"; ?>
        <!-- Spinner End -->
        <?php require "includes/sidebar.php"; ?>
        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php require "includes/navbar.php"; ?>
            <!-- Navbar End -->
            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Today Users</p>
                                <h6 class="mb-0"><?php echo $userCount; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <a href="manage-category.php">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Total Category</p>
                                    <h6 class="mb-0"><?php echo $categoryCount; ?></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <a href="manage-post.php">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <i class="fa fa-chart-area fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Total Posts</p>
                                    <h6 class="mb-0"><?php echo $postCount; ?></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Content End -->
            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>
        <?php require "includes/footer.php"; ?>
</body>

</html>