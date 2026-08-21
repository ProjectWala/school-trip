<div class="container-fluid" v-if="showPanel=='driverList'" data-aos="zoom-in-up" data-aos-once="true">
    <div class="row">
        <div class="col">
            <h3 class="text-dark mb-4">Drivers</h3>
        </div>
        <div class="col-auto">
            <div class="input-group"><select class="form-select">
                    <optgroup label="This is a group">
                        <option value="12" selected>This is item 1</option>
                        <option value="13">This is item 2</option>
                        <option value="14">This is item 3</option>
                    </optgroup>
                </select><select class="form-select">
                    <optgroup label="This is a group">
                        <option value="12" selected>This is item 1</option>
                        <option value="13">This is item 2</option>
                        <option value="14">This is item 3</option>
                    </optgroup>
                </select><button class="btn btn-primary" type="button">Go</button></div>
        </div>
        <div class="col-auto">
            <button @click="showPanel='driverEdit'" class="btn btn-primary" type="button"><i
                    class="fas fa-plus"></i></button>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="row">
                <div class="col"><button @click="showPanel='Dashboard'" class="btn btn-primary btn-sm" type="button"><i
                            class="fas fa-arrow-left"></i> Back to Dashboard</button></div>
                <div class="col text-end">
                    <div class="btn-group btn-group-sm" role="group">
                        <button @click="filterByStatus('ALL')" class="btn btn-primary px-4" type="button">All</button>
                        <button @click="filterByStatus('ASSIGNED')" class="btn btn-success link-light px-3" type="button">Assigned</button>
                        <button @click="filterByStatus('UNASSIGNED')" class="btn btn-warning link-light" type="button">UnAssigned</button>
                        <button @click="filterByStatus('DELETED')" class="btn btn-danger link-light" type="button">Deleted</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-nowrap"><input class="form-control form-control-sm" type="search"
                        aria-controls="dataTable" placeholder="Search" /></div>
                <div class="col-md-6"></div>
            </div>
            {{drivers.length}}
            <div id="dataTable" class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                <table id="dataTable" class="table my-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>License No.</th>
                            <th>Vehicle</th>
                            <th>Type</th>
                            <th>Ac / Non Ac</th>
                            <th>Assigned Students</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="driver in drivers">
                            <td>{{driver.user.full_name}}</td>
                            <td>{{driver.user.phone}}</td>
                            <td>{{driver.user.email}}</td>
                            <td>{{driver.license_number}}</td>
                            <td>{{driver.vehicle_number}}</td>
                            <td>{{driver.vehicle_type}}</td>
                            <td>{{driver.is_ac}}</td>
                            <td>{{ driver.assignedStudents?.length || 0 }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button @click="selectDriver(driver)" class="btn btn-info link-light"
                                        type="button"><i class="fas fa-edit"></i></button>
                                    <button @click="deleteDriver(driver)" class="btn btn-danger" type="button"><i
                                            class="fas fa-times"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10
                        of 27</p>
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


<div class="container-fluid" v-if="showPanel=='driverEdit'">
    <div class="card shadow">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col">
                    <h4>Edit Driver</h4>
                </div>
                <div class="col-auto">
                    <img src="assets/img/icons/add_male_user.png">
                </div>
            </div>

            <form @submit.prevent="saveDriver">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Driver Name</label>
                        <input class="form-control" v-model="driver.user.full_name" type="text">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input maxlength="10" class="form-control" v-model="driver.user.phone" type="text">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" v-model="driver.user.email" type="email">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <input class="form-control" v-model="driver.address" type="text">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">License Number</label>
                        <input class="form-control" v-model="driver.license_number" type="text">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle Number</label>
                        <input class="form-control" v-model="driver.vehicle_number" type="text">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle Type</label>

                        <select class="form-select" v-model="driver.vehicle_type">
                            <option value="School Bus">School Bus</option>
                            <option value="Mini Bus">Mini Bus</option>
                            <option value="Van">Van</option>
                            <option value="Auto">Auto</option>
                            <option value="Car">Car</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">AC / Non AC</label>

                        <select class="form-select" v-model="driver.is_ac">
                            <option :value="true">Yes</option>
                            <option :value="false">No</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>

                        <select class="form-select" v-model="driver.status">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                    </div>


                </div>
                <div class="row" v-if="errMessage">
                    <div class="col">
                        <div class="alert alert-danger bounce animated" role="alert"><span><strong>Error : </strong> {{errMessage}}</span></div>
                    </div>
                </div>
                <div class="text-end">

                    <button class="btn btn-secondary me-2" type="button" @click="cancelDriverSave()">Cancel</button>

                    <button class="btn btn-success text-white" @click="saveDriver()" type="button">Save</button>

                </div>

            </form>

        </div>
    </div>
</div>