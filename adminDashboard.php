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
        <div id="wrapper">
            <?php include("partials/sidebar.php"); ?>
            <div class="d-flex flex-column" id="content-wrapper">
                <div id="content" v-cloak>
                    <?php include("partials/navbar.php"); ?>
                    <h1 v-show="showPanel=='Students' || showPanel=='Attendance'|| showPanel=='Assignments'"
                        class="text-muted"> Coming Soon</h1>

                    <div class="container-fluid" v-if="showPanel=='Dashboard'">
                        <div class="d-sm-flex justify-content-between align-items-center mb-4">
                            <h3 class="text-dark rubberBand animated mb-0">Dashboard</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4" data-aos="zoom-in-up" data-aos-once="true">
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
                                                    <td class="text-end pe-5">{{ studentStatus.TotalStudents }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Picked Up for School</td>
                                                    <td class="text-end pe-5">{{ studentStatus.PickedUpForSchool }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Dropped to School</td>
                                                    <td class="text-end pe-5">{{ studentStatus.DroppedToSchool }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Picked Up for Home</td>
                                                    <td class="text-end pe-5">{{ studentStatus.PickedUpForHome }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Dropped to Home</td>
                                                    <td class="text-end pe-5">{{ studentStatus.DroppedToHome }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col text-end px-5">
                                            <button class="btn btn-primary btn-sm" role="button"
                                                @click="showPanel='studentList'" type="button">View all</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" data-aos="zoom-in-up" data-aos-delay="100" data-aos-once="true">
                                <div class="card shadow border-left-warning py-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col d-lg-flex align-items-lg-center">
                                                <h4>Drivers</h4>
                                            </div>
                                            <div class="col-auto"><img class="img-fluid" src="assets/img/taxi.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Total Registered</td>
                                                    <td class="text-end pe-5">{{driversAll.length}}</td>
                                                </tr>
                                                <tr>
                                                    <td>On Duty</td>
                                                    <td class="text-end pe-5">{{driversAll.length}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Pending</td>
                                                    <td class="text-end pe-5">0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col text-end px-5">
                                            <button @click="showPanel='driverList'" class="btn btn-primary btn-sm"
                                                type="button">View all</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" data-aos="zoom-in-up" data-aos-delay="200" data-aos-once="true">
                                <div class="card shadow border-left-success py-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col d-lg-flex align-items-lg-center">
                                                <h4>Payments</h4>
                                            </div>
                                            <div class="col-auto"><img class="img-fluid" src="assets/img/taxi.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Total Paid Amount</td>
                                                    <td class="text-end pe-5">{{ paymentStatus.TotalPaidAmount }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Total Pending Amount</td>
                                                    <td class="text-end pe-5">{{ paymentStatus.TotalPendingAmount }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col text-end px-5">
                                            <button @click="showPanel='Payments'" class="btn btn-primary btn-sm"
                                                type="button">View all</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="showPanel=='Payments'">
                        <?php include("partials/payments.php"); ?>
                    </div>

                    <?php include("partials/drivers.php"); ?>
                    <?php include("partials/students.php"); ?>
                    <?php include("partials/assignStudent.php"); ?>
                </div>

            </div>
            <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/html5-qrcode.min.js"></script>
    <script src="assets/js/qrcode.min.js"></script>

    <script src="assets/js/sweetalert2@11.js"></script>
    <script src="assets/js/project.js"></script>
    <script src="assets/js/theme.js"></script>
    <?php include("partials/linkScript.php"); ?>
    <script type="module">
        import { storageService, navigationService, validations, emailService, tools } from "./assets/code/js/localService.js";
        import { supabaseHelper } from "./services/supabaseService.js";
        import { paymentModes, months } from "./assets/code/data/data.js";
        const app = Vue.createApp({
            data() {
                return {
                    paymentModes, months: months,
                    selectedPaymentMethod: 'Cash',
                    studentStatus: {},
                    driversStatus: {},
                    paymentStatus: {},
                    paymentsAll: [],
                    payments: [],
                    //months: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    years: [2023, 2024, 2025, 2026],
                    showPaymentType: 'ALL',
                    selectedMonth: new Date().getMonth() + 1,
                    selectedYear: new Date().getFullYear(),
                    selectedStudent: {}, selectedDriver: null,
                    selectedFee: null, SelectedVehicleType: null,
                    showPanel: 'Dashboard',
                    paymentAmount: 0, students: [],
                    driversAll: [], studentsAll: [], fares: [],
                    drivers: [],
                    //showPanel: 'Payments',
                    driver: {
                        "user": {
                            "full_name": "name",
                            "phone": "9999999999",
                            "email": "d@gmail.com"
                        },
                        "address": "home address",
                        "license_number": "licence",
                        "vehicle_number": "vehicle",
                        "vehicle_type": "Mini Bus",
                        "is_ac": true,
                        "status": "ACTIVE"
                    },
                    errMessage: null,
                    currentMonthYear: new Date().toLocaleString('en-US', { month: 'long', year: 'numeric' }),
                    paymentKeyword: null, studentKeyword: null
                };
            },
            mounted() {

                supabaseHelper.getStudentAttendanceStatus().then((resp) => { this.studentStatus = resp; });
                supabaseHelper.getMonthlyPaymentStatus().then((resp) => { this.paymentStatus = resp; });
                //supabaseHelper.getStudentAttendanceStatus().then((resp) => { this.studentStatus = resp;});
                supabaseHelper.getPaymentsByMonth().then((resp) => { this.paymentsAll = resp.data; console.log(this.paymentsAll); });
                supabaseHelper.getDrivers().then((resp) => { this.driversAll = resp.data; this.drivers = JSON.parse(JSON.stringify(this.driversAll)); });
                supabaseHelper.getStudents().then((resp) => { this.studentsAll = resp.data; this.students = JSON.parse(JSON.stringify(this.studentsAll)); });
                // this.filterByStatus('ASSIGNED');
                supabaseHelper.getFares().then((resp) => { this.fares = resp.data; console.log(resp.data); });



            },
            methods: {
                setPanel(panelName) { this.showPanel = panelName; },
                setStudent(student) {
                    console.log(student);
                    this.selectedStudent = student;
                    this.paymentAmount = student.monthly_Fee;
                    this.selectedFee = student.monthly_fee ?? null;
                    this.SelectedVehicleType = student.is_ac ?? null;
                },
                selectDriver(driver) {
                    debugger;
                    console.log(driver);
                    this.selectedDriver = this.driver = JSON.parse(JSON.stringify(driver));;
                    this.showPanel = "driverEdit";

                    return;
                },
                selectFare(fee, type) {
                    this.selectedFee = this.selectedStudent.monthly_fee = fee;
                    this.SelectedVehicleType = this.selectedStudent.is_ac = type;
                },
                async updateFare() {
                    if (!this.selectedStudent) return;
                    console.log(this.selectedStudent);
                    var resp = await supabaseHelper.saveStudent(this.selectedStudent);
                    if (resp.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Fare Updated",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        tools.closeModal('setFeeModal');
                    }
                    console.log(resp);
                },
                cancelDriverSave() {
                    this.showPanel = 'driverList'
                    this.selectedDriver = this.errMessage = null;
                    this.driver = { user: {} };
                },

                async saveDriver() {
                    this.errMessage = null;
                    var id = (!!this.selectedDriver) ? this.selectedDriver.id : null;
                    var data = this.driver;
                    var resp = {};
                    console.log(data);
                    // return;
                    if (!id) {
                        this.driver.user.password_hash = this.driver.user.phone;
                        resp = await supabaseHelper.createDriverProfile(data);
                    }
                    else {
                        resp = await supabaseHelper.updateDriverProfile(data);
                    }

                    debugger;
                    if (resp.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Your work has been saved",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {


                        });
                        this.showPanel = 'driverList';
                        supabaseHelper.getDrivers().then((resp) => { this.drivers = this.driversAll = resp.data; console.log(resp.data); });
                        this.driver = this.selectedDriver = null;
                    }
                    else {
                        this.errMessage = resp.message;
                    }


                },
                async makePaid() {


                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, Payment Done!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var data = {
                                "student_id": this.selectedStudent.student_id,
                                "amount": this.paymentAmount,
                                "payment_method": this.selectedPaymentMethod,
                                "payment_month": this.selectedMonth,
                                "payment_year": this.selectedYear
                            }
                            console.log(data);

                            supabaseHelper.makePayment(data).then((resp) => {
                                if (resp.success) {
                                    Swal.fire({
                                        title: "Done!",
                                        text: "Record set to paid.",
                                        icon: "success"
                                    });
                                    tools.closeModal('setPaidModal');
                                    this.showPayments();

                                }
                            });
                        }
                    });
                },
                showPayments() {
                    var params = {};

                    if (!this.selectedMonth || !this.selectedYear) return;
                    params.month = this.selectedMonth;
                    params.year = this.selectedYaer;

                    supabaseHelper.getPaymentsByMonth(params).then((resp) => { this.paymentsAll = resp.data; console.log(resp); });


                },




                async deleteDriver(driver_id) {

                },
                async assignStudent(student) {


                    var resp = await supabaseHelper.assignStudentToDriver(student.id, this.selectedDriver.id);
                    if (resp.success || resp.statusCode == 409) {
                        Swal.fire({
                            icon: "success",
                            title: "Student assigned to Driver",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        supabaseHelper.getStudents().then((resp) => { this.studentsAll = resp.data; this.students = JSON.parse(JSON.stringify(this.studentsAll)); });

                    }
                    console.log(data); return;
                },
                filterByStatus(status) {
                    if (!this.driversAll) return;

                    if (status === 'ASSIGNED') {
                        this.drivers = this.driversAll.filter(item => (item.assignedStudents?.length || 0) > 0);
                    }
                    else if (status === 'UNASSIGNED') {
                        this.drivers = this.driversAll.filter(item => (item.assignedStudents?.length || 0) === 0);
                    }
                    else if (status === 'DELETED') {
                        this.drivers = this.driversAll.filter(item => item.status === 'DELETED');
                    }
                    else {
                        this.drivers = [...this.driversAll];
                    }
                },

                filterStudentsByStatus(status) {
                    if (!this.studentsAll) return;

                    if (status === 'ASSIGNED') {
                        this.students = this.studentsAll.filter(item => (!!item.assignedDriver));
                    }
                    else if (status === 'UNASSIGNED') {
                        this.students = this.studentsAll.filter(item => !item.assignedDriver);
                    }
                    else if (status === 'DELETED') {
                        this.students = this.studentsAll.filter(item => item.status === 'DELETED');
                    }
                    else {
                        this.students = [...this.studentsAll];
                    }
                }
            },
            computed: {
                filteredPayments() {
                    let result = [];

                    // 1. Filter by payment status type
                    switch (this.showPaymentType) {
                        case "PAID":
                            result = this.paymentsAll.filter(
                                payment => payment.paid_status !== null
                            );
                            break;

                        case "PENDING":
                            result = this.paymentsAll.filter(
                                payment => payment.paid_status === null
                            );
                            break;

                        case "ALL":
                        default:
                            result = this.paymentsAll;
                            break;
                    }

                    // 2. Filter by search keyword (if provided)
                    if (this.paymentKeyword) {
                        const search = this.paymentKeyword.toString().trim().toLowerCase();

                        return result.filter((student) => {
                            const fieldsToSearch = [
                                student.full_name,
                                student.father_name,
                                student.phone,
                                student.monthly_Fee,
                            ];

                            return fieldsToSearch.some((field) => {
                                if (field === null || field === undefined) return false;
                                return field.toString().toLowerCase().includes(search);
                            });
                        });
                    }

                    // Return the status-filtered result if no search keyword is present
                    return result;
                },
                filteredStudents() {
                    if (this.studentKeyword) {
                        const search = this.studentKeyword.toString().trim().toLowerCase();

                        return this.studentsAll.filter((student) => {
                            const fieldsToSearch = [
                                student.user.full_name,
                                student.user.email,
                                student.user.phone,
                                student.monthly_Fee,
                            ];

                            return fieldsToSearch.some((field) => {
                                if (field === null || field === undefined) return false;
                                return field.toString().toLowerCase().includes(search);
                            });
                        });
                    }
                    else {
                        return this.studentsAll;
                    }
                }
            }
        });

        app.component('drivers-component', window.driversComponent);

        app.mount("#app");
    </script>
</body>

</html>
