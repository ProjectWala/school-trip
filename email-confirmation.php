<?php

// Get the code from the URL
$code = $_GET['code'] ?? '';
$msg = '';
if (empty($code)) {
    $msg = 'Invalid Link';
}

// API URL
$apiUrl = "https://mchfbsmlsgadpoawzwkk.supabase.co/functions/v1/confirm-student-email?student_id=" . urlencode($code);

// Initialize cURL
$ch = curl_init($apiUrl);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPGET, true);

// Execute the request
$result = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    die("cURL Error: " . curl_error($ch));
}

curl_close($ch);

// $result contains the API response
$response = json_decode($result, true);

$success = $response['success'] ?? false;
$message = ($success)? $response['message'] : 'Invalid or Expired link.';

?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/css/aos.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/Features-Image-icons.css">
    <link rel="stylesheet" href="assets/css/Floating-Button.css">
    <link rel="stylesheet" href="assets/css/untitled.css?v=2.0">
</head>

<body class="bg-gradient-primary" style="background: rgb(255,255,255);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 mt-5">
                <div class="card shadow-lg o-hidden border-0 my-5 p-4">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <h4 class="text-dark mb-4" data-aos="fade-up"><strong>Email Confirmation !</strong>
                                    </h4>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col text-center">
                                        <?php if ($success): ?>
                                            <img class="tada animated my-4" src="assets/img/icons/accept.png" width="120">
                                        <?php else: ?>
                                            <img class="bounce animated my-4" src="assets/img/icons/delete.png" width="120">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h5 class="text-center <?= $success ? 'text-success' : 'text-danger' ?>">
                                            <strong>
                                                <?= htmlspecialchars($message) ?>
                                            </strong>
                                        </h5>
                                    </div>
                                </div>
                                <hr data-aos="fade-up" data-aos-delay="250" data-aos-once="true">
                                <a href="login.php" class="btn btn-primary d-block jello animated btn-user w-100" type="submit">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/html5-qrcode.min.js"></script>
    <script src="assets/js/sweetalert2@11.js"></script>
    <script src="assets/js/project.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
