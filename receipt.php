<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Payment Receipt</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900&display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        .receipt-container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .receipt-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-img {
            max-height: 80px;
        }
        .receipt-title {
            font-size: 28px;
            font-weight: 800;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        .info-value {
            font-weight: 700;
            color: #2c3e50;
            font-size: 1.1rem;
        }
        .table th {
            text-transform: uppercase;
            font-size: 0.85rem;
            color: #6c757d;
            border-top: none;
        }
        .table td {
            vertical-align: middle;
            font-weight: 600;
        }
        .total-row td {
            font-size: 1.25rem;
            font-weight: 800;
            color: #2c3e50;
            border-top: 2px solid #2c3e50 !important;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .receipt-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body id="receipt-app">
    <div class="container" v-cloak>
        <div class="d-flex justify-content-end mb-3 mt-4 no-print">
            <button class="btn btn-outline-secondary me-2" @click="goBack()">
                <i class="fas fa-arrow-left me-1"></i> Back
            </button>
            <button class="btn btn-primary" @click="downloadPDF()">
                <i class="fas fa-download me-1"></i> Download PDF
            </button>
        </div>

        <div class="receipt-container" id="receipt-content">
            <div class="receipt-header d-flex justify-content-between align-items-center">
                <div>
                    <img src="assets/img/logo.jpg" alt="School Trip Logo" class="logo-img mb-2">
                    <h5 class="fw-bold mb-0 text-primary">School Trip Service</h5>
                    <p class="text-muted mb-0 small">Safe & Reliable Student Transport</p>
                </div>
                <div class="text-end">
                    <h1 class="receipt-title">RECEIPT</h1>
                    <p class="mb-0 text-muted">Date: {{ currentDate }}</p>
                    <p class="mb-0 text-muted fw-bold text-success">Status: PAID</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm-6">
                    <div class="mb-4">
                        <div class="info-label mb-1">Billed To</div>
                        <div class="info-value">{{ student.full_name }}</div>
                        <div class="text-muted small">{{ student.phone }}</div>
                        <div class="text-muted small">{{ student.email }}</div>
                    </div>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <div class="mb-4">
                        <div class="info-label mb-1">Receipt Details</div>
                        <div class="mb-1"><span class="text-muted">Month:</span> <span class="info-value ms-2">{{ monthYear }}</span></div>
                        <div><span class="text-muted">Paid On:</span> <span class="info-value ms-2">{{ paidAt }}</span></div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table mb-5">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-center">Month</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">Monthly Transport Fee</div>
                                <div class="small text-muted">School pick-up and drop service</div>
                            </td>
                            <td class="text-center align-middle">{{ monthYear }}</td>
                            <td class="text-end align-middle">₹{{ student.monthly_fee }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="2" class="text-end py-3">Total Amount Paid</td>
                            <td class="text-end py-3 text-success">₹{{ student.monthly_fee }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-5 pt-4 border-top">
                <p class="text-muted mb-1">Thank you for using our transport service!</p>
                <p class="small text-muted">This is an automatically generated receipt and does not require a physical signature.</p>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/vue.global.prod.js"></script>
    <!-- Add html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script type="module">
        import { storageService } from "./assets/code/js/localService.js";

        const app = Vue.createApp({
            data() {
                return {
                    student: {},
                    monthYear: '',
                    paidAt: '',
                    currentDate: new Date().toLocaleDateString()
                }
            },
            async mounted() {
                this.student = await storageService.get('user');
                if (!this.student) {
                    window.location.href = 'login.php';
                    return;
                }

                // Get URL parameters
                const urlParams = new URLSearchParams(window.location.search);
                this.monthYear = urlParams.get('month') || 'N/A';
                this.paidAt = urlParams.get('paid_at') || 'N/A';
            },
            methods: {
                goBack() {
                    if (window.history.length > 1 && document.referrer) {
                        window.history.back();
                    } else {
                        window.location.href = 'studentDashboard.php#Payments';
                    }
                },
                downloadPDF() {
                    const element = document.getElementById('receipt-content');
                    const opt = {
                        margin:       0.5,
                        filename:     `receipt_${this.student.full_name}_${this.monthYear}.pdf`.replace(/\s+/g, '_'),
                        image:        { type: 'jpeg', quality: 0.98 },
                        html2canvas:  { scale: 2 },
                        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                    };
                    
                    html2pdf().set(opt).from(element).save();
                }
            }
        });
        app.mount('#receipt-app');
    </script>
</body>
</html>
