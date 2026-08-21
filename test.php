<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/aos.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/Features-Image-icons.css">
    <link rel="stylesheet" href="assets/css/Floating-Button.css">
    <link rel="stylesheet" href="assets/css/untitled.css?v=2.0">
    <?php include("partials/linkCss.php"); ?>
</head>

<body id="page-top">
    <div id="app">
    <drivers-component></drivers-component>
</div>

<template id="drivers-template">
    <div style="background:red;padding:20px">
        DRIVER WORKING
    </div>
</template>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

<script>
window.driversComponent = {
    template: '#drivers-template'
};

const app = Vue.createApp({});

app.component('drivers-component', window.driversComponent);

app.mount('#app');
</script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/html5-qrcode.min.js"></script>
    <script src="assets/js/qrcode.min.js"></script>
    
    <script src="assets/js/sweetalert2@11.js"></script>
    <script src="assets/js/project.js"></script>
    <script src="assets/js/theme.js"></script>
    <?php include("partials/linkScript.php"); ?>
   
</body>

</html>
