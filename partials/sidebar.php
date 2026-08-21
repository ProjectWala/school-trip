<nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark">
    <div class="container-fluid d-flex flex-column p-0"><a
            class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <div class="sidebar-brand-icon">
                <img class="rounded-circle img-fluid mt-2" src="assets/img/logo.jpg" width="65" height="65" />
            </div>
            <div class="sidebar-brand-text mx-3"><span>School TRP</span></div>
        </a>
        <hr class="sidebar-divider my-0" />
        <ul id="accordionSidebar" class="navbar-nav text-light">
            <li class="nav-item"><a role="button" @click="showPanel='Dashboard'" class="nav-link active"><i
                        class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <li class="nav-item"><a role="button" @click="showPanel='studentList'" class="nav-link"><i
                        class="fas fa-user"></i><span>Students</span></a></li>
            <li class="nav-item"><a role="button" @click="showPanel='driverList'" class="nav-link"><i
                        class="fa fa-truck"></i><span>Drivers</span></a></li>
            <li class="nav-item"><a role="button" @click="showPanel='Payments'" class="nav-link"><i
                        class="fas fa-rupee-sign"></i><span>Payments</span></a></li>
            <li class="nav-item"><a role="button" @click="showPanel='Attendance'" class="nav-link"><i
                        class="far fa-calendar-check"></i><span>Attendance</span></a></li>
            <li class="nav-item"><a role="button" @click="showPanel='Assignment'" class="nav-link"><i
                        class="fas fa-random"></i><span>Assignments</span></a></li>
        </ul>
        <div class="text-center d-none d-md-inline"><button id="sidebarToggle" class="btn rounded-circle border-0"
                type="button"></button></div>
    </div>
</nav>