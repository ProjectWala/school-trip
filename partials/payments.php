<div class="container-fluid" v-cloak data-aos="zoom-in-up" data-aos-once="true">
    <div class="row">
        <div class="col">
            <h3 class="text-dark mb-4">Payments {{months[selectedMonth-1].fullMonth}} {{selectedYear}}</h3>
        </div>
        <div class="col-2">
            <div class="input-group">
                <select class="form-select" v-model="selectedMonth">
                    
                    <option v-for="(month, index) in months" :key="index" :value="month.month">
                        {{ month.shortMonth }}
                    </option>
                </select>
                <select class="form-select" v-model="selectedYear">
                    <option v-for="year in years" :key="year" :value="year">
                        {{ year }}
                    </option>
                </select>
                <button class="btn btn-primary" type="button" @click="showPayments()">Go</button>
            </div>
        </div>
        <div class="col-auto"><button class="btn btn-primary" type="button"><i class="fas fa-filter"></i></button></div>
    </div>
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <button @click="showPanel='Dashboard'" class="btn btn-primary btn-sm" type="button"><i class="fas fa-arrow-left"></i> Back to Dashboard</button>
                </div>
                <div class="col text-end">
                    <div class="btn-group btn-group-sm" role="group">
                        <button @click="showPaymentType='ALL'" class="btn btn-primary px-4" type="button">All</button>
                        <button @click="showPaymentType='PAID'" class="btn btn-success link-light px-3" type="button">Paid</button>
                        <button @click="showPaymentType='PENDING'" class="btn btn-warning link-light" type="button">Pending</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-nowrap">
                    <input v-model="paymentKeyword" class="form-control form-control-sm" type="search"aria-controls="dataTable" placeholder="Search" />
                    </div>
                <div class="col-md-6"></div>
            </div>
            <div id="dataTable" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                <table id="dataTable" class="table table-striped my-0">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Mobile</th>
                            <th>Monthly Fee</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="student in filteredPayments" :key="student.student_id">
                            <td>
                                {{ student.full_name || 'Not Set' }}
                            </td>
                            <td>{{ student.phone || 'Not Set' }}</td>
                            <td>₹{{ student.monthly_Fee ? student.monthly_Fee.toLocaleString() : '0' }}</td>
                            <td>
                                <span v-if="student.paid_status" class="badge bg-success">
                                    Paid on {{ new Date(student.paid_status).toLocaleDateString() }}
                                </span>
                                <span v-else class="badge bg-warning text-light">
                                    Pending
                                </span>
                            </td>
                            <td >
                                <a v-if="!student.paid_status" class="btn btn-primary btn-sm" @click="setStudent(student)" role="button" href="#setPaidModal" data-bs-toggle="modal">Set Paid</a>
                            </td>
                        </tr>

                        <tr v-if="!paymentsAll || paymentsAll.length === 0">
                            <td colspan="4" class="text-center py-3 text-muted">
                                No payment records found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="setPaidModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Set paid</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12">
                            <p  class="text-danger fw-bold">You are going to mark Paid for {{months[selectedMonth-1].fullMonth}} {{selectedYear}}</p>
                            <p>Make sure you have taken payment</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Payment Mode</label>
                            <select class="form-control" v-model="selectedPaymentMethod">
                                <option v-for="method in paymentModes" :value="method.code">{{method.name}}</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Amount</label>
                            <input v-model="paymentAmount" class="form-control" type="text" placeholder="Enter Payment Amount" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                <button @click="makePaid()" class="btn btn-primary" type="button">Done</button></div>
        </div>
    </div>
</div>