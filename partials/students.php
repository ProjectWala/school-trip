<div class="container-fluid" v-if="showPanel=='studentList'" v-cloak data-aos="zoom-in-up" data-aos-once="true">
    <div class="row">
        <div class="col">
            <h3 class="text-dark mb-4">Students List</h3>
        </div>
        <div class="col-auto">
            <div class="input-group">
                <select class="form-select" v-model="selectedGroup1">
                    <optgroup label="This is a group">
                        <option value="12" selected>This is item 1</option>
                        <option value="13">This is item 2</option>
                        <option value="14">This is item 3</option>
                    </optgroup>
                </select>
                <select class="form-select" v-model="selectedGroup2">
                    <optgroup label="This is a group">
                        <option value="12" selected>This is item 1</option>
                        <option value="13">This is item 2</option>
                        <option value="14">This is item 3</option>
                    </optgroup>
                </select>
                <button class="btn btn-primary" type="button" @click="handleGo">Go</button>
            </div>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="button" @click="toggleFilter">
                <i class="fas fa-filter"></i>
            </button>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-nowrap">
                    <input class="form-control form-control-sm" type="search" aria-controls="dataTable"
                       v-model="studentKeyword"  placeholder="Search" />
                </div>
                <div class="col-md-6"></div>
            </div>

            <div id="dataTable" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>School / Class</th>
                            <th>Driver</th>
                            <th>Monthly Fee</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="student in filteredStudents" :key="student.id">
                            <td>{{ student.user.full_name || 'N/A' }}</td>
                            <td>{{ student.user.phone || 'N/A' }}</td>
                            <td>{{ student.user.email || 'N/A' }}</td>
                            <td>
                                <span v-if="student.school_name">
                                    {{ student.school_name }} ({{ student.class_name }})
                                </span>
                                <span v-else class="text-muted">Not Assigned</span>
                            </td>
                            <td>{{ student.assignedDriver?.full_name || 'None' }}</td>
                            <td>₹{{ student.monthly_fee }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-primary btn-sm" role="button" @click="setStudent(student)" href="#setFeeModal"
                                        data-bs-toggle="modal">Set Fee</a>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!students || students.length === 0">
                            <td colspan="6" class="text-center py-3">No student records found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-6 align-self-center">
                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ students.length }} entries
                    </p>
                </div>
                <div class="col-md-6">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" aria-label="Previous" href="#"><span
                                        aria-hidden="true">«</span></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item">
                                <a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="setFeeModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Select Fee</h4><button class="btn-close" type="button" aria-label="Close"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Distance</th>
                                <th class="text-center">Ac</th>
                                <th class="text-center">Non Ac</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="fare in fares" :key="fare.id">
                                <td>Up to {{ fare.max_distance_km }} KM</td>

                                <td @click="selectFare(fare.ac_vehicle, true,fare.id)" class="text-center"
                                    :class="{ 'table-success': selectedFee === fare.ac_vehicle && SelectedVehicleType === true }"
                                    style="cursor:pointer">
                                    {{ fare.ac_vehicle }}
                                </td>

                                <td @click="selectFare(fare.non_ac_vehicle, false)" class="text-center"
                                    :class="{ 'table-success': selectedFee === fare.non_ac_vehicle && SelectedVehicleType === false }"
                                    style="cursor:pointer">
                                    {{ fare.non_ac_vehicle }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-light" type="button"
                    data-bs-dismiss="modal">Close</button>
                    <button @click="updateFare()" class="btn btn-primary" type="button">Save</button>
            </div>
        </div>
    </div>
</div>