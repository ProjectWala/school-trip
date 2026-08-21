const SESSION_API_URL = './assets/code/api/sessionapi.php'; // Update with your PHP file path
const USER_API_BASE_URL = "./assets/code/api/userApi.php";
const SERVICE_API_BASE_URL = "./assets/code/api/serviceApi.php"; // your PHP file


class SessionService {
    set(key, value) {

        //value = JSON.stringify(value);
        const params = new URLSearchParams({ action: 'set', key, value });
        return fetch(`${SESSION_API_URL}?${params}`, { method: 'POST' })
            .then(res => res.json());
    }

    get(key) {
        const params = new URLSearchParams({ action: 'get', key });

        return fetch(`${SESSION_API_URL}?${params}`).then(res => res.json());
    }

    remove(key) {
        const params = new URLSearchParams({ action: 'remove', key });
        return fetch(`${SESSION_API_URL}?${params}`).then(res => res.json());
    }
}
// change to your actual PHP file path

class UserService {

    // Get all users
    async getAllUsers() {
        const response = await fetch(`${USER_API_BASE_URL}?action=getAllUsers`);
        return response.json();
    }

    // Get user by ID
    async getUserById(id) {
        const response = await fetch(`${USER_API_BASE_URL}?action=getUserByID&id=${id}`);
        return response.json();
    }

    // Add user
    async addUser(userData) {
        const response = await fetch(`${USER_API_BASE_URL}?action=addUser`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(userData)
        });

        return response.json();
    }

    // Update user
    async updateUser(userData) {
        const response = await fetch(`${USER_API_BASE_URL}?action=updateUser`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(userData)
        });

        return response.json();
    }

    // Login
    async login(email, password) {

        const response = await fetch(`${USER_API_BASE_URL}?action=login`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                Email: email,
                PWD: password
            })
        });

        var res = await response.json();
        return res;
    }

}
class FileService {
    async uploadFile(file, folder, filename) {
        try {

            const formData = new FormData();
            formData.append("file", file);
            formData.append("folder", folder);
            formData.append("filename", filename);

            const response = await fetch("assets/code/api/fileUpload.php", {
                method: "POST",
                body: formData
            });

            const data = await response.json();

            if (data.status) {
                console.log("Upload Success:", data.path);
            } else {
                console.error("Upload Failed:", data.message);
            }

            return data;

        } catch (error) {
            console.error("Error uploading file:", error);
        }
    }
}

class ApiService {

