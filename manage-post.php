<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Posts</title>
    <?php require('includes/header.php'); ?>
</head>

<?php
    error_reporting(0);
    if (strlen($_SESSION['login']) == 0) {
        header('location: index.php');
    } else {
        if ($_GET['action'] == 'del') {
            $postid = intval($_GET['pid']);
            $query = mysqli_query($con, "UPDATE tblpost SET Is_Active=0 WHERE id='$postid'");
            if ($query) {
                $msg = "Post deleted";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
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
                <?php require('includes/navbar.php'); ?>
                <!-- Navbar End -->
                <!-- Button Start -->
                <div class="container-fluid pt-4 px-4">
                    <h1>Manage Posts</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Posting Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($con, "SELECT tblpost.id AS postid, tblpost.PostTitle AS title, tblcategory.CategoryName AS category, tblpost.PostImage AS image, tblpost.PostingDate AS posting_date FROM tblpost LEFT JOIN tblcategory ON tblcategory.id = tblpost.CategoryId WHERE tblpost.Is_Active = 1");
                                $rowcount = mysqli_num_rows($query);

                                if ($rowcount == 0) {
                                ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">
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
                                                <?php
                                                $imagePath = 'postimages/' . $row['image'];
                                                if (file_exists($imagePath)) {
                                                    echo "<img src='$imagePath' alt='Image' style='width: 40px; height: 40px;'>";
                                                } else {
                                                    echo "Image not found";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo htmlentities($row['posting_date']); ?></td>
                                            <td>
                                                <a href="edit-post.php?pid=<?php echo htmlentities($row['postid']); ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                <a href="manage-post.php?pid=<?php echo htmlentities($row['postid']); ?>&&action=del" class="btn btn-danger btn-sm" onclick="return confirm('Do you really want to delete?')"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php require('includes/footer.php'); ?>
                <?php } ?>
    </body>

</html>