<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Post</title>
    <?php require('includes/header.php'); ?>
</head>
<?php 
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {
        $posttitle = $_POST['posttitle'];
        $catid = $_POST['category'];
        $postdetails = $_POST['postdescription'];
        $arr = explode(" ", $posttitle);
        $url = implode("-", $arr);
        $status = 1;
        $postid = intval($_GET['pid']);


        $query = mysqli_query($con, "UPDATE tblpost SET PostTitle='$posttitle', CategoryId='$catid', PostDetails='$postdetails', PostUrl='$url', Is_Active='$status' WHERE id='$postid'");

        if ($query) {
            $msg = "Post updated ";
            // header('location: manage-post.php');
        } else {
            $error = "Something went wrong. Please try again.";
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
        <?php } ?>
        <div class="container-fluid pt-4 px-4">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <!---Success Message--->
                    <?php if ($msg) { ?>
                        <div id="successMessage" class="alert alert-success" role="alert">
                            <?php echo htmlentities($msg); ?>
                        </div>

                        <script>
                            setTimeout(function() {

                                window.location.href = 'manage-post.php';

                            }, 2000);
                        </script>
                    <?php } ?>
                    <!---Error Message--->
                    <?php if ($error) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
            $postid = intval($_GET['pid']);
            $query = mysqli_query($con, "select tblpost.id as postid,tblpost.PostImage,tblpost.PostTitle as title,tblpost.PostDetails,tblcategory.CategoryName as category,tblcategory.id as catid from tblpost left join tblcategory on tblcategory.id=tblpost.CategoryId where tblpost.id='$postid' and tblpost.Is_Active=1 ");
            while ($row = mysqli_fetch_array($query)) {
            ?>
                <div class="row" id="div-1">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="p-6">
                            <div class="">
                                <form name="addpost" method="post">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="mb-2"><b>Post Title</b></label>
                                        <input type="text" class="form-control" id="posttitle" value="<?php echo htmlentities($row['title']); ?>" name="posttitle" placeholder="Enter title" required>
                                    </div>
                                    <div class="form-group m-b-20 mt-4">
                                        <label for="exampleInputEmail1" class="mb-2"><b>Category</b></label>
                                        <select class="form-control bg-white" name="category" id="category" onChange="getSubCat(this.value);" required>
                                            <option value="<?php echo htmlentities($row['catid']); ?>"><?php echo htmlentities($row['category']); ?></option>
                                            <?php
                                            $ret = mysqli_query($con, "select id,CategoryName from  tblcategory where Is_Active=1");
                                            while ($result = mysqli_fetch_array($ret)) {
                                            ?>
                                                <option value="<?php echo htmlentities($result['id']); ?>"><?php echo htmlentities($result['CategoryName']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 mt-4">
                                            <div class="card-box">
                                                <p><b>Post Details</b></p>
                                                <textarea id="summernote" name="postdescription" required><?php echo htmlentities($row['PostDetails']); ?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 mt-4">
                                            <div class="card-box">
                                                <hp class="m-b-30 m-t-0 header-title"><b>Post Image</b></p>
                                                    <img src="postimages/<?php echo htmlentities($row['PostImage']); ?>" width="300" />
                                                    <br />
                                                    <a href="change-image.php?pid=<?php echo htmlentities($row['postid']); ?>">Update Image</a>
                                            </div><br>
                                        </div>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-success waves-effect waves-light">Update </button>
                                </form>
                            </div>
                        </div> <!-- end p-20 -->
                    </div> <!-- end col -->
                </div>
            <?php } ?>
            <?php require('includes/footer.php'); ?>
            <script>
                $(document).ready(function() {
                    $('#summernote').summernote({
                        height: 300,
                        minHeight: null,
                        maxHeight: null,
                        focus: false
                    });
                });
            </script>
</body>
</html>