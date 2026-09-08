
var anonKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im1jaGZic21sc2dhZHBvYXd6d2trIiwicm9sZSI6ImFub24iLCJpYXQiOjE3ODE3NTYzMTUsImV4cCI6MjA5NzMzMjMxNX0.MbHgQ4fbQcPrmRRstnug5uDw4EHh-uF6HQUmz6IrUPU';
var publishableKey = 'sb_publishable_tmeruugYhie7Ghqh2-OlCA_qe0tr6dL';
var baseUrl = "https://mchfbsmlsgadpoawzwkk.supabase.co/";
const corsHeaders = {
    headers: {
        "Content-Type": "application/json",
        "apikey": publishableKey,
        "Authorization": `Bearer ${publishableKey}`
    }
};

var URLs = {};
URLs.login = baseUrl + "functions/v1/login";

URLs.markAttendance = baseUrl + "functions/v1/mark-attendance";
URLs.markAttendanceByStudentId = baseUrl + "functions/v1/mark-attendance-by-student-id";
URLs.saveStudent = baseUrl + "functions/v1/save-student-profile";
URLs.createStudent = baseUrl + "functions/v1/create-student";
URLs.getStudents = baseUrl + "functions/v1/get-students";
URLs.getStudentDetails = baseUrl + "functions/v1/get-student-details";
URLs.getActiveStudentsAttendance = baseUrl + "functions/v1/ ";
URLs.getStudentAttendanceByDriverId = baseUrl + "functions/v1/get-student-attendance-by-driver-id";
URLs.getStudentAttendanceByDriverIdAndDate = baseUrl + "functions/v1/get-student-attendance-by-driver-id-and-date";

URLs.getAttendanceByStudentId = baseUrl + "functions/v1/get-student-attendance-by-student-id";

URLs.getAssignedDriverByStudentId = baseUrl + "functions/v1/get-assigned-driver-info-by-student-id";

URLs.getPaymentHistory = baseUrl + "functions/v1/get-payment-history";
URLs.getStudentAttendanceStatus = baseUrl + "functions/v1/get-student-attendance-status";
URLs.getMonthlyPaymentStatus = baseUrl + "functions/v1/monthly-payment-status";
URLs.getDrivers = baseUrl + "functions/v1/get-drivers";
URLs.createDriverProfile = baseUrl + "functions/v1/create-driver";
URLs.updateDriverProfile = baseUrl + "functions/v1/save-driver-profile";
URLs.getPaymentsByMonth = baseUrl + "functions/v1/get-payments-by-month";
URLs.makePayment = baseUrl + "functions/v1/make-payment";
URLs.getFares = baseUrl + "functions/v1/get-fares";
URLs.getHolidaysList = baseUrl + "functions/v1/get-holidays-list";

// Assign Students
URLs.assignStudentToDriver = baseUrl + "functions/v1/assign-student-to-driver";




import { createClient } from 'https://esm.sh/@supabase/supabase-js';

