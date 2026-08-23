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

<body id="page-top" class="bg-light" style="font-family: 'Nunito', sans-serif;">
    <div id="wrapper" v-clock>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include("partials/navbar.php"); ?>
                
                <section v-if="tab=='Home'">
                    <div class="container-fluid pb-5" data-aos="zoom-in-down" data-aos-once="true">
                        <div class="row">
                            <div class="col-md-8 col-xl-6 offset-md-2 offset-xl-3 d-flex flex-column gap-3">
                                
                                <!-- Attendance Card -->
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-header bg-white border-0 pt-3 pb-0">
                                        <h6 class="fw-bold text-dark mb-0"><i class="fas fa-clock text-primary me-2"></i>Today's Attendance</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                                                <span class="text-muted"><i class="fas fa-bus text-warning me-2"></i>Picked up for School</span>
                                                <span class="badge rounded-pill fw-bold" :class="attendanceStatus.pickedUpForSchool=='Pending'?'bg-warning text-dark':'bg-success text-white'">{{attendanceStatus.pickedUpForSchool}}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                                                <span class="text-muted"><i class="fas fa-school text-success me-2"></i>Dropped to School</span>
                                                <span class="badge rounded-pill fw-bold" :class="attendanceStatus.droppedForSchool=='Pending'?'bg-warning text-dark':'bg-success text-white'">{{attendanceStatus.droppedForSchool}}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                                                <span class="text-muted"><i class="fas fa-bus text-warning me-2"></i>Picked up for Home</span>
                                                <span class="badge rounded-pill fw-bold" :class="attendanceStatus.pickedUpForHome=='Pending'?'bg-warning text-dark':'bg-success text-white'">{{attendanceStatus.pickedUpForHome}}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                                                <span class="text-muted"><i class="fas fa-home text-success me-2"></i>Dropped to Home</span>
                                                <span class="badge rounded-pill fw-bold" :class="attendanceStatus.droppedForHome=='Pending'?'bg-warning text-dark':'bg-success text-white'">{{attendanceStatus.droppedForHome}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Cab Info Card -->
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-header bg-white border-0 pt-3 pb-0">
                                        <h6 class="fw-bold text-dark mb-0"><i class="fas fa-car text-info me-2"></i>Cab & Driver Info</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                                <i class="fas fa-user-tie text-info fa-lg"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 fw-bold text-dark">{{driver?.drivers?.users?.full_name ?? "Not Set"}}</h6>
                                                <small class="text-muted">Assigned Driver</small>
                                            </div>
                                            <a v-if="driver?.drivers?.users?.phone" :href="'tel:' + driver?.drivers?.users?.phone" class="btn btn-outline-primary rounded-pill btn-sm px-3 shadow-sm">
                                                <i class="fas fa-phone-alt me-1"></i> Call
                                            </a>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center bg-light rounded-3 p-3">
                                            <span class="text-muted">Vehicle Number</span>
                                            <strong class="text-dark">{{driver?.drivers?.vehicle_number ?? "Not Set"}}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Info Card -->
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-header bg-white border-0 pt-3 pb-0">
                                        <h6 class="fw-bold text-dark mb-0"><i class="fas fa-rupee-sign text-success me-2"></i>Payment Status (This Month)</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Monthly Fee</span>
                                            <strong class="fs-5 text-dark">₹{{student.monthly_fee}}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Status</span>
                                            <span class="badge rounded-pill px-3 py-2 fw-bold" :class="isPaymentDoneForCurrentMonth?'bg-success':'bg-warning text-dark'">
                                                {{isPaymentDoneForCurrentMonth?'Paid':'Pending'}}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </section>
            <section v-if="tab=='QR'" data-aos="zoom-in-down" data-aos-once="true">
                <div class="container-fluid pb-5">
                    <div class="row">
                        <div class="col-md-8 col-xl-6 offset-md-2 offset-xl-3 d-flex flex-column gap-3">
                            <div class="card shadow-sm border-0 rounded-4 text-center pb-4">
                                <div class="card-header bg-white border-0 pt-4 pb-0">
                                    <h5 class="fw-bold text-dark mb-1">Your Identity QR</h5>
                                    <p class="text-muted small">Show this code to your driver</p>
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <div class="bg-light p-3 rounded-4 border shadow-sm">
                                        <canvas id="qrcode" class="rounded-3"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section v-if="tab=='Holidays'">
                <div class="container-fluid pb-5" data-aos="zoom-in-down" data-aos-once="true">
                    <div class="row">
                        <div class="col-md-8 col-xl-6 offset-md-2 offset-xl-3 d-flex flex-column gap-3">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-white border-0 pt-4 pb-2">
                                    <h5 class="fw-bold text-dark mb-0"><i class="far fa-calendar-alt text-primary me-2"></i> Upcoming Holidays</h5>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush rounded-4 overflow-hidden">
                                        <li v-for="holiday in holidays" class="list-group-item d-flex justify-content-between align-items-center p-3 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 text-center" style="min-width: 65px;">
                                                    <span class="d-block fw-bold text-primary">{{holiday.holiday_date.split(' ')[0]}}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold text-dark">{{holiday.event_name}}</h6>
                                                    <small class="text-muted" v-show="holiday.notes_name">{{holiday.notes_name}}</small>
                                                </div>
                                            </div>
                                            <span class="badge bg-light text-dark border">{{holiday.day_name}}</span>
                                        </li>
                                    </ul>
                                    <div v-if="!holidays.length" class="text-center py-5">
                                        <i class="far fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted fw-bold">No upcoming holidays</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="PaymentStatus" v-if="tab=='Payments'">
                <div class="container-fluid pb-5" data-aos="zoom-in-down" data-aos-once="true">
                    <div class="row">
                        <div class="col-md-8 col-xl-6 offset-md-2 offset-xl-3 d-flex flex-column gap-3">
                            
                            <!-- Payment Status Card -->
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-wallet text-success me-2"></i> Payment Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 mb-3">
                                        <div>
                                            <span class="text-muted d-block mb-1">Due Date</span>
                                            <strong class="text-dark fs-5">10th of Month</strong>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-muted d-block mb-1">Status</span>
                                            <span class="badge rounded-pill fw-bold bg-success px-3 py-2">Paid</span>
                                        </div>
                                    </div>
                                    <a class="btn btn-outline-success rounded-pill w-100 fw-bold py-2 shadow-sm" role="button" href="#myModal" data-bs-toggle="modal">
                                        <i class="fas fa-plus-circle me-1"></i> New Payment
                                    </a>
                                </div>
                            </div>

                            <!-- Payment History Card -->
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-white border-0 pt-4 pb-2">
                                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-history text-primary me-2"></i> Payment History</h5>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush rounded-bottom-4 overflow-hidden">
                                        <li v-for="payment in paymentTimeline" class="list-group-item d-flex justify-content-between align-items-center p-3 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light p-2 rounded-3 me-3 text-center border">
                                                    <i class="far fa-calendar-alt text-muted"></i>
                                                </div>
                                                <h6 class="mb-0 fw-bold text-dark">{{payment.monthYear}}</h6>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge rounded-pill d-block mb-1" :class="payment.paid_at?'bg-success':'bg-warning text-dark'">
                                                    {{payment.paid_at ? 'Paid: ' + payment.paid_at : payment.status}}
                                                </span>
                                                <a v-if="payment.paid_at" :href="'receipt.php?month=' + payment.monthYear + '&paid_at=' + payment.paid_at" class="btn btn-sm btn-outline-primary rounded-pill" target="_blank" style="font-size: 0.75rem;">
                                                    <i class="fas fa-file-invoice me-1"></i> Receipt
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div v-if="!paymentTimeline.length" class="text-center py-5">
                                        <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted fw-bold">No payment history</h6>
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

            <footer class="bg-white shadow-lg fixed-bottom border-top">
                <div class="d-flex justify-content-around align-items-center py-2 pb-3 px-1">
                    <div class="text-center flex-fill" role="button" @click="tab='Home'" :class="tab=='Home'?'text-primary fw-bold':'text-muted'">
                        <i class="fas fa-home fs-5 d-block mb-1" :class="tab=='Home'?'fa-lg':''"></i>
                        <span style="font-size: 0.7rem; letter-spacing: 0.3px;">Home</span>
                    </div>
                    <div class="text-center flex-fill" role="button" @click="showQR()" :class="tab=='QR'?'text-primary fw-bold':'text-muted'">
                        <i class="fas fa-qrcode fs-5 d-block mb-1" :class="tab=='QR'?'fa-lg':''"></i>
                        <span style="font-size: 0.7rem; letter-spacing: 0.3px;">QR Code</span>
                    </div>
                    <div class="text-center flex-fill" role="button" @click="tab='Holidays'" :class="tab=='Holidays'?'text-primary fw-bold':'text-muted'">
                        <i class="far fa-calendar-alt fs-5 d-block mb-1" :class="tab=='Holidays'?'fa-lg':''"></i>
                        <span style="font-size: 0.7rem; letter-spacing: 0.3px;">Holidays</span>
                    </div>
                    <div class="text-center flex-fill" role="button" @click="tab='Payments'" :class="tab=='Payments'?'text-primary fw-bold':'text-muted'">
                        <i class="fas fa-rupee-sign fs-5 d-block mb-1" :class="tab=='Payments'?'fa-lg':''"></i>
                        <span style="font-size: 0.7rem; letter-spacing: 0.3px;">Payments</span>
                    </div>
                    <div class="text-center flex-fill" role="button" @click="tab='Profile'" :class="tab=='Profile'?'text-primary fw-bold':'text-muted'">
                        <i class="far fa-user fs-5 d-block mb-1" :class="tab=='Profile'?'fa-lg':''"></i>
                        <span style="font-size: 0.7rem; letter-spacing: 0.3px;">Profile</span>
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
    <div class="my-4 py-2"></div>



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

                if (window.location.hash) {
                    const hashTab = window.location.hash.substring(1);
                    const validTabs = ['Home', 'QR', 'Holidays', 'Payments', 'Profile'];
                    if (validTabs.includes(hashTab)) {
                        this.tab = hashTab;
                    }
                }

                window.addEventListener('hashchange', () => {
                    const hashTab = window.location.hash.substring(1);
                    const validTabs = ['Home', 'QR', 'Holidays', 'Payments', 'Profile'];
                    if (validTabs.includes(hashTab)) {
                        this.tab = hashTab;
                    }
                });

                this.$nextTick(() => {
                    AOS.refresh();
                });
            },
            watch: {
                tab(newTab) {
                    window.location.hash = newTab;
                }
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
