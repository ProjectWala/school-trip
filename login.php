<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>School Trip</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/Features-Image-icons.css">
    <link rel="stylesheet" href="assets/css/Floating-Button.css">
    <link rel="stylesheet" href="assets/css/untitled.css?v=2.0">

</head>

<body class="bg-gradient-primary">
    <div class="container" id="login" v-cloak>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10 mt-5">
                <div class="card shadow-lg o-hidden border-0 my-5 p-4">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex justify-content-lg-center align-items-lg-center">
                                <lottie-player src="assets/js/animatedjsons/TrackingMaps.json" autoplay loop
                                    style="width: 350px;">
                                </lottie-player>
                            </div>

                            <div class="col-lg-6">
                                <div class="p-3" v-if="!showForgotPassword">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">
                                            <strong>Transport & Tracking</strong>
                                        </h4>
                                    </div>

                                    <hr>

                                    <form class="user" @submit.prevent="login">
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="text"
                                                placeholder="Enter Email Address..." v-model="emailid" required>
                                        </div>

                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="password"
                                                placeholder="Password" v-model="password" required>
                                        </div>

                                        <div class="mb-3">
                                            <div class="custom-checkbox small">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="rememberMe"
                                                        v-model="rememberMe">

                                                    <label class="form-check-label" for="rememberMe">
                                                        Remember Me
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary d-block btn-user w-100" type="submit"
                                            :disabled="loading">

                                            {{ loading ? 'Logging in...' : 'Login' }}
                                        </button>

                                        <a href="register.php"
                                            class="btn btn-info d-block btn-user w-100 text-white mt-2"
                                            :disabled="loading">
                                            New User
                                        </a>

                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="#" @click.prevent="showForgotPassword = true">Forgot
                                                Password?</a>
                                        </div>

                                        <div v-if="errorMessage" class="alert alert-danger bounce animated mt-3">
                                            {{ errorMessage }}
                                        </div>
                                        <a class="btn btn-primary d-block btn-user w-100 mt-2" href="index.php">Back to
                                            Home</a>
                                    </form>
                                    
                                </div>

                                <div class="p-3" v-else>
                                    <div class="text-center">
                                        <h4 class="text-dark mb-2">Forgot Your Password?</h4>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>

                                    <hr>

                                    <form class="user" @submit.prevent="handleForgotPassword">
                                        <div class="mb-3">
                                            <input type="email" class="form-control form-control-user"
                                                placeholder="Enter Email Address..." v-model="forgotPasswordEmail"
                                                required>
                                        </div>
                                        <button class="btn btn-primary d-block btn-user w-100" type="submit"
                                            :disabled="loading">
                                            {{ loading ? 'Sending...' : 'Reset Password' }}
                                        </button>
                                    </form>

                                    <hr>

                                    <div class="text-center">
                                        <a class="small" href="#" @click.prevent="showForgotPassword = false">Already
                                            have an account? Login!</a>
                                    </div>

                                    <div v-if="forgotPasswordMessage"
                                        :class="['alert', forgotPasswordStatus === 'success' ? 'alert-success' : 'alert-danger', 'bounce animated mt-3']">
                                        {{ forgotPasswordMessage }}
                                    </div>

                                    <a class="btn btn-primary d-block btn-user w-100 mt-2" href="index.php">Back to
                                        Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/lottie-player.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/html5-qrcode.min.js"></script>
    <script src="assets/js/project.js"></script>
    <script src="assets/js/theme.js"></script>
    <?php include("partials/linkScript.php"); ?>
    <script type="module">
        import { storageService, navigationService, validations, emailService } from "./assets/code/js/localService.js";

        const app = Vue.createApp({
            data() {
                return {
                    emailid: "",
                    password: "",
                    rememberMe: false,
                    loading: false,
                    errorMessage: "",
                    showForgotPassword: false,
                    forgotPasswordEmail: "",
                    forgotPasswordMessage: "",
                    forgotPasswordStatus: ""
                };
            },

            methods: {
                async login() {
                    this.errorMessage = null;
                    try {
                        this.loading = true;
                        this.errorMessage = "";

                        const payload = {
                            email: this.emailid,
                            password: this.password
                        };

                        const response = await fetch("apis/login.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(payload),
                        });

                        const resp = await response.json();

                        console.log("Login Success:", resp);
                        debugger;

                        if (!resp.success) {
                            
                            this.errorMessage = resp.message;
                            return;

                        }


                        // Save token if returned
                        if (resp?.token) {
                            localStorage.setItem(
                                "token",
                                resp.token
                            );
                        }

                        if (resp?.data) {
                            var user = resp?.data;
                            storageService.set("user", user);

                            if (user.user.role == 'DRIVER')
                                window.location.href = "driverDashboard.php";
                            else if (user.user.role == 'STUDENT')
                                window.location.href = "studentDashboard.php";
                            else if (user.user.role == 'ADMIN')
                                window.location.href = "adminDashboard.php";
                        }
                        // Redirect


                    }
                    catch (error) {
                        console.error(error);

                        this.errorMessage =
                            error.response?.resp?.message ||
                            "Invalid email or password.";
                    }
                    finally {
                        this.loading = false;
                    }
                },
                async handleForgotPassword() {
                    this.forgotPasswordMessage = "";
                    this.forgotPasswordStatus = "";
                    try {
                        this.loading = true;
                        // For now, let's just simulate an API call
                        // You should create apis/forgotPassword.php or similar
                        /*
                        const response = await fetch("apis/forgotPassword.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ email: this.forgotPasswordEmail }),
                        });
                        const resp = await response.json();
                        */

                        // Simulating success
                        await new Promise(resolve => setTimeout(resolve, 1000));
                        this.forgotPasswordMessage = "If an account exists for " + this.forgotPasswordEmail + ", you will receive a password reset link shortly.";
                        this.forgotPasswordStatus = "success";
                    } catch (error) {
                        this.forgotPasswordMessage = "An error occurred. Please try again later.";
                        this.forgotPasswordStatus = "error";
                    } finally {
                        this.loading = false;
                    }
                },
                async test() {

                }
            }
        });

        app.mount("#login");
    </script>
</body>

</html>
