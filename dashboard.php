<?php

session_start();
$isLoggedIn = $_SESSION['is_logged_in'];


?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>School Trip</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/Features-Image-icons.css">
    <link rel="stylesheet" href="assets/css/Floating-Button.css">
    <link rel="stylesheet" href="assets/css/untitled.css?v=2.0">
    <?php include("partials/linkScript.php"); ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include("partials/sidebar.php"); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include("partials/navbar.php"); ?>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Dashboard</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card shadow border-left-primary py-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col d-lg-flex align-items-lg-center">
                                            <h4>Students</h4>
                                        </div>
                                        <div class="col-auto"><img class="img-fluid"
                                                src="assets/img/avatars/male_users.png"></div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Total Registered</td>
                                                <td>33</td>
                                            </tr>
                                            <tr>
                                                <td>Onboarded</td>
                                                <td>25</td>
                                            </tr>
                                            <tr>
                                                <td>Pending</td>
                                                <td>7</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col text-end px-5"><button class="btn btn-primary" type="button">View
                                            all</button></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card shadow border-left-success py-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col d-lg-flex align-items-lg-center">
                                            <h4>Drivers</h4>
                                        </div>
                                        <div class="col-auto"><img class="img-fluid" src="assets/img/taxi.png"></div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Total Registered</td>
                                                <td>9</td>
                                            </tr>
                                            <tr>
                                                <td>On Duty</td>
                                                <td>6</td>
                                            </tr>
                                            <tr>
                                                <td>Pending</td>
                                                <td>3</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col text-end px-5"><button class="btn btn-primary" type="button">View
                                            all</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("partials/footer.php"); ?>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/html5-qrcode.min.js"></script>
    <script src="assets/js/project.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
