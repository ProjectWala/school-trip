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
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/Features-Image-icons.css">
    <link rel="stylesheet" href="assets/css/Floating-Button.css">
    <link rel="stylesheet" href="assets/css/untitled.css?v=2.0">
</head>

<body id="page-top" class="bg-light" style="font-family: 'Nunito', sans-serif;">
    <div id="wrapper" v-cloak>

        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include("partials/navbar.php"); ?>
                <div class="container mt-4 mb-3">
                    <div class="col-md-8 col-xl-6 offset-md-2 offset-xl-3">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex align-items-center">
                                    
                                    <h5 class="text-dark fw-bold mb-0">Route</h5>
                                </div>
                                <button class="btn rounded-pill px-4 py-2 fw-bold shadow-sm"
                                    :class="route=='TO_SCHOOL' ? 'btn-primary' : 'btn-info text-white'" 
                                    type="button" @click="changeRoute()" style="transition: all 0.3s ease;">
                                    <div v-show="route=='TO_SCHOOL'"><i class="fas fa-school me-2"></i>Going To School</div>
                                    <div v-show="route=='TO_HOME'"><i class="fas fa-home me-2"></i>Going To Home</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid pb-5">
                    <div class="row">
                        <div class="col-md-8 col-xl-6 offset-md-2 offset-xl-3">
                            <div class="d-flex flex-column gap-3 px-2">
                                <div v-for="student in studentsWithAttendance" 
                                    :key="student.student_id"
                                    class="card border-0 shadow-sm rounded-4 overflow-hidden" 
                                    :class="student.attendance?.status=='PICKEDUP' ? 'bg-warning border-start border-5 border-warning bg-opacity-10' : (student.attendance?.status=='DROPPED' ? 'bg-success border-start border-5 border-success bg-opacity-10' : '')"
                                    role="button" data-bs-toggle="modal" data-bs-target="#actionModal" 
                                    @click="onSelectStudent(student)">
                                    
                                    <div class="card-body d-flex align-items-center p-3">
                                        <div class="position-relative">
                                            <img class="img-fluid rounded-circle shadow-sm bg-white p-1" src="assets/img/icons/male_user.png" style="width: 55px; height: 55px; object-fit: contain;">
                                            <span v-if="student.attendance?.status=='PICKEDUP'" class="position-absolute bottom-0 start-50 translate-middle-x badge rounded-pill bg-warning text-dark border border-white" style="font-size: 0.55rem; transform: translateY(30%) translateX(-50%)!important;">PICKED</span>
                                            <span v-if="student.attendance?.status=='DROPPED'" class="position-absolute bottom-0 start-50 translate-middle-x badge rounded-pill bg-success border border-white" style="font-size: 0.55rem; transform: translateY(30%) translateX(-50%)!important;">DROPPED</span>
                                        </div>
                                        
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1 fw-bold text-dark" style="font-size: 1.1rem;">{{student.student.full_name}}</h6>
                                            <small class="text-muted"><i class="fas fa-hand-pointer me-1 text-primary opacity-75"></i>Tap to update</small>
                                        </div>
                                        
                                        <div class="ms-auto text-muted opacity-50">
                                            <i class="fas fa-chevron-right fa-lg"></i>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="studentsWithAttendance.length === 0" class="text-center py-5">
                                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-3" style="width: 80px; height: 80px;">
                                        <i class="fas fa-users-slash fa-2x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted fw-bold">No Students Assigned</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="float z-1 bg-primary text-white border-0 shadow-lg d-flex justify-content-center align-items-center" @click="startScanning()" data-bs-target="#qrModal" data-bs-toggle="modal" style="width: 60px; height: 60px; border-radius: 50%; font-size: 24px;">
            <i class="fa fa-qrcode"></i>
        </a>

        <div class="modal fade" role="dialog" tabindex="-1" id="actionModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header bg-primary bg-opacity-10 border-0 pt-4 pb-3">
                        <h5 class="modal-title fw-bold text-dark w-100 text-center">{{selectedStudent?.student?.full_name}}</h5>
                        <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pb-4">
                        <div class="row">
                            <div class="col text-center" v-show="!showScanner">
                                <div class="d-inline-block position-relative mb-4 mt-2">
                                    <img class="rounded-circle shadow-sm border border-3 border-white bg-light p-2" src="assets/img/male_user128.png" style="width: 100px; height: 100px;">
                                </div>
                            </div>
                        </div>
                        <div class="col text-center d-flex flex-column gap-3 px-4">
                            <button class="btn btn-outline-primary rounded-pill py-3 fw-bold fs-6 shadow-sm d-flex align-items-center justify-content-center" type="button">
                                <i class="fas fa-phone-alt me-2"></i> Call Parent
                            </button>
                            <button @click="markAttendance('MANUAL')"
                                v-show="selectedStudent?.attendance?.status!='DROPPED'"
                                class="btn btn-success text-white rounded-pill py-3 fw-bold fs-6 shadow d-flex align-items-center justify-content-center" type="button">
                                <i class="fas fa-check-circle me-2"></i> Mark Attendance
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" role="dialog" tabindex="-1" id="qrModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header bg-dark text-white border-0 pt-4 pb-3">
                        <h5 class="modal-title fw-bold w-100 text-center"><i class="fas fa-qrcode me-2"></i> Scan QR Code</h5>
                        <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-3 me-3" type="button" aria-label="Close" data-bs-dismiss="modal" @click="stopScanning"></button>
                    </div>
                    <div class="modal-body p-4 bg-light">
                        <div class="row">
                            <div class="col">
                                <div id="reader" class="rounded-3 overflow-hidden shadow-sm border border-2 border-primary mb-3 bg-white"></div>

                                <div id="result" class="alert alert-info text-center fw-bold shadow-sm rounded-pill py-2 mb-4">
                                    {{qrMessage}}
                                </div>

                                <div class="text-center">
                                    <button @click="stopScanning" class="btn btn-danger rounded-pill px-5 py-3 fw-bold shadow d-inline-flex align-items-center justify-content-center w-100">
                                        <i class="fas fa-times-circle me-2"></i> Stop Scanner
                                    </button>
                                </div>
                                <div class="text-center mt-3">
                                    <span class="badge bg-secondary text-white rounded-pill px-3 py-2 fw-bold opacity-75">{{qrCaptureValue}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-5"></div>
    <?php include("partials/footer.php"); ?>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/html5-qrcode.min.js"></script>
    <script src="assets/js/project.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <?php include("partials/linkScript.php"); ?>
    <script type="module">
        import { storageService, navigationService, validations, tools } from "./assets/code/js/localService.js";
        import { supabaseHelper } from "./services/supabaseService.js";

        const app = Vue.createApp({
            async mounted() {

                this.user = await storageService.get('user');
                //debugger;
                supabaseHelper.getDriverStudentsWithAttendance(this.user.id, this.route).then((resp) => {
                    this.studentsWithAttendance = resp.data;
                });
                console.log(this.studentsWithAttendance);
            },
            data() {
                return {
                    user: {},
                    studentsWithAttendance: [],
                    selectedStudent: null,
                    showScanner: false,
                    qrScanner: null,
                    isScanning: false,
                    qrCaptureValue: 'Scanning . . .',
                    qrMessage: 'Waiting for QR...',
                    showOnlyScanner: false,
                    route: "TO_SCHOOL",
                    QRType: {
                        URL: "URL",
                        GUID: "GUID",
                        MOBILE: "MOBILE",
                        ANY: "ANY"
                    }
                };
            },

            methods: {
                async onSelectStudent(student) {
                    this.selectedStudent = student;

                },
                async changeRoute() {
                var msg = "Route set to Home!";
                    if (this.route == 'TO_SCHOOL') {                        
                        this.route = 'TO_HOME';
                        msg = "Route set to Home!";
                    }
                    else {
                        msg = "Route set to School!";
                        this.route = 'TO_SCHOOL';
                    }
                    Swal.fire({
                            title: "Route Changed !",
                            text: msg,
                            icon: "success",
                            timer: 1000
                        });
                    supabaseHelper.getDriverStudentsWithAttendance(this.user.id, this.route).then((resp) => {
                        this.studentsWithAttendance = resp.data;
                    });

                },
                async markAttendance(mode) {
                    debugger;
                    var data = { route: this.route };

                    if (!this.selectedStudent.attendance) {

                        data.student_id = this.selectedStudent.student_id;
                        data.driver_id = this.user.id;
                    } else {

                        data.attendance_id = this.selectedStudent.attendance.id;
                    }
                    data.takenBy = mode;
                    if (mode != 'QR') {
                        //data.attendance_id = this.selectedStudent.attendance.id;
                        const result = await Swal.fire({
                            title: "Are you sure marking attendance manually?",
                            text: "Please confirm that student dont have ID card to scan!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, I confirm it!"
                        });
                        if (!result.isConfirmed) { return; }
                    }
                    else {
                        data.student_id = this.qrCaptureValue;
                    }
                    await supabaseHelper.markAttendance(data).then((resp) => {

                        if (resp.success) {

                            Swal.fire({
                                title: `Attendance marked for ${this.selectedStudent.student.full_name}`,
                                icon: "success"
                            });
                        } else {
                            Swal.fire({
                                title: "oops!",
                                text: resp.message,
                                icon: "warning"
                            });

                        }

                    });
                    tools.closeModal("actionModal");
                    supabaseHelper.getDriverStudentsWithAttendance(this.user.id, this.route).then((resp) => {
                        this.studentsWithAttendance = resp.data;
                    });
                    debugger;

                },
                async startScanning() {

                    if (this.isScanning) { this.stopScanning(); }
                    this.showScanner = true;
                    await this.read(this.QRType.GUID);
                },
                async read(type = this.QRType.ANY) {

                    try {

                        this.qrScanner = new Html5Qrcode("reader");

                        await this.qrScanner.start(
                            {
                                facingMode: "environment"
                            },
                            {
                                fps: 10,

                                qrbox: (width, height) => ({
                                    width: width,
                                    height: height
                                })
                            },

                            async (decodedText) => {

                                let valid = false;

                                switch (type) {

                                    case this.QRType.URL:
                                        valid = validations.isUrl(decodedText);
                                        break;

                                    case this.QRType.GUID:
                                        valid = validations.isGuid(decodedText);
                                        break;

                                    case this.QRType.MOBILE:
                                        valid = validations.isMobile(decodedText);
                                        break;

                                    default:
                                        valid = true;
                                        break;
                                }

                                if (valid) {

                                    document.getElementById("result").innerHTML =
                                        "Valid QR: " + decodedText;

                                    await this.stopScanning();

                                    this.onQRSuccess(decodedText, type);
                                }
                                else {

                                    document.getElementById("result").innerHTML =
                                        "Invalid QR. Continue scanning...";
                                }
                            },

                            () => {
                                // ignore scan failures
                            }
                        );

                        this.isScanning = true;

                    } catch (error) {

                        console.error(error);

                        document.getElementById("result").innerHTML =
                            "Camera error";
                    }
                },
                async onQRSuccess(value, type) {
                    this.qrCaptureValue = value;
                    this.selectedStudent = this.studentsWithAttendance.find(item => item.student_id === value);

                    console.log("TYPE:", type);
                    console.log("VALUE:", value);

                    if (type === this.QRType.GUID) {

                        await this.markAttendance("QR");

                        // Close modal
                        tools.closeModal("qrModal");

                    }
                },
                async stopScanning() {

                    if (!this.qrScanner || !this.isScanning)
                        return;

                    try {
                        await this.qrScanner.stop();
                        await this.qrScanner.clear();

                    } catch (e) { console.warn(e); }

                    try {

                        const video = document.querySelector("#reader video");

                        if (video?.srcObject) {

                            video.srcObject
                                .getTracks()
                                .forEach(track => track.stop());

                            video.srcObject = null;
                        }

                    } catch (e) {
                        console.warn(e);
                    }

                    this.qrScanner = null;
                    this.isScanning = false;
                    this.showScanner = false;
                },
            }

        });

        app.mount("#wrapper");


    </script>

</body>

</html>
