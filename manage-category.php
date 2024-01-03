<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Categories</title>
    <?php require('includes/header.php'); ?>
</head>

<?php
    error_reporting(0);
    if (strlen($_SESSION['login']) == 0) {
        header('location:login.php');
    } else {
        if ($_GET['action'] == 'del' && $_GET['rid']) {
            $id = intval($_GET['rid']);
            $query = mysqli_query($con, "update tblcategory set Is_Active='0' where id='$id'");
            $msg = "Category deleted ";
        }
        if ($_GET['resid']) {
            $id = intval($_GET['resid']);
            $query = mysqli_query($con, "update tblcategory set Is_Active='1' where id='$id'");
            $msg = "Category restored successfully";
        }
        // Code for Forever deletionparmdel
        if ($_GET['action'] == 'parmdel' && $_GET['rid']) {
            $id = intval($_GET['rid']);
            $query = mysqli_query($con, "delete from  tblcategory  where id='$id'");
            $delmsg = "Category deleted forever";
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
                    <div class="col-sm-6">

                        <?php if ($msg) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo htmlentities($msg); ?>
                            </div>
                        <?php } ?>
                        <?php if ($delmsg) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlentities($delmsg); ?></div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="demo-box m-t-20">
                                <div class="m-b-30">
                                    <a href="add-category.php">
                                        <button id="addToTable" class="btn btn-success waves-effect waves-light">
                                            Add Category <i class="mdi mdi-plus-circle-outline"></i>
                                        </button>
                                    </a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table m-0 table-colored-bordered table-bordered-primary">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Posting Date</th>
                                                <th>Last Updation Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($con, "SELECT id,CategoryName,Description,PostingDate,UpdationDate FROM tblcategory WHERE Is_Active=1");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                    <td><?php echo htmlentities($row['CategoryName']); ?></td>
                                                    <td><?php echo htmlentities($row['Description']); ?></td>
                                                    <td><?php echo htmlentities($row['PostingDate']); ?></td>
                                                    <td><?php echo htmlentities($row['UpdationDate']); ?></td>
                                                    <td>
                                                        <a href="edit-category.php?cid=<?php echo htmlentities($row['id']); ?>">
                                                            <i class="fa fa-edit" style="color: #29b6f6"></i>
                                                        </a>
                                                        &nbsp;
                                                        <a href="manage-category.php?rid=<?php echo htmlentities($row['id']); ?>&&action=del">
                                                            <i class="fa fa-trash" style="color: #f05050"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                                $cnt++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- end row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="demo-box m-t-20">
                                <div class="m-b-30">
                                    <br><br>
                                    <hr style="border: 2px solid red;">
                                    <h4 class="text-danger"><i class="fa fa-trash"></i> Deleted Categories</h4>
                                </div>

                                <div class="table-responsive">
                                    <table class="table m-0 table-colored-bordered table-bordered-danger">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Posting Date</th>
                                                <th>Last Updation Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($con, "SELECT id,CategoryName,Description,PostingDate,UpdationDate FROM tblcategory WHERE Is_Active=0");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                    <td><?php echo htmlentities($row['CategoryName']); ?></td>
                                                    <td><?php echo htmlentities($row['Description']); ?></td>
                                                    <td><?php echo htmlentities($row['PostingDate']); ?></td>
                                                    <td><?php echo htmlentities($row['UpdationDate']); ?></td>
                                                    <td>
                                                        <a href="manage-category.php?resid=<?php echo htmlentities($row['id']); ?>">
                                                            <i class="fas fa-undo" title="Restore this category"></i>
                                                        </a>
                                                        &nbsp;
                                                        <a href="manage-category.php?rid=<?php echo htmlentities($row['id']); ?>&&action=parmdel" title="Delete forever">
                                                            <i class="fa fa-trash" style="color: #f05050"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                                $cnt++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container -->
 
    <?php require('includes/footer.php'); ?>
    <?php } ?>
</body>
</html>