    // Insert record
    async insert(table, data) {

        const response = await fetch(`${SERVICE_API_BASE_URL}?action=insert&table=${table}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        return response.json();
    }

    // Bulk insert
    async bulkInsert(table, dataArray) {

        const response = await fetch(`${SERVICE_API_BASE_URL}?action=bulkinsert&table=${table}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dataArray)
        });

        return response.json();
    }

    // Update record
    async update(table, data) {
        const response = await fetch(`${SERVICE_API_BASE_URL}?action=update&table=${table}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        return response.json();
    }
    async getNestedDeep(table, id) {
        const response = await fetch(`${SERVICE_API_BASE_URL}?action=getnesteddeep&table=${table}&id=${id}`);
        return response.json();
    }
    // Save nested deep object (master-detail)
    async saveNestedDeep(table, data) {
        const response = await fetch(`${SERVICE_API_BASE_URL}?action=savenesteddeep&table=${table}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        return response.json();
    }
    async syncNestedDeep(table, data) {
        const response = await fetch(`${SERVICE_API_BASE_URL}?action=syncnesteddeep&table=${table}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        return response.json();
    }


    // Bulk update
    async bulkUpdate(table, data, conditions) {
        const response = await fetch(`${SERVICE_API_BASE_URL}?action=bulkupdate&table=${table}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                data: data,
                conditions: conditions
            })
        });

        return response.json();
    }

    // Save (Insert or Update)
    async save(table, data) {
        const response = await fetch(`${SERVICE_API_BASE_URL}?action=save&table=${table}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        return response.json();
    }

    // Bulk Save (Insert + Update)
    async bulkSave(table, dataArray) {

        if (!table) throw new Error("Table name required");
        if (!Array.isArray(dataArray)) throw new Error("Data must be an array");

        const response = await fetch(`${SERVICE_API_BASE_URL}?action=bulksave&table=${table}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dataArray)
        });

        if (!response.ok) {
            throw new Error("Bulk save failed");
        }

        return response.json();
    }
    async bulkUpsert(table, dataArray) {

        if (!table) throw new Error("Table name required");
        if (!Array.isArray(dataArray)) throw new Error("Data must be an array");

        const response = await fetch(`${SERVICE_API_BASE_URL}?action=bulkupsert&table=${table}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dataArray)
        });

        if (!response.ok) {
            throw new Error("Bulk upsert failed");
        }

        return response.json();
    }
    // Delete record
    async deleteById(table, id) {
        debugger;
        var data = { id: id }
        const response = await fetch(`${SERVICE_API_BASE_URL}?action=deletebyid&table=${table}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });
        return response.json();
    }

    // Get record by ID
    async getById(table, id) {
        if (!table || !id) {
            throw new Error("Both table and id must be provided");
        }

        const response = await fetch(`${SERVICE_API_BASE_URL}?action=getbyid&table=${table}&id=${id}`);
        return response.json();
    }

    // Get list
    async getList(table, where = "", order = "", limit = "") {

        const params = new URLSearchParams({
            action: "getlist",
            table: table,
            where: where,
            order: order,
            limit: limit
        });

        const response = await fetch(`${SERVICE_API_BASE_URL}?${params}`);
        return response.json();
    }

    // Get paged data
    async getPaged(table, page = 1, pageSize = 10, where = "", order = "") {
        const params = new URLSearchParams({
            action: "getpaged",
            table,
            page,
            pagesize: pageSize,
            where,
            order
        });

        const response = await fetch(`${SERVICE_API_BASE_URL}?${params}`);
        return response.json();
    }

    // Find records by object
    async find(table, data = null) {

        const options = {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            }
        };

        // Only send body if data exists
        if (data !== null && data !== undefined) {
            options.body = JSON.stringify(data);
        }

        const response = await fetch(`${SERVICE_API_BASE_URL}?action=find&table=${table}`, options);

        return response.json();
    }


    async filterByAnd(table, data = null) {
        const options = {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            }
        };

        if (data !== null && data !== undefined) {
            options.body = JSON.stringify(data);
        }

        const response = await fetch(`${SERVICE_API_BASE_URL}?action=filterbyand&table=${table}`, options);
        return response.json();
    }

    // Filter records using OR conditions
    async filterByOr(table, data = null) {
        const options = {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            }
        };

        if (data !== null && data !== undefined) {
            options.body = JSON.stringify(data);
        }

        const response = await fetch(`${SERVICE_API_BASE_URL}?action=filterbyor&table=${table}`, options);
        return response.json();
    }


    // Get full database
    async getDB() {
        const response = await fetch(`${SERVICE_API_BASE_URL}?action=getdb`);
        return response.json();
    }

    // Update full database
    async updateDB(dbData) {
        const response = await fetch(`${SERVICE_API_BASE_URL}?action=updatedb`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dbData)
        });

        return response.json();
    }
    async getTable(tableName) {
        if (!tableName) throw new Error("Table name required");

        const url = `${SERVICE_API_BASE_URL}?action=gettable&table=${encodeURIComponent(tableName)}`;

        const response = await fetch(url, {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });

        if (!response.ok) throw new Error("Failed to fetch table");

        return await response.json();
    }
    async updateTable(tableName, records) {
        if (!tableName) throw new Error("Table name required");
        if (!Array.isArray(records)) throw new Error("Records must be an array");

        const url = `${SERVICE_API_BASE_URL}?action=updatetable&table=${encodeURIComponent(tableName)}`;

        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(records)
        });

        if (!response.ok) throw new Error("Failed to update table");

        return await response.json();
    }
    // Generic SQL execution (SELECT only)
    async execute(sql) {
        const response = await fetch(`${SERVICE_API_BASE_URL}?action=execute`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ sql })
        });

        return response.json();
    }

}

export const sessionService = new SessionService();
export const userService = new UserService();
export const fileService = new FileService();
export const apiService = new ApiService();


