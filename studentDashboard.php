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
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/aos.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/Features-Image-icons.css">
    <link rel="stylesheet" href="assets/css/Floating-Button.css">
    <link rel="stylesheet" href="assets/css/untitled.css?v=2.0">
    <script src="assets/js/qrcode.min.js"></script>
    <?php include("partials/linkCss.php"); ?>
</head>

<body id="page-top" style="font-size: 12px;">
    <div id="wrapper" v-clock>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include("partials/navbar.php"); ?>
                <div class="container">
                    <div
                        class="col-md-8 col-xl-6 offset-md-2 offset-xl-3 d-flex justify-content-center align-items-center">
                        <h6 class="text-dark flex-fill mb-0"><strong>Student Dashboard</strong></h6><img
                            class="img-fluid" src="assets/img/avatars/male_user128.png" style="width: 32px;">
                    </div>
                </div>
                <hr>

                <section v-if="tab=='Home'">
                    <div class="container-fluid" data-aos="zoom-in-down" data-aos-once="true">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="card shadow mb-4"">
                                    <div class=" card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="text-center">This Month</h6>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Current Status</th>
                                                    <th class="text-end"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Picked up for Sctool</td>
                                                    <td class="text-end"
                                                        :class="attendanceStatus.pickedUpForSchool=='Pending'?'text-warning':'text-success'">
                                                        <strong>{{attendanceStatus.pickedUpForSchool}}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Dropped to School</td>
                                                    <td class="text-end"
                                                        :class="attendanceStatus.droppedForSchool=='Pending'?'text-warning':'text-success'">
                                                        <strong>{{attendanceStatus.droppedForSchool}}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Picked Up for Home</td>
                                                    <td class="text-end"
                                                        :class="attendanceStatus.pickedUpForHome=='Pending'?'text-warning':'text-success'">
                                                        <strong>{{attendanceStatus.pickedUpForHome}}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Dropped to Home</td>
                                                    <td class="text-end"
                                                        :class="attendanceStatus.droppedForHome=='Pending'?'text-warning':'text-success'">
                                                        <strong>{{attendanceStatus.droppedForHome}}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Attendance Summary</th>
                                                    <th class="text-end"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Presents</td>
                                                    <td class="text-end text-success"><strong>7/8</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Absent</td>
                                                    <td class="text-end text-danger"><strong>1</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> -->
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Cab Info</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Driver</td>
                                                    <td class="text-end text-info">
                                                        {{driver?.drivers?.users?.full_name ?? "Not Set"}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Vehicle Number</td>
                                                    <td class="text-end text-info">
                                                        <strong>{{driver?.drivers?.vehicle_number ?? "Not Set"}}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Driver Phone</td>
                                                    <td class="text-end text-info">
                                                        <strong>{{driver?.drivers?.users?.phone ?? "Not Set"}}</strong>
                                                    </td>
                                                </tr>
                                                <tr v-show="driver?.drivers?.users?.phone">
                                                    <td></td>
                                                    <td class="text-end">
                                                        <a :href="'tel:' + driver?.drivers?.users?.phone"
                                                            class="btn btn-primary btn-sm" type="button">
                                                            <i class="fas fa-phone-alt"></i> Call</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                               
                                                 <tr>
                                                    <th>Payment Info - This Month</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                             <tr>
                                                    <td>Monthly Fee</td>
                                                    <td class="text-end">{{student.monthly_fee}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td class="text-end">
                                                        <span
                                                            :class="isPaymentDoneForCurrentMonth?'text-success':'text-warning'"><strong>{{isPaymentDoneForCurrentMonth?'Paid':'Pending'}}</strong></span>

                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </section>
            <section v-if="tab=='QR'" data-aos="zoom-in-down" data-aos-once="true">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="text-center mb-3">Student Scanner</h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            <canvas id="qrcode"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section v-if="tab=='Holidays'">
                <div class="container-fluid" data-aos="zoom-in-down" data-aos-once="true">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="text-center">Holidays this year</h6>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Event Name</th>
                                                    <th class="text-end">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="holiday in holidays">
                                                    <td>{{holiday.event_name}}<div v-show="holiday.notes_name">
                                                            <span>{{holiday.notes_name}}</span>
                                                        </div>
                                                    </td>

                                                    <td class="text-end">{{holiday.holiday_date}}
                                                        {{holiday.day_name}}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="PaymentStatus" v-if="tab=='Payments'">
                <div class="container-fluid" data-aos="zoom-in-down" data-aos-once="true">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="text-center">Payment Status</h6>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th class="text-end text-success">Paid</th>
                                                </tr>
                                            </thead>
                                            <tbody> <tr>
                                                    <td colspan="2"><a class="btn btn-primary btn-sm" role="button" href="#myModal" data-bs-toggle="modal">+ New Payment</a></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td>Due Date</td>
                                                    <td class="text-end text-info"><strong>2026-Jun-10</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col d-flex justify-content-center align-items-center">
                                            <h6 class="text-start flex-fill m-0">Payment History</h6><i
                                                class="far fa-clock"></i>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Month Year</th>
                                                    <th class="text-end">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="payment in paymentTimeline">
                                                    <td>{{payment.monthYear}}</td>
                                                    <td class="text-end" :class="payment.paid_at?'text-success':'text-warning'"><strong>{{payment.paid_at?payment.paid_at:payment.status}}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include("partials/paymentQR.php"); ?>

            </section>
            <section id="Profile" v-if="tab=='Profile'">
                <?php include("partials/studentProfile.php"); ?>
            </section>

            <footer class="bg-white shadow fixed-bottom">
                <div class="row" style="font-size:9px">
                    <div class="col text-center d-flex justify-content-center p-0">
                        <button style="font-size: 11px;" @click="tab='Home'" :class="tab=='Home'?'active':''"
                            class="btn btn-light btn-sm border rounded-0 flex-fill py-2" type="button">
                            <i class="fas fa-home"></i><br>Home
                        </button>
                    </div>
                    <div class="col text-center d-flex justify-content-center p-0">
                        <button style="font-size: 11px;" @click="showQR()" :class="tab=='QR'?'active':''"
                            class="btn btn-light btn-sm border rounded-0 flex-fill py-2" type="button">
                            <i class="fas fa-id-card"></i><br>QR
                        </button>
                    </div>
                    <div class="col text-center d-flex justify-content-center p-0">
                        <button style="font-size: 11px;" @click="tab='Holidays'" :class="tab=='Holidays'?'active':''"
                            class="btn btn-light btn-sm border rounded-0 flex-fill py-2" type="button">
                            <i class="far fa-calendar-alt"></i><br>Holidays</button>
                    </div>
                    <div class="col text-center d-flex justify-content-center p-0">
                        <button style="font-size: 11px;" @click="tab='Payments'" :class="tab=='Payments'?'active':''"
                            class="btn btn-light btn-sm border rounded-0 flex-fill py-2" type="button"><i
                                class="fas fa-rupee-sign"></i><br>Payments</button>
                    </div>
                    <div class="col text-center d-flex justify-content-center p-0">
                        <button style="font-size: 11px;" @click="tab='Profile'" :class="tab=='Profile'?'active':''"
                            class="btn btn-light btn-sm border rounded-0 flex-fill py-2" type="button"><i
                                class="fa fa-user"></i><br>Profile</button>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="actionModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Take Action</h4><button class="btn-close" type="button" aria-label="Close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col text-center"><img class="border rounded shadow-sm mb-3"
                                src="assets/img/icons/male_user128.png"></div>
                    </div>
                    <div class="row">
                        <div class="col text-center"><button class="btn btn-primary mx-1" type="button">Call&nbsp;<i
                                    class="fas fa-phone-alt"></i></button><button class="btn btn-info link-light mx-1"
                                type="button">Scan&nbsp;<i class="fa fa-qrcode"></i></button><button
                                class="btn btn-success link-light mx-1" type="button">Mark&nbsp;<i
                                    class="fa fa-check"></i></button></div>
                    </div>
                </div>
                <div class="modal-footer d-flex align-items-center"><button class="btn btn-secondary flex-fill"
                        type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>
    <div class="my-5"></div>



    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/html5-qrcode.min.js"></script>
    <script src="assets/js/supabase-js.js"></script>
    <script src="assets/js/sweetalert2@11.js"></script>
    <script src="assets/js/project.js"></script>
    <script src="assets/js/theme.js"></script>
    <?php include("partials/linkScript.php"); ?>
    <script type="module">
        import { storageService, navigationService, validations, emailService, tools } from "./assets/code/js/localService.js";
        import { supabaseHelper } from "./services/supabaseService.js";

        const app = Vue.createApp({
            async mounted() {

                this.originalStudent = await storageService.get('user');
                this.student = JSON.parse(JSON.stringify(this.originalStudent));
                console.log(this.student);
                //debugger;
                //await this.generateQR(this.student.id);
                supabaseHelper.getAssignedDriverByStudentId(this.student.id).then((resp) => {
                if(resp.success)
                    this.driver = resp.data;
                    //debugger;
                });
                supabaseHelper.getHolidaysList().then((resp) => {
                    this.holidays = resp.holidays;
                    // debugger;
                });

                var data = { student_id: this.student.id };
                supabaseHelper.getPaymentHistory(data).then((resp) => {
                    debugger;
                    this.payments = resp.data;
                    console.log(this.payments);
                    const now = new Date();
                    const currentYear = now.getFullYear();
                    const currentMonth = now.getMonth() + 1; // JavaScript months are 0-based

                    this.isPaymentDoneForCurrentMonth = this.payments.some(payment =>
                        payment.payment_year === currentYear &&
                        payment.payment_month === currentMonth
                    );

                    this.paymentTimeline = this.getPaymentTimeline(this.payments);
                    console.log(this.paymentTimeline);
                });


                supabaseHelper.getAttendanceByStudentId(this.student.id).then((resp) => {
                    if (resp.success) {
                        const school = resp.data[0];
                        const home = resp.data[1];

                        const formatTime = (dateTime) => {
                            if (!dateTime) return "Pending";

                            return new Date(dateTime).toLocaleTimeString([], {
                                hour: "2-digit",
                                minute: "2-digit",
                                hour12: true,
                            });
                        };

                        this.attendanceStatus = {
                            pickedUpForSchool: formatTime(school?.pickup_time),
                            droppedForSchool: formatTime(school?.drop_time),
                            pickedUpForHome: formatTime(home?.pickup_time),
                            droppedForHome: formatTime(home?.drop_time),
                        };

                        console.log(this.student.attendanceStatus);
                    }
                    //debugger;
                });


                debugger;
                if (!this.student) {
                    navigationService.goto('login.php');
                }

                this.$nextTick(() => {
                    AOS.refresh();
                });
            },
            data() {
                return {
                    student: {},
                    originalStudent: {},
                    tab: 'Home',
                    panel: 'profileDetails',
                    driver: null,
                    errorMessage: '',
                    holidays: [],
                    payments: [],
                    paymentTimeline: [],
                    isPaymentDoneForCurrentMonth: false,
                    attendanceStatus: {
                        pickedUpForSchool: 'Pending',
                        droppedForSchool: 'Pending',
                        pickedUpForHome: 'Pending',
                        droppedForHome: 'Pending'
                    }
                };
            },

            methods: {
                async saveStudentProfile() {
                    this.errorMessage = '';
                    let errors = [
                        ...validations.validateName(this.student.full_name),
                        ...validations.validateEmail(this.student.email),
                        ...validations.validateMobile(this.student.phone),
                        ...validations.validateAddress(this.student.home_address).errors,
                        ...validations.validateAddress(this.student.pickup_location).errors,
                        ...validations.validateAddress(this.student.drop_location).errors,

                    ];

                    if (validations.hasElements(errors)) {
                        this.errorMessage = errors[0];
                        // errors.forEach((err) => {   // ✅ also fixed here
                        alertify.error(this.errorMessage);
                        // });
                        return;
                    }
                    try {
                        console.log(this.student);
                        debugger;

                        var resp = await supabaseHelper.saveStudent(this.student);
                        if (resp.success) {
                            await storageService.set('user', this.student);
                            this.originalStudent = this.student;
                            this.panel = 'profileDetails';
                            Swal.fire({
                                position: "top",
                                icon: "success",
                                title: "Profile Updated",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                    catch (error) {
                        console.error(error);

                        this.errorMessage = error.response?.data?.message || "Somthing went wrong.";
                    }
                    finally { this.loading = false; }
                },
                async generateQR(guid) {
                    const canvas = document.getElementById("qrcode");
                    console.log(canvas); // Should not be null
                    QRCode.toCanvas(canvas, guid, {
                        width: 280,
                        margin: 2
                    }, function (err) {
                        if (err) console.error(err);
                        else {

                            console.log("QR code generated");
                        }
                    });
                },
                async showQR() {
                    this.tab = 'QR';
                    await tools.wait(250);
                    this.generateQR(this.student.id);

                },
                getPaymentTimeline(payments) {
                    if (!payments.length) return [];

                    // Find the oldest payment month
                    const oldest = payments.reduce((min, curr) => {
                        const minDate = new Date(min.payment_year, min.payment_month - 1);
                        const currDate = new Date(curr.payment_year, curr.payment_month - 1);
                        return currDate < minDate ? curr : min;
                    });

                    const start = new Date(oldest.payment_year, oldest.payment_month - 1);
                    const end = new Date(); // Today

                    // Create a lookup map
                    const paymentMap = new Map(
                        payments.map((p) => [
                            `${p.payment_year}-${String(p.payment_month).padStart(2, "0")}`,
                            p,
                        ])
                    );

                    const result = [];
                    const current = new Date(start);

                    while (current <= end) {
                        const year = current.getFullYear();
                        const month = current.getMonth() + 1;

                        const key = `${year}-${String(month).padStart(2, "0")}`;
                        const payment = paymentMap.get(key);

                        result.push({
                            monthYear: current.toLocaleString("en-US", {
                                month: "short",
                                year: "numeric",
                            }),
                            status: payment?.paid_at ?? payment?.created_at ? "Paid" : "Pending",
                            paid_at: payment
                                ? new Date(payment.paid_at ?? payment.created_at).toLocaleDateString()
                                : null,
                        });

                        current.setMonth(current.getMonth() + 1);
                    }

                    return result.reverse();
                }


            },

        });

        app.mount("#wrapper");
    </script>
</body>

</html>
