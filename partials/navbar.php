<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
$user = isset($_SESSION['is_logged_in']) ? $_SESSION['user'] : null;
?>
<nav class="navbar navbar-expand bg-white shadow mb-4 topbar">
    <div class="container container-fluid">
        <h4>Welcome</h4>
        <ul class="navbar-nav flex-nowrap ms-auto">
            <?php if (!$isLoggedIn) { ?>
                <li class="nav-item dropdown no-arrow"><a class="nav-link" href="about-us.php">About</a></li>
                <li class="nav-item dropdown no-arrow"><a class="nav-link" href="register.php">New User</a></li>
                <li class="nav-item dropdown no-arrow"><a class="nav-link" href="login.php">Login</a></li>
            <?php } else { ?>
                <div class="d-none d-sm-block topbar-divider"></div>
                <li class="nav-item dropdown no-arrow">
                    <div class="nav-item dropdown no-arrow">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                            <span
                                class="d-none d-lg-inline me-2 text-gray-600 small"><?php echo $user['user']['full_name'] ?></span>
                            <img class="border rounded-circle img-profile" src="assets/img/avatars/business_user64.png">
                        </a>
                        <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                            <!-- <a class="dropdown-item" href="#"><i
                                    class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                            <a class="dropdown-item" href="#"><i
                                    class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a>
                            <a class="dropdown-item" href="#"><i
                                    class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a> -->
                            <!-- <div class="dropdown-divider"></div> -->
                            <a class="dropdown-item" href="partials/logout.php">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                        </div>
                    </div>
                </li>
            <?php } ?>

        </ul>
    </div>
</nav>