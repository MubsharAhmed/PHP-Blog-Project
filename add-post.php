<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Post</title>
    <?php require('includes/header.php'); ?>
</head>

<?php
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // For adding post  
    // print_r($_POST);
    // exit;
    if (isset($_POST['submit'])) {
        $posttitle = $_POST['posttitle'];
        $catid = $_POST['category'];
        $postdetails = $_POST['postdescription'];
        $arr = explode(" ", $posttitle);
        $url = implode("-", $arr);
        $imgfile = $_FILES["postimage"]["name"];

        $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
        // allowed extensions
        $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
        // Validation for allowed extensions .in_array() function searches an array for a specific value.
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            //rename the image file
            $imgnewfile = md5($imgfile) . $extension;
            // Code for move image into directory
            move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile);

            $status = 1;
            $query = mysqli_query($con, "insert into tblpost(PostTitle,CategoryId,PostDetails,PostUrl,Is_Active,PostImage) values('$posttitle','$catid','$postdetails','$url','$status','$imgnewfile')");

            if ($query) {
                $msg = "Post successfully added ";
            } else {
                $error = "Something went wrong . Please try again.";
            }
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
                                <?php echo htmlentities($error); ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="p-6">
                            <div class="">
                                <form name="addpost" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <p><b>Post Title</b></p>
                                        </label>
                                        <input type="text" class="form-control" id="posttitle" name="posttitle" placeholder="Enter title" required>
                                    </div>



                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <p><b>Category</b></p>
                                        </label>
                                        <select class="form-control bg-white" name="category" id="category" onChange="getSubCat(this.value);" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            $ret = mysqli_query($con, "select id,CategoryName from  tblcategory where Is_Active=1");
                                            while ($result = mysqli_fetch_array($ret)) {
                                            ?>
                                                <option value="<?php echo htmlentities($result['id']); ?>"><?php echo htmlentities($result['CategoryName']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box">
                                                <hp class="m-b-30 m-t-0 header-title"><b>Post Details</b></p>
                                                    <textarea id="summernote" name="postdescription"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box">
                                                <h5 class="header-title"><b>Feature Image</b></h5>
                                                <div id="image-preview-container" style="max-width: 200px; max-height: 200px; overflow: hidden; display:none;">
                                                    <img id="image-preview" src="#" alt="Preview" style="width: 100%; height: 100%;">
                                                </div>
                                                <input type="file" class="form-control mb-3" id="postimage" name="postimage" onchange="previewImage(this)" required>

                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-success">Save and Post</button>
                                    <button type="button" class="btn btn-danger">Discard</button>
                                </form>
                            </div>
                        </div> <!-- end p-20 -->
                    </div> <!-- end col -->
                </div><br><br>
                <!-- end row -->
            </div> <!-- container -->
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
<?php } ?>
<script>
    function previewImage(input) {
        var file = input.files[0];
        var imagePreviewContainer = $('#image-preview-container');
        var imagePreview = $('#image-preview');

        if (file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.attr('src', e.target.result);
                imagePreviewContainer.css('display', 'block');
            }
            reader.readAsDataURL(file);
        } else {
            // If no file is selected, hide the preview container
            imagePreviewContainer.css('display', 'none');
        }
    }

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