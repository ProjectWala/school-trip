# Project Analysis: School Trip Management System

## Project Overview
The **School Trip Management System** is a web-based platform designed to manage and track student transportation. It facilitates communication and data management between school administrators, drivers, and parents (students).

## Tech Stack
- **Frontend:**
    - **Framework:** Vue.js 3 (Progressive enhancement/CDN based)
    - **Styling:** Bootstrap 5, Custom CSS
    - **Animations:** AOS (Animate on Scroll), Lottie-player
    - **Icons:** FontAwesome
- **Backend:**
    - **Language:** PHP 8.x
    - **Database:** MySQL (Local/Legacy) & Supabase (Modern Backend-as-a-Service)
    - **Authentication:** Supabase Auth (via Edge Functions)
    - **Mail Services:** Brevo (formerly Sendinblue), PHPMailer
- **External Libraries:**
    - `html5-qrcode` for QR code scanning
    - `SweetAlert2` for UI alerts
    - `alertify.js` for notifications

## Architecture
The project follows a hybrid architecture:
1.  **Legacy PHP Layer:** Uses `assets/code/api/ServiceApi.php` and `assets/code/db/DBMySql.php` for direct MySQL operations. This layer handles generic CRUD operations on a MySQL database.
2.  **Modern Supabase Layer:** Most business logic (Attendance, Payments, Profile Management) is handled via Supabase Edge Functions, accessed through `services/supabaseService.js`.
3.  **Frontend Logic:** Vue.js is used to build interactive dashboards. It fetches data primarily from Supabase and sometimes from local PHP APIs.

## User Roles & Key Features

### 1. Administrator (`adminDashboard.php`)
- **Dashboard:** Overview of student attendance, driver status, and payment statistics.
- **Driver Management:** Add, update, and delete driver profiles.
- **Student Management:** View registered students and assign them to drivers.
- **Payment Tracking:** Monitor paid/pending monthly fees.
- **Fare Management:** Configure fees based on distance and vehicle type (AC/Non-AC).

### 2. Driver (`driverDashboard.php`)
- **Attendance Tracking:**
    - Mark student attendance (Pickup/Drop) for "To School" and "To Home" routes.
    - Supports manual marking and **QR Code Scanning**.
- **Student List:** View assigned students with contact information.

### 3. Student/Parent (`studentDashboard.php`)
- **Dashboard:** View current attendance status (e.g., "Picked up for School").
- **QR Code Identity:** Generate a unique QR code for drivers to scan.
- **Payment History:** Check monthly fee status and payment timeline.
- **Profile Management:** Update personal details and location.
- **Information:** View school holiday list and assigned driver/vehicle details.

## Directory Structure
- `/apis/`: PHP scripts for specific tasks like login, email confirmation, and mailing configuration.
- `/assets/`:
    - `/code/`: Core backend logic (PHP) and helper JS scripts (`localService.js`).
    - `/bootstrap/`, `/css/`, `/fonts/`, `/img/`, `/js/`: Frontend assets.
- `/partials/`: Reusable PHP components (Navbar, Sidebar, Footer, Modals).
- `/services/`: JavaScript service layers (e.g., `supabaseService.js`).
- Root Directory: Main entry points (`index.php`, `login.php`, `register.php`) and role-specific dashboards.

## Core Data Models (Observed)
- **Users:** Roles (ADMIN, DRIVER, STUDENT), email, phone, full_name.
- **Students:** Father's name, home address, pickup/drop locations, monthly fee, assigned driver.
- **Drivers:** License number, vehicle number, vehicle type (AC/Non-AC), status.
- **Attendance:** Student ID, Driver ID, Route (To School/Home), Status (Pickedup/Dropped), Timestamp.
- **Payments:** Student ID, amount, method (Cash/Online), month, year, status.

## Security & Utilities
- **Session Management:** PHP `$_SESSION` for tracking login state.
- **Environment Variables:** `.env` file (implied).
- **Validation:** Client-side validation in `localService.js`.
- **Error Handling:** Centralized through SweetAlert2 and Alertify.

## Future Recommendations
- **Consolidate Backend:** Decide between sticking with MySQL or fully migrating to Supabase to reduce architectural complexity.
- **Mobile Optimization:** While the dashboards are responsive, a PWA (Progressive Web App) approach would benefit drivers using mobile devices for QR scanning.
- **Real-time Tracking:** Implement live GPS tracking using the Supabase Realtime capabilities.
