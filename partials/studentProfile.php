<section id="studentProfile">
    <div class="container-fluid">
        <div class="row" v-if="panel=='profileDetails'">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow mb-4" data-aos="zoom-in-down" data-aos-once="true">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;"><i class="fas fa-user"></i></th>
                                        <th class="text-start">{{ student.user.full_name }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fas fa-info-circle"></i></td>
                                        <td>{{ student.class_name ?? 'Not Set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-user-tie"></i></td>
                                        <td>{{ student.emergency_contact_name ?? 'Not Set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-phone-alt"></i></td>
                                        <td>{{ student.user.phone ?? 'Not Set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-envelope"></i></td>
                                        <td>{{ student.user.email ?? 'Not Set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-home"></i></td>
                                        <td>{{ student.home_address ?? 'Not Set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-map-marker-alt"></i><i class="fas fa-arrow-right ms-1"></i>
                                        </td>
                                        <td>{{ student.pickup_location ?? 'Not Set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-arrow-right"></i><i class="fas fa-map-marker-alt ms-1"></i>
                                        </td>
                                        <td>{{ student.drop_location ?? 'Not Set' }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="text-end">
                                            <button @click="panel='profileEdit'" class="btn btn-primary btn-sm"
                                                type="button">Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="panel=='profileEdit'">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow mb-4" data-aos="fade">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="full_name"><strong>Full Name</strong></label>
                                        <input v-model="student.user.full_name" class="form-control" type="text"
                                            id="full_name" placeholder="Student Name" name="full_name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="class_name"><strong>Class</strong></label>
                                        <input v-model="student.class_name" class="form-control" type="text"
                                            id="class_name" placeholder="5A" name="class_name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="email"><strong>Email Address</strong></label>
                                        <input v-model="student.user.email" class="form-control" type="email" id="email"
                                            placeholder="user@example.com" name="email">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="phone"><strong>Mobile</strong></label>
                                        <input v-model="student.user.phone" class="form-control" type="text" id="phone"
                                            placeholder="9999999999" name="phone">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="home_address"><strong>Address</strong></label>
                                        <textarea v-model="student.home_address" class="form-control"
                                            id="home_address"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="pickup_location"><strong>Pickup
                                                Location</strong></label>
                                        <textarea v-model="student.pickup_location" class="form-control"
                                            id="pickup_location"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="drop_location"><strong>Drop
                                                Location</strong></label>
                                        <textarea v-model="student.drop_location" class="form-control"
                                            id="drop_location"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div v-if="errorMessage" class="alert alert-danger bounce animated" role="alert">
                                    <span>{{errorMessage}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button @click="panel='profileDetails'" class="btn btn-primary"
                                            type="button">Cancel</button>
                                        <button @click="saveStudentProfile()" class="btn btn-success link-light"
                                            type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>