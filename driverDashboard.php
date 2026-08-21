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

<body id="page-top" style="font-size: 12px;">
    <div id="wrapper" v-cloak>

        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include("partials/navbar.php"); ?>
                <div class="container">
                    <div
                        class="col-md-8 col-xl-6 offset-md-2 offset-xl-3 d-flex justify-content-center align-items-center">
                        <img class="img-fluid me-2" src="assets/img/avatars/male_users.png" style="width: 32px;" />
                        <h6 class="text-dark flex-fill mb-0"><strong>Attendance</strong></h6>
                        <button class="btn btn-success btn-sm link-light"
                            :class="route=='TO_SCHOOL'?'btn-success':'btn-info'" type="button" @click="changeRoute()">
                            <div v-show="route=='TO_SCHOOL'">Going School <i class="fas fa-arrow-right"></i></div>
                            <div v-show="route=='TO_HOME'"><i class="fas fa-arrow-left"></i> Going Home</div>
                        </button>
                    </div>
                </div>
                <hr>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <ul class="list-group shadow-sm">
                                <li v-for="student in studentsWithAttendance"
                                    :class="student.attendance?.status=='PICKEDUP'?'list-group-item-warning':student.attendance?.status=='DROPPED'?'list-group-item-success':''"
                                    class="list-group-item" role="button" data-bs-toggle="modal"
                                    data-bs-target="#actionModal" @click="onSelectStudent(student)">
                                    <img class="img-fluid me-3" src="assets/img/icons/male_user.png"
                                        style="width: 32px;">
                                    <span>{{student.student.full_name}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="float z-1" @click="startScanning()" data-bs-target="#qrModal" data-bs-toggle="modal">
            <i class="fa fa-qrcode my-float" style="color: rgb(255,255,255)"></i>
        </a>

        <div class="modal fade" role="dialog" tabindex="-1" id="actionModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{selectedStudent?.student?.full_name}}</h4><button class="btn-close"
                            type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col text-center" v-show="!showScanner">
                                <img class="border rounded shadow-sm mb-3" src="assets/img/male_user128.png">
                            </div>

                        </div>
                        <div class="col text-center">
                            <button class="btn btn-primary mx-1" type="button">Call&nbsp;<i
                                    class="fas fa-phone-alt"></i></button>
                            <button @click="markAttendance('MANUAL')"
                                v-show="selectedStudent?.attendance?.status!='DROPPED'"
                                class="btn btn-success link-light mx-1" type="button">Mark&nbsp;<i
                                    class="fa fa-check"></i></button>
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center"><button class="btn btn-secondary flex-fill"
                            type="button" data-bs-dismiss="modal">Close</button></div>
                </div>
            </div>
        </div>


        <div class="modal fade" role="dialog" tabindex="-1" id="qrModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Scan QR</h4><button class="btn-close" type="button" aria-label="Close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div id="reader"></div>

                                <div id="result" class="mt-2">
                                    {{qrMessage}}
                                </div>

                                <div class="text-center mt-2">
                                    <button @click="stopScanning" class="btn btn-danger btn-sm">
                                        Stop Scanner
                                    </button>
                                </div>
                                <h5>{{qrCaptureValue}}</h5>
                            </div>


                        </div>

                    </div>
                    <div class="modal-footer d-flex align-items-center"><button class="btn btn-secondary flex-fill"
                            type="button" data-bs-dismiss="modal">Close</button></div>
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
                    if (this.route == 'TO_SCHOOL') {
                        Swal.fire({
                            title: "Route Changed !",
                            text: "Route set to Home!",
                            icon: "success"
                        });
                        this.route = 'TO_HOME';
                    }
                    else {
                        Swal.fire({
                            title: "Route Changed !",
                            text: "Route set to School!",
                            icon: "success"
                        });
                        this.route = 'TO_SCHOOL';
                    }
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
                    tools.closeModel("actionModal");
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
                        tools.closeModel("qrModal");

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
