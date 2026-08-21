<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>School Trip</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/css/aos.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/Features-Image-icons.css">
    <link rel="stylesheet" href="assets/css/Floating-Button.css">
    <link rel="stylesheet" href="assets/css/untitled.css?v=2.0">
    <?php include("partials/linkCss.php"); ?>
    <style>

    </style>
</head>

<body class="bg-gradient-primary">
    <div id="signup" class="container" v-cloak>
        <div class="row">
            <div class="col-lg-8 offset-lg-2 p-xs-4 p-4">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h4 class="text-dark rubberBand animated mb-4">Create an Account!</h4>
                        </div>
                        <form class="user" @submit.prevent="register">
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input data-aos="fade-up" data-aos-once="true"
                                        class="form-control form-control-user" type="text" placeholder="First Name"
                                        v-model="user.first_name">
                                </div>

                                <div class="col-sm-6">
                                    <input data-aos="fade-up" data-aos-once="true"
                                        class="form-control form-control-user" type="text" placeholder="Last Name"
                                        v-model="user.last_name">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-12">
                                    <div class="mb-3">
                                        <input data-aos="fade-up" data-aos-delay="100" data-aos-once="true"
                                            class="form-control form-control-user" type="text"
                                            placeholder="Mobile Number" v-model="user.phone" maxlength="10">
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-12">
                                    <div class="mb-3">
                                        <input data-aos="fade-up" data-aos-delay="200" data-aos-once="true"
                                            class="form-control form-control-user" type="email"
                                            placeholder="Email Address" v-model="user.email">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input data-aos="fade-up" data-aos-delay="300" data-aos-once="true"
                                        class="form-control form-control-user" type="password" placeholder="Password"
                                        v-model="user.password">
                                </div>

                                <div class="col-sm-6">
                                    <input data-aos="fade-up" data-aos-delay="400" data-aos-once="true"
                                        class="form-control form-control-user" type="password"
                                        placeholder="Repeat Password" v-model="user.password_repeat">
                                </div>
                            </div>

                            <button data-aos="fade-up" data-aos-delay="500" data-aos-once="true"
                                class="btn btn-primary d-block btn-user w-100 mb-2" type="submit">
                                Register Account
                            </button>
                            <br />
                            <a href="login.php" data-aos="fade-up" data-aos-delay="500"
                                class="btn btn-info link-light d-block btn-user w-100">Login</a>
                        </form>
                        <div class="text-center" data-aos="fade-down" data-aos-once="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.min.js"></script>
    <?php include("partials/linkScript.php"); ?>
    <script src="assets/js/project.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/bs-init.js"></script>


    <script type="module">
        import { storageService, navigationService, validations, emailService } from "./assets/code/js/localService.js";
        import { supabaseHelper } from "./services/supabaseService.js";

        const app = Vue.createApp({
            data() {
                return {
                    user: {
                        // "full_name": "test",
                        // "first_name": "test",
                        // "last_name": "test",
                        // "phone": "9898989811",
                        // "email": "projectwala.in@gmail.com",
                        // "password": "Password@123",
                        // password_repeat: 'Password@123',
                        // err: ''
                    }
                }
            },
            methods: {

                async register() {
                    debugger;
                    console.log(this.user);
                    let errors = [
                        ...validations.validateName(this.user.first_name, "First Name"),
                        ...validations.validateName(this.user.last_name, "Last Name"),
                        ...validations.validateMobile(this.user.phone),
                        ...validations.validateEmail(this.user.email,false),
                        ...validations.validatePassword(this.user.password),
                        ...validations.validateConfirmPassword( this.user.password, this.user.password_repeat ),
                    ];


                    if (validations.hasElements(errors)) {
                        // errors.forEach((err) => {   // ✅ also fixed here
                        alertify.error(errors[0]);
                        // });
                        return;
                    }
                    debugger;
                    this.user.full_name = `${this.user.first_name || ''} ${this.user.last_name || ''}`.trim();
                    var resp = await supabaseHelper.createStudent(this.user);
                    if (resp.success) {

                        const result = await emailService.sendEmailConfirmation(this.user.email, resp.data.student.id);


                        if (result.success) {
                            console.log(result.data);

                            Swal.fire({
                                title: "Profile created!",
                                text: "Proceed to login",//"Please check your inbox & confirm Email!",
                                icon: "success"
                            }).then(() => {
                                navigationService.goto('login.php');
                            });
                        } else {
                            console.error(result.error);
                        }


                        Swal.fire({
                            title: "Profile created!",
                            text: "Please check your inbox & confirm Email !",
                            icon: "success"
                        }).then(() => {
                            // navigationService.goto('login.php');
                        });
                    }
                    else {
                        alertify.error(resp.message);
                    }
                },

                async test() {
                    var resp = await supabaseHelper.getActiveStudentsAttendance();
                    console.log(resp);
                }
            },
            mounted() {

            }
        });

        app.mount("#signup");
    </script>
</body>

</html>
