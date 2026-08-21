# AI Project Context: School Trip Management System

This file is intended for future AI assistants to quickly understand the project architecture, tech stack, and conventions.

## 1. Project Overview
A web-based school trip management system built with a hybrid legacy PHP and modern Vue 3 + Supabase architecture. It serves three main roles: Admin, Driver, and Student/Parent.

## 2. Tech Stack
*   **Frontend**: HTML/PHP pages with Vue 3 (Options API/CDN), Bootstrap 5, FontAwesome, SweetAlert2.
*   **Backend**: PHP 8.x (for initial routing and some legacy API calls) + Supabase (BaaS for most business logic, auth, and DB).
*   **Database**: Supabase (PostgreSQL under the hood, accessed via REST/Edge Functions) and potentially a legacy local MySQL DB.
*   **Authentication**: Supabase Auth.
*   **Email**: Brevo (Sendinblue) via PHPMailer.

## 3. Directory Structure & Key Files
*   **`/` (Root)**: Entry points. 
    *   `index.php` (Landing), `login.php`, `register.php`.
    *   Role-specific dashboards: `adminDashboard.php`, `driverDashboard.php`, `studentDashboard.php`.
*   **`/services/`**: Contains `supabaseService.js`, the core frontend JS service interacting with Supabase edge functions or APIs.
*   **`/apis/`**: PHP backend endpoints (e.g., `login.php`, `email-helper.php`).
*   **`/partials/`**: Reusable PHP UI components (navbar, sidebar, footer).
*   **`/assets/code/`**: Contains legacy core backend logic (`DBMySql.php`, `ServiceApi.php`) and `localService.js`.

## 4. Architecture & State Management
*   **Hybrid Approach**: The app mixes PHP session-based routing/auth with modern frontend Vue reactivity and Supabase backend.
*   **Frontend Reactivity**: Pages like dashboards load Vue 3 via CDN. State is managed within the Vue instances mounted on specific DOM elements (e.g., `#app`).
*   **API Calls**: Handled mostly via `supabaseService.js` using `fetch` to interact with Supabase Edge Functions or REST API.

## 5. Key Features per Role
*   **Admin**: Manage drivers, students, payments, and system configurations.
*   **Driver**: Track student attendance (Pickup/Drop off), scan QR codes, view assigned students.
*   **Student/Parent**: View attendance status, generate QR code for driver, check payment history, update profile.

## 6. AI Guidelines for Modifications
*   **Frontend Changes**: Look for the `<script>` tag containing the Vue instance at the bottom of the dashboard PHP files. Do not expect single-file components (`.vue`).
*   **Backend Changes**: Check if the logic is handled in `services/supabaseService.js` (modern) or `/apis/` / `/assets/code/api/` (legacy PHP) before modifying.
*   **Styling**: Use Bootstrap 5 utility classes primarily. Custom CSS should be minimal.
