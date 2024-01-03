<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title>Edit Category</title>
   <?php require('includes/header.php'); ?>
</head>
<?php
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $catid = intval($_GET['cid']);
        $category = $_POST['category'];
        $description = $_POST['description'];
        $query = mysqli_query($con, "Update  tblcategory set CategoryName='$category',Description='$description' where id='$catid'");
        if ($query) {
            $msg = "Category Updated successfully ";
            header('location:manage-category.php');
        } else {
            $error = "Something went wrong . Please try again.";
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
      <!-- Typography Start -->
      <div class="container-fluid pt-4 px-4">
         <div class="row">
            <div class="col-sm-12">
               <div class="card-box">
                  <h4 class="m-t-0 header-title"><b>Edit Category </b></h4>
                  <hr />
                  <div class="row">
                     <div class="col-sm-6">
                        <!---Success Message--->
                        <?php if ($msg) { ?>
                        <div class="alert alert-success" role="alert">
                           <?php echo htmlentities($msg); ?>
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
                  <?php
                     $catid = intval($_GET['cid']);
                     $query = mysqli_query($con, "Select id,CategoryName,Description,PostingDate,UpdationDate from  tblcategory where Is_Active=1 and id='$catid'");
                     $cnt = 1;
                     while ($row = mysqli_fetch_array($query)) {
                     ?>
                  <div class="row">
                     <div class="col-md-6">
                        <form class="form-horizontal" name="category" method="post">
                           <div class="form-group">
                              <label class="col-md-2 control-label">Category</label>
                              <div class="col-md-10">
                                 <input type="text" class="form-control" value="<?php echo htmlentities($row['CategoryName']); ?>" name="category" required>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-2 control-label">Description</label>
                              <div class="col-md-10">
                                 <textarea class="form-control" rows="5" name="description" required><?php echo htmlentities($row['Description']); ?></textarea>
                              </div>
                           </div>
                           <?php } ?>
                           <div class="form-group">
                              <label class="col-md-2 control-label">&nbsp;</label>
                              <div class="col-md-10">
                                 <button type="submit" class="btn btn-success" name="submit">
                                 Update
                                 </button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- end row -->
      </div>
      <!-- container -->
   </div>
</div>

<?php require('includes/footer.php'); ?>
<?php } ?>

</body>
</html>