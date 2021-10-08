<?php
session_start();
include("../path.php");
require_once(ROOT_PATH . '/include/db-functions.php');
if (isset($_SESSION['user_id']) && $_SESSION['user_role_id'] !== 3) { ?>

<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="./assets/css/admin-style.css">
    <link rel="stylesheet" href="./assets/css/form.css">
    <!-- FONT AWSOME CDN -->
    <script src="https://kit.fontawesome.com/0f79449357.js" crossorigin="anonymous"></script>
<title>Dashboard | TheHours</title>
<link rel="stylesheet" href="../assets/css/admin-style.css">

</head>

<body>
    <!-- BEGIN HEADER -->
    <div class="admin-header">
    <div class="logo">
        <a href="<?php echo BASE_URL . "dashboard/"; ?>">ADMIN DASHBOARD</a>
    </div>

    <?php include(ROOT_PATH . '/admin/include/menu.php'); ?>
    </div>

<!-- END HEADER -->

    <!-- Admin Page Wrapper -->
    <div class="admin-wrap">

        <?php include(ROOT_PATH . '/admin/include/sidebar.php'); ?>

        <!-- Admin Content -->
        <div class="admin-content">

            <h2 class="page-title">Dashboard</h2>
            </br>
            <p>Chào mừng <span style="color: red;"><?php echo $_SESSION['user_username'] ?></span> đến trang Dashborad!</p>
            </br>
            <p>Ở đây bạn sẽ cập nhật dữ liệu của trang web</p>

            
            <!-- // Admin Content -->
        </div>
        <!-- // Page Wrapper -->
</div>
</body>

</html>
<?php } else {
    header('location: ' . BASE_URL);
    exit(0);
}?>