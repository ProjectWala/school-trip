<section id="studentProfile">
    <div class="container-fluid">
        <div class="row" v-if="panel=='profileDetails'">
            <div class="col-md-8 col-xl-6 offset-md-2 offset-xl-3 pb-5">
                <div class="card shadow-sm border-0 rounded-4" data-aos="zoom-in-down" data-aos-once="true">
                    <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-circle text-primary me-2 fa-lg"></i> {{ student.user.full_name }}</h5>
                        <button @click="panel='profileEdit'" class="btn btn-outline-primary rounded-pill btn-sm px-4 shadow-sm fw-bold" type="button">
                            <i class="fas fa-pen me-1"></i> Edit
                        </button>
                    </div>
                    <div class="card-body p-0 pb-3">
                        <ul class="list-group list-group-flush rounded-bottom-4">
                            <li class="list-group-item d-flex align-items-center p-3 border-bottom">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-info-circle text-primary fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-bold text-uppercase">Class</span>
                                    <span class="text-dark fs-6">{{ student.class_name ?? 'Not Set' }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center p-3 border-bottom">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-user-tie text-primary fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-bold text-uppercase">Emergency Contact</span>
                                    <span class="text-dark fs-6">{{ student.emergency_contact_name ?? 'Not Set' }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center p-3 border-bottom">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-phone-alt text-primary fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-bold text-uppercase">Mobile</span>
                                    <span class="text-dark fs-6">{{ student.user.phone ?? 'Not Set' }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center p-3 border-bottom">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-envelope text-primary fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-bold text-uppercase">Email Address</span>
                                    <span class="text-dark fs-6">{{ student.user.email ?? 'Not Set' }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center p-3 border-bottom">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-home text-primary fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-bold text-uppercase">Home Address</span>
                                    <span class="text-dark fs-6">{{ student.home_address ?? 'Not Set' }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center p-3 border-bottom">
                                <div class="bg-warning bg-opacity-10 p-2 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-map-marker-alt text-warning fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-bold text-uppercase">Pickup Location</span>
                                    <span class="text-dark fs-6">{{ student.pickup_location ?? 'Not Set' }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center p-3 border-bottom-0">
                                <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-map-pin text-success fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-bold text-uppercase">Drop Location</span>
                                    <span class="text-dark fs-6">{{ student.drop_location ?? 'Not Set' }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="panel=='profileEdit'">
            <div class="col-md-8 col-xl-6 offset-md-2 offset-xl-3 pb-5">
                <div class="card shadow-sm border-0 rounded-4" data-aos="fade">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-edit text-primary me-2"></i> Edit Profile</h5>
                    </div>
                    <div class="card-body p-4">
                        <form>
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <label class="form-label text-muted small fw-bold text-uppercase" for="full_name">Full Name</label>
                                    <input v-model="student.user.full_name" class="form-control rounded-3" type="text" id="full_name" placeholder="Student Name" name="full_name">
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label text-muted small fw-bold text-uppercase" for="class_name">Class</label>
                                    <input v-model="student.class_name" class="form-control rounded-3" type="text" id="class_name" placeholder="5A" name="class_name">
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label text-muted small fw-bold text-uppercase" for="email">Email Address</label>
                                    <input v-model="student.user.email" class="form-control rounded-3" type="email" id="email" placeholder="user@example.com" name="email">
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label text-muted small fw-bold text-uppercase" for="phone">Mobile</label>
                                    <input v-model="student.user.phone" class="form-control rounded-3" type="text" id="phone" placeholder="9999999999" name="phone">
                                </div>
                                <div class="col-12 mt-4">
                                    <label class="form-label text-muted small fw-bold text-uppercase" for="home_address">Home Address</label>
                                    <textarea v-model="student.home_address" class="form-control rounded-3" id="home_address" rows="2"></textarea>
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase" for="pickup_location">Pickup Location</label>
                                    <textarea v-model="student.pickup_location" class="form-control rounded-3 border-warning" id="pickup_location" rows="2"></textarea>
                                </div>
                                <div class="col-12 mt-3 mb-2">
                                    <label class="form-label text-muted small fw-bold text-uppercase" for="drop_location">Drop Location</label>
                                    <textarea v-model="student.drop_location" class="form-control rounded-3 border-success" id="drop_location" rows="2"></textarea>
                                </div>
                            </div>
                            
                            <div v-if="errorMessage" class="alert alert-danger bounce animated mt-3 rounded-3 border-0 shadow-sm" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i><span>{{errorMessage}}</span>
                            </div>
                            
                            <div class="d-flex gap-3 mt-4 pt-3 border-top">
                                <button @click="panel='profileDetails'" class="btn btn-light rounded-pill flex-fill fw-bold text-muted border shadow-sm py-2" type="button">
                                    Cancel
                                </button>
                                <button @click="saveStudentProfile()" class="btn btn-primary rounded-pill flex-fill fw-bold shadow py-2" type="button">
                                    <i class="fas fa-save me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>