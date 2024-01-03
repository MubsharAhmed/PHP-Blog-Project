<!-- Add jQuery library (CDN) before this code if not already included -->
<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.php" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">Dashboard</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="<?php echo $_SESSION['profile_image']; ?>" alt="" style="width: 40px; height: 40px; border: 2px solid #009CFF">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0"><?php echo $_SESSION['name']; ?></h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="index.php" class="nav-item nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['add-category.php', 'manage-category.php'])) ? 'show' : ''; ?>">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Categories</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="add-category.php" class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'add-category.php') ? 'active' : ''; ?>">Add Category</a>
                    <a href="manage-category.php" class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-category.php') ? 'active' : ''; ?>">Manage Category</a>
                </div>
            </div>
            <div class="nav-item dropdown <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['add-post.php', 'manage-post.php', 'trash-post.php'])) ? 'show' : ''; ?>">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Post</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="add-post.php" class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'add-post.php') ? 'active' : ''; ?>">Add Post</a>
                    <a href="manage-post.php" class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-post.php') ? 'active' : ''; ?>">Manage Post</a>
                    <a href="trash-post.php" class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'trash-post.php') ? 'active' : ''; ?>">Trashed Post</a>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- Sidebar End -->