class SupabaseHelper {
    async getToken() {

        return await localStorage.getItem('token');
    }
    async login(id, password) {


        try {
            const response = await fetch(
                URLs.login,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id,
                        password,
                    }),
                }
            );

            const data = await response.json();

            return data;
        } catch (error) {
            console.error("Login Error:", error.message);

            return {
                success: false,
                message: error.message,
            };
        }
    }


    async markAttendance(data) {

        try {
            const response = await fetch(URLs.markAttendance,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "apikey": anonKey,
                        "Authorization": `Bearer ${anonKey}`
                    },

                    body: JSON.stringify(data),
                }
            );

            const resp = await response.json();

            if (!response.ok) {
                throw new Error(resp.message || "Attendance failed");
            }

            return {
                success: true,
                resp,
            };
        } catch (error) {
            return {
                success: false,
                message: error.message,
            };
        }
    }


    async getStudentAttendanceByDriverId(driverId, route, date = new Date().toLocaleDateString('en-CA')) {

        var token = await this.getToken();
        var supabase = createClient(baseUrl, anonKey);

        try {
            const params = new URLSearchParams({
                driver_id: driverId,
                route: route,
            });

            if (date) {
                params.append("date", date);
                params.append("attendance_date", date);
            }

            const response = await fetch(
                `${URLs.getStudentAttendanceByDriverIdAndDate}?${params.toString()}`,
                {
                    method: "GET",
                    headers: {
                        Authorization: `Bearer ${anonKey}`,
                        "Content-Type": "application/json",
                    },
                }
            );

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || "Failed to fetch driver students");
            }

            return data;
        } catch (error) {
            console.error("getStudentAttendanceByDriverId error:", error);

            return {
                success: false,
                error: error.message,
                data: [],
            };
        }
    }

    async getDriverStudentsWithAttendance(driverId, route, date = new Date().toLocaleDateString('en-CA')) {
        return this.getStudentAttendanceByDriverId(driverId, route, date);
    }
    async getAttendanceByStudentId(studentId, route = null, attendanceDate = null) {
        var token = await this.getToken();
        var supabase = createClient(baseUrl, anonKey);

        try {
            const params = new URLSearchParams({
                student_id: studentId,
            });

            if (route) {
                params.append("route", route);
            }

            if (attendanceDate) {
                params.append("attendance_date", attendanceDate);
            }

            const response = await fetch(
                `${URLs.getAttendanceByStudentId}?${params.toString()}`,
                {
                    method: "GET",
                    headers: {
                        Authorization: `Bearer ${anonKey}`,
                        "Content-Type": "application/json",
                    },
                }
            );

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || data.error || "Failed to fetch attendance");
            }

            return data;
        } catch (error) {
            console.error("getAttendanceByStudentId error:", error);

            return {
                success: false,
                message: error.message,
                data: [],
            };
        }
    }

    async uploadImage(file, userId) {
        // Construct a unique path (e.g., folder/filename.png)
        const filePath = `profiles/${userId}`

        const { data, error } = await supabase.storage
            .from('avatars') // Your bucket name
            .upload(filePath, file, {
                cacheControl: '3600',
                upsert: false // Set to true to overwrite existing files
            })

        if (error) {
            console.error('Upload failed:', error.message)
            return null
        }

        // Returns the uploaded file path data (e.g., { path: "profiles/12345_me.png" })
        return data.path
    }


    /**
     * Get all ACTIVE students with today's pickup & drop attendance status
     */

    async getActiveStudentsAttendance() {

        try {
            const response = await fetch(
                `${URLs.getStudentDetails}?student_id = ${studentId} `,
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${anonKey} `,
                    },
                }
            );
            debugger;
            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || "Failed to fetch student");
            }

            return {
                success: true,
                data: result.data,
            };
        } catch (error) {
            return {
                success: false,
                message: error.message,
            };
        }
    }


    async createStudent(student) {
        debugger;
        try {
            const response = await fetch(URLs.createStudent, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    apikey: anonKey,
                    Authorization: `Bearer ${anonKey} `,
                },
                body: JSON.stringify(student),
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data?.message ||
                    data?.error ||
                    "Student creation failed"
                );
            }

            return {
                success: true,
                data,
            };

        } catch (error) {
            console.error("Create Student Error:", error);

            return {
                success: false,
                message: error.message,
            };
        }
    }

    async getStudents() {

        try {
            const response = await fetch(
                `${URLs.getStudents}`,
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${anonKey} `,
                    },
                }
            );

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || "Failed to fetch student");
            }

            return {
                success: true,
                data: result.data,
            };
        } catch (error) {
            return {
                success: false,
                message: error.message,
            };
        }
    }
    async saveStudent(student) {
        debugger;
        try {
            const response = await fetch(URLs.saveStudent, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    apikey: anonKey,
                    Authorization: `Bearer ${anonKey} `,
                },
                body: JSON.stringify(student),
            });

            const resp = await response.json();
            return resp;

        } catch (error) {
            console.error("Create Student Error:", error);

            return {
                success: false,
                message: error.message,
            };
        }
    }
    async assignStudentToDriver(studentId, driverId) {
        debugger;
        var payload = {
            "student_id": studentId,
            "driver_id": driverId
        };
        try {
            const response = await fetch(URLs.assignStudentToDriver, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    apikey: anonKey,
                    Authorization: `Bearer ${anonKey} `,
                },
                body: JSON.stringify(payload),
            });

            const resp = await response.json();
            return resp;

        } catch (error) {
            console.error("Create Student Error:", error);

            return {
                success: false,
                message: error.message,
            };
        }
    }
    async getStudentDetails(studentId) {

        try {
            const response = await fetch(
                `${URLs.getStudentDetails}?student_id = ${studentId} `,
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${anonKey} `,
                    },
                }
            );
            debugger;
            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || "Failed to fetch student");
            }

            return {
                success: true,
                data: result.data,
            };
        } catch (error) {
            return {
                success: false,
                message: error.message,
            };
        }
    }
    async getAssignedDriverByStudentId(studentId) {

        var token = await this.getToken();
        var supabase = createClient(baseUrl, anonKey);

        try {
            const response = await fetch(
                `${URLs.getAssignedDriverByStudentId}?student_id=${studentId}`,
                {
                    method: "GET",
                    headers: {
                        Authorization: `Bearer ${anonKey}`,
                        "Content-Type": "application/json",
                    },
                }
            );

            const data = await response.json();

            return data;
        } catch (error) {
            console.error("getAssignedDriverByStudentId error:", error);

            return {
                success: false,
                error: error.message,
                data: [],
            };
        }
    }
    async getHolidaysList() {

        var token = await this.getToken();
        var supabase = createClient(baseUrl, anonKey);

        try {
            const response = await fetch(
                `${URLs.getHolidaysList}`,
                {
                    method: "GET",
                    headers: {
                        Authorization: `Bearer ${anonKey}`,
                        "Content-Type": "application/json",
                    },
                }
            );
            debugger;
            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || "Failed to fetch holidays info");
            }

            return data;
        } catch (error) {
            console.error("getHolidaysList error:", error);

            return {
                success: false,
                error: error.message,
                data: [],
            };
        }
    }
    async getPaymentHistory(params = {}) {
        // Fetch user access token properly
        const token = await this.getToken();

        try {
            // Build query string dynamically from the passed params object
            const queryParams = new URLSearchParams();

            if (params.from_date) queryParams.append("from_date", params.from_date);
            if (params.to_date) queryParams.append("to_date", params.to_date);
            if (params.student_id) queryParams.append("student_id", params.student_id);

            const queryString = queryParams.toString();
            const requestUrl = queryString ? `${URLs.getPaymentHistory}?${queryString}` : URLs.getPaymentHistory;

            const response = await fetch(requestUrl, {
                method: "GET",
                headers: {
                    // Pass user JWT token (or fall back to anonKey if token isn't available)
                    Authorization: `Bearer ${token || anonKey}`,
                    "Content-Type": "application/json",
                },
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || "Failed to fetch payment history");
            }

            return data;
        } catch (error) {
            console.error("getPaymentHistory error:", error);

            return {
                success: false,
                error: error.message,
                data: [],
            };
        }
    }
    async getStudentAttendanceStatus(attendance_date = null) {
        const token = await this.getToken();

        try {
            const queryParams = new URLSearchParams();

            if (attendance_date != null) {
                queryParams.append("attendance_date", attendance_date);
            }

            const url = `${URLs.getStudentAttendanceStatus}${queryParams.toString() ? `?${queryParams.toString()}` : ""
                }`;

            const response = await fetch(url, {
                method: "GET",
                headers: {
                    Authorization: `Bearer ${token}`, // or anonKey if that's intended
                    "Content-Type": "application/json",
                },
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || "Failed to fetch attendance status");
            }

            return result;
        } catch (error) {
            console.error("getStudentAttendanceStatus error:", error);

            return {
                success: false,
                error: error.message,
                data: [],
            };
        }
    }

    async getMonthlyPaymentStatus(params = null) {
        const token = await this.getToken();

        try {
            const queryParams = new URLSearchParams();

            if (params?.date != null) {
                queryParams.append("date", params.date);
            }

            if (params?.month != null) {
                queryParams.append("month", params.month);
            }

            if (params?.year != null) {
                queryParams.append("year", params.year);
            }

            const url = `${URLs.getMonthlyPaymentStatus}${queryParams.toString() ? `?${queryParams.toString()}` : ""
                }`;

            const response = await fetch(url, {
                method: "GET",
                headers: {
                    Authorization: `Bearer ${token}`, // or anonKey if that's intended
                    "Content-Type": "application/json",
                },
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || "Failed to fetch payment status");
            }

            return result;
        } catch (error) {
            console.error("getMonthlyPaymentStatus error:", error);

            return {
                success: false,
                error: error.message,
                data: [],
            };
        }
    }
    async getPaymentsByMonth(params = {}) {
        const token = await this.getToken();

        try {
            const queryParams = new URLSearchParams();

            if (params?.month != null) {
                queryParams.append("month", params.month);
            }

            if (params?.year != null) {
                queryParams.append("year", params.year);
            }

            // Handles include_pending (defaults to false if omitted or undefined)
            if (params?.include_pending != null) {
                queryParams.append("include_pending", params.include_pending);
            }

            const queryString = queryParams.toString();
            const url = `${URLs.getPaymentsByMonth}${queryString ? `?${queryString}` : ""}`;

            const response = await fetch(url, {
                method: "GET",
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                },
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || "Failed to fetch payment status");
            }

            return {
                success: true,
                data: result.data || [],
            };
        } catch (error) {
            console.error("getMonthlyPaymentStatus error:", error);

            return {
                success: false,
                error: error.message || "An unexpected error occurred",
                data: [],
            };
        }
    }

    async makePayment(params) {
        debugger;
        try {
            const response = await fetch(URLs.makePayment, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    apikey: anonKey,
                    Authorization: `Bearer ${anonKey} `,
                },
                body: JSON.stringify(params),
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data?.message ||
                    data?.error ||
                    "Payment creation failed"
                );
            }

            return {
                success: true,
                data,
            };

        } catch (error) {
            console.error("makePayment:", error);

            return {
                success: false,
                message: error.message,
            };
        }
    }

    async getDrivers(attendance_date = null) {
        const token = await this.getToken();

        try {
            const queryParams = new URLSearchParams();

            if (attendance_date != null) {
                queryParams.append("attendance_date", attendance_date);
            }

            const url = `${URLs.getDrivers}${queryParams.toString() ? `?${queryParams.toString()}` : ""
                }`;

            const response = await fetch(url, {
                method: "GET",
                headers: {
                    Authorization: `Bearer ${token}`, // or anonKey if that's intended
                    "Content-Type": "application/json",
                },
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || "Failed to fetch attendance status");
            }

            return result;
        } catch (error) {
            console.error("getDrivers error:", error);

            return {
                success: false,
                error: error.message,
                data: [],
            };
        }
    }

    async createDriverProfile(driver) {


        try {
            const response = await fetch(URLs.createDriverProfile, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    apikey: anonKey,
                    Authorization: `Bearer ${anonKey} `,
                },
                body: JSON.stringify(driver),
            });

            const data = await response.json();
            debugger;
            return data;

        } catch (error) {
            console.error("Create Driver Error:", error);

            return {
                success: false,
                message: error.message,
            };
        }
    }
    async updateDriverProfile(driver) {
        debugger;

        try {
            const response = await fetch(URLs.updateDriverProfile, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    apikey: anonKey,
                    Authorization: `Bearer ${anonKey} `,
                },
                body: JSON.stringify(driver),
            });

            const data = await response.json();
            if (!data.success) {
                return {
                    success: false,
                    message: data.error

                };
            }
            return data;

        } catch (error) {
            console.error("Create Driver Error:", error);

            return {
                success: false,
                message: error.message,
            };
        }
    }

    async getFares() {
        const token = await this.getToken();

        try {
            const queryParams = new URLSearchParams();

            const url = `${URLs.getFares}`;

            const response = await fetch(url, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    apikey: publishableKey,
                    Authorization: `Bearer ${publishableKey} `,
                },
            });

            const result = await response.json();

            return result;
        } catch (error) {
            console.error("getDrivers error:", error);

            return {
                success: false,
                error: error.message,
                data: [],
            };
        }
    }

    async getAttendanceForStudentsByDate(studentIds, date) {
        if (!studentIds || studentIds.length === 0) {
            return { success: true, data: [] };
        }
        try {
            const idFilter = studentIds.join(',');
            const response = await fetch(
                `${baseUrl}rest/v1/attendance?attendance_date=eq.${date}&student_id=in.(${idFilter})&select=*`,
                {
                    method: "GET",
                    headers: {
                        Authorization: `Bearer ${anonKey}`,
                        apikey: anonKey,
                        "Content-Type": "application/json",
                    },
                }
            );

            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || data.error || "Failed to fetch attendance history");
            }

            return {
                success: true,
                data: data || [],
            };
        } catch (error) {
            console.error("getAttendanceForStudentsByDate error:", error);
            return {
                success: false,
                error: error.message,
                data: [],
            };
        }
    }

}



export const supabaseHelper = new SupabaseHelper();