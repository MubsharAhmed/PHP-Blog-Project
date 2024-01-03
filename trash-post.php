<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Trashed Posts</title>
    <?php require 'includes/header.php'; ?>
</head>

<body>
    <?php
    error_reporting(0);


    if (strlen($_SESSION['login']) == 0) {
        header('location: index.php');
    } else {
        if ($_GET['action'] == 'restore') {
            $postid = intval($_GET['pid']);
            $query = mysqli_query($con, "UPDATE tblposts SET Is_Active=1 WHERE id='$postid'");
            if ($query) {
                $msg = "Post restored successfully";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
        // Code for Forever deletionparmdel
        if ($_GET['presid']) {
            $id = intval($_GET['presid']);
            $query = mysqli_query($con, "DELETE FROM tblposts WHERE id='$id'");
            $delmsg = "Post deleted forever";
        }

    ?>

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
                <?php require('includes/navbar.php'); ?>
                <!-- Navbar End -->

                <!-- Typography Start -->
                <div class="container-fluid pt-4 px-4">

                    <table class="table table-bordered text-center">
                        <h1>Deleted Posts</h1>

                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $query = mysqli_query($con, "SELECT tblpost.id AS postid, tblpost.PostTitle AS title, tblcategory.CategoryName AS category FROM tblpost LEFT JOIN tblcategory ON tblcategory.id = tblpost.CategoryId WHERE tblpost.Is_Active = 1");
                            $rowcount = mysqli_num_rows($query);
                            if ($rowcount == 0) {
                            ?>
                                <tr>
                                    <td colspan="4" class="text-center text-danger">
                                        <h3>No records found</h3>
                                    </td>
                                </tr>
                                <?php
                            } else {
                                $index = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo $index++; ?></td>
                                        <td><?php echo htmlentities($row['title']); ?></td>
                                        <td><?php echo htmlentities($row['category']) ?></td>
                                        <td>
                                            <!-- <a href="trash-post.php?pid=&&action=restore" onclick="return confirm('Do you really want to restore ?')"><i class="fas fa-undo" title="Restore this Post"></i></a> -->
                                            <a href="edit-post.php?pid=<?php echo htmlentities($row['postid']); ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                            <a href="manage-post.php?pid=<?php echo htmlentities($row['postid']); ?>&&action=del" class="btn btn-danger btn-sm" onclick="return confirm('Do you really want to delete?')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div> <!-- content -->
                <!-- Typography End -->
            </div>
            <?php require('includes/footer.php'); ?>
        <?php } ?>

</body>
</html>