<div class="container-fluid" v-if="showPanel=='Assignment'">
    <div class="row">
        <div class="col">
            <h3 class="text-dark mb-4" data-aos="zoom-in-right">Assign Students to Driver</h3>
        </div>
        <div class="col-auto"><button class="btn btn-primary" type="button"><i class="fas fa-filter"></i></button></div>
    </div>
    <div class="card shadow mb-3" data-aos="zoom-in-up" data-aos-once="true">
        <div class="card-body">
            <div class="row">
                <div class="col text-nowrap">
                    <label class="form-label">Select Driver - {{selectedDriver?.user?.full_name}}</label>
                    <select class="form-control" v-model="selectedDriver">

                        <option v-for="driver in drivers" :value="driver">{{driver.user.full_name}}</option>

                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow" data-aos="zoom-in-up" data-aos-delay="100" data-aos-once="true">
        <div class="card-header py-3">
            <h5>Students</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-nowrap"><input type="search" class="form-control form-control-sm"
                        aria-controls="dataTable" placeholder="Search"></div>
                <div class="col-md-6 text-end">
                    <div class="btn-group btn-group-sm" role="group">
                        <button @click="filterStudentsByStatus('ALL')" class="btn btn-primary px-4" type="button">All</button>
                        <button @click="filterStudentsByStatus('ASSIGNED')" class="btn btn-success link-light px-3" type="button">Assigned</button>
                        <button @click="filterStudentsByStatus('UNASSIGNED')" class="btn btn-warning link-light" type="button">UnAssigned</button>
                        <button @click="filterStudentsByStatus('DELETED')" class="btn btn-danger link-light" type="button">Deleted</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Fee</th>
                            <th>Driver</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="student in students" :key="student.id">
                            <td>{{ student.user.full_name || 'N/A' }}</td>
                            <td>{{ student.user.phone || 'N/A' }}</td>
                            <td>{{ student.user.email || 'N/A' }}</td>
                            <td>₹{{ student.monthly_fee }}</td>                            
                            <td>{{ student.assignedDriver?.user?.full_name || 'None' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button :disabled="selectedDriver==null" class="btn btn-primary btn-sm" role="button" @click="assignStudent(student)"
                                         >Assign</a>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!students || students.length === 0">
                            <td colspan="6" class="text-center py-3">No student records found.</td>
                        </tr>

                        </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <p id="dataTable_info-1" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of
                        27</p>
                </div>
                <div class="col-md-6">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="#"><span
                                        aria-hidden="true">«</span></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span
                                        aria-hidden="true">»</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>