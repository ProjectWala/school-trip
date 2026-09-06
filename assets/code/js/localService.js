import data from "../data/data.js";
var users = data.users;

const userService = { login, getLoggedInUser, updateLoggedInUser, removeLoggedInUser, isLoggedIn };


const domainName = window.location.origin;



function login(identifier, password) {

    const user = users.find(u =>
        (u.userName === identifier ||
            u.email === identifier ||
            u.mobile === identifier) &&
        u.pwd === password
    );

    if (!user) {
        alert("Invalid credentials");
        return null;
    }
    set("user", user);
    return user;

}

function getLoggedInUser() {

    const user = get("user");
    return user ? JSON.parse(user) : null;
}
function isLoggedIn() {

    const user = get("user");
    return !!user;
}
function updateLoggedInUser(updatedFields) {
    const user = getLoggedInUser();
    if (!user) return null;

    const updatedUser = {
        ...user,
        ...updatedFields
    };

    localStorage.setItem("user", JSON.stringify(updatedUser));
    return updatedUser;
}
function removeLoggedInUser() {
    remove("user");
}
function createUser(user) {

    // Get existing users
    let users = get("users") || [];

    // Check duplicate user
    const exists = users.find(u =>
        u.userName === user.userName ||
        u.email === user.email ||
        u.mobile === user.mobile
    );

    if (exists) {
        alert("User already exists");
        return null;
    }

    // Create new user object with defaults
    const newUser = {
        id: users.length ? users[users.length - 1].id + 1 : 1,
        userName: user.userName || "",
        email: user.email || "",
        mobile: user.mobile || "",
        pwd: user.pwd || "",
        status: "Active",
        userType: "User",
        createdOn: new Date().toISOString(),
        rewardPoints: 0,
        ...user // override if provided
    };

    // Add user
    users.push(newUser);

    // Save back to localStorage
    set("users", users);

    return newUser;
}
function test() {
    alert('service called');
}

//------------------Product
class Product {
    addToOrder(order, product) {
        // Check if product already exists in orderDetails
        const existingItem = order.orderDetails.find(
            item => item.productId === product.id
        );
        product.isSelected = true;
        if (existingItem) {
            // Increase quantity
            existingItem.quantity += 1;
            existingItem.totalPrice =
                existingItem.quantity * Number(existingItem.price);
        } else {
            // Add new product
            order.orderDetails.push({
                id: product.id,
                productName: product.productName,
                price: Number(product.price),
                quantity: 1,
                totalPrice: Number(product.price),
                image: product.image
            });
        }

        updateOrder(order);
    }
    removeFromOrder(order, product) {
        const index = order.orderDetails.findIndex(
            item => item.id === product.id
        );

        if (index === -1) return; // Product not found

        const item = order.orderDetails[index];

        if (item.quantity > 1) {
            item.quantity -= 1;
            item.totalPrice = item.quantity * item.price;
        } else {
            order.orderDetails.splice(index, 1);
        }
        product.isSelected = false;
        updateOrder(order);
    }
    increaseQuantity(order, productId) {

        const item = order.orderDetails.find(p => p.id === productId);
        if (!item) return;

        item.quantity += 1;
        item.totalPrice = item.quantity * item.price;

        updateOrder(order);
    }
    decreaseQuantity(order, productId) {
        const index = order.orderDetails.findIndex(p => p.id === productId);
        if (index === -1) return;

        const item = order.orderDetails[index];

        if (item.quantity > 1) {
            item.quantity -= 1;
            item.totalPrice = item.quantity * item.price;
        } else {
            // Remove item if quantity becomes 0
            order.orderDetails.splice(index, 1);
        }

        recalcTotal(order);
    }
    updateOrder(order) {
        order.totalPrice = order.orderDetails.reduce(
            (sum, item) => sum + item.totalPrice,
            0
        );
    }
    placeOrder(order) {

        order.orderDateTime = new Date();
        order.orderNumber = Date.now();

        let orders = JSON.parse(localStorage.getItem('orders'));

        if (!Array.isArray(orders)) {
            orders = [];
        }

        order.id = orders.length + 1;
        order.status = 'pending';

        orders.push(order);

        // Save back to localStorage
        localStorage.setItem('orders', JSON.stringify(orders));
    }
    loadOrders() {
        let orders = JSON.parse(localStorage.getItem('orders'));

        if (!Array.isArray(orders)) {
            return [];
        }

        // Restore Date object
        orders.forEach(order => {
            order.orderDateTime = new Date(order.orderDateTime);
        });

        return orders.sort(
            (a, b) => b.orderDateTime - a.orderDateTime
        );

    }
    updateOrderStatusById(orderId, newStatus) {

        let orders = JSON.parse(localStorage.getItem('orders')) || [];

        const order = orders.find(o => o.id === orderId);
        if (!order) return null;

        order.status = newStatus;
        order.updatedAt = new Date().toISOString();

        localStorage.setItem('orders', JSON.stringify(orders));

        return order;
    }
    getOrdersByStatus(status) {
        return loadOrders().filter(o => o.status === status);
    }
    clearOrders() {
        localStorage.removeItem('orders');
    }
}


// session | Local storage -------------------------------------------------------------------
class LocalStorage {

    set(key, value) {
        // Convert objects/arrays to JSON before storing
        console.log('localStorage.set', key, value);

        const valueToStore = typeof value === "object"
            ? JSON.stringify(value)
            : value;

        localStorage.setItem(key, valueToStore);
    }
    get(key) {
        console.log('localStorage.get', key);
        const value = localStorage.getItem(key);

        if (value === null) return null;

        // Try to parse JSON (for objects/arrays)
        try {
            return JSON.parse(value);
        } catch (e) {
            return value; // Return as string if not JSON
        }
    }
    remove(key) {

        console.log('localStorage.remove', key);
        localStorage.removeItem(key);
    }

    setIfNotPresent(key, value) {

        var value = get(key);
        if (!!value) return null;
        set(key, value);
    }
}



// Email -------------------------------------------------------------------
class Eamil {
    async sendEmail(emailId, title, body) {
        try {
            const response = await fetch(`${domainName}/apis/send-mail.php`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    emailId: emailId,
                    title: title,
                    body: body
                })
            });

            const result = await response.json();

            if (result.status) {
                console.log("Email sent successfully");
            } else {
                console.error("Failed:", result.message);
            }

            return result;

        } catch (error) {
            console.error("Error:", error);
            return { status: false, message: "Request failed" };
        }
    }

    async sendEmailConfirmation(email, code) {

        try {
            const response = await fetch('apis/send-confirmation-email.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    emailId: email,
                    guid: code
                })
            });

            const data = await response.json();

            return {
                success: true,
                data: data
            };
        } catch (err) {
            console.error(err);

            return {
                success: false,
                error: err
            };
        }
    }
}


// Siren Buzzer ------------------------------------------------------------------------------------

class Sound {
    playSiren(duration = 3000) {
        debugger;
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();

        osc.type = "sawtooth";
        osc.connect(gain);
        gain.connect(ctx.destination);

        let start = ctx.currentTime;
        let end = start + duration / 1000;

        function sweep(time) {
            osc.frequency.setValueAtTime(600, time);
            osc.frequency.linearRampToValueAtTime(1400, time + 0.5);
            osc.frequency.linearRampToValueAtTime(600, time + 1);
        }

        for (let t = start; t < end; t += 1) {
            sweep(t);
        }

        gain.gain.value = 0.6;
        osc.start();
        osc.stop(end);

    }

    playBuzzer(frequency = 100, duration = 500) {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();

        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();

        oscillator.type = "square";
        oscillator.frequency.value = frequency;

        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);

        oscillator.start();

        setTimeout(() => {
            oscillator.stop();
            audioCtx.close();
        }, duration);
    }
}

class Validation {

    // ✅ Regex patterns stored as a class variable
    patterns = {
        email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        url: /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/,
        username: /^[a-zA-Z0-9_]+$/,
        name: /^[a-zA-Z 0-9_]+$/,
        mobile: /^[0-9]{10,15}$/,
        guid: /^[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[1-5][0-9a-fA-F]{3}\-[89abAB][0-9a-fA-F]{3}\-[0-9a-fA-F]{12}$/,
        password: {
            upper: /[A-Z]/,
            lower: /[a-z]/,
            number: /[0-9]/,
            special: /[!@#$%^&*(),.?":{}|<>]/
        }
    };

    // ✅ Boolean validation based on regex
    isEmail(email) {
        return this.patterns.email.test(email);
    }

    isUrl(url) {
        try {
            new URL(url);
            return true;
        } catch {
            return this.patterns.url.test(url);
        }
    }

    isGuid(guid) {
        return this.patterns.guid.test(guid);
    }

    isName(name) {
        return this.patterns.name.test(name);
    }

    isUsername(username) {
        return this.patterns.username.test(username);
    }

    isMobile(mobile) {
        return this.patterns.mobile.test(mobile);
    }

    // ✅ Check empty
    isEmpty(value) {
        return !value || value.trim().length === 0;
    }

    // ✅ Email validation
    validateEmail(email, required = true) {
        let errors = [];
        if (required == false && this.isEmpty(email)) return errors;
        if (required && this.isEmpty(email)) {
            return ["Email is required"];
        }

        if (!this.isEmail(email)) {
            errors.push("Invalid email format");
        }

        return errors;
    }

    // ✅ Username validation
    validateUsername(username, required = true) {
        let errors = [];

        if (required && this.isEmpty(username)) {
            return ["Username is required"];
        }

        if (username.length < 3 || username.length > 20) {
            errors.push("Username must be 3–20 characters");
        }

        if (!this.isUsername(username)) {
            errors.push("Only letters, numbers, and underscore allowed");
        }

        return errors;
    }

    // ✅ Name validation
    validateName(name, required = true) {
        let errors = [];

        if (required && this.isEmpty(name)) {
            return ["Name is required"];
        }

        if (name.length < 3 || name.length > 20) {
            errors.push("Name must be 3–20 characters");
        }

        if (!this.isName(name)) {
            errors.push("Only letters, numbers, spaces and underscore allowed");
        }

        return errors;
    }
    // ✅ Password validation (your improved version)
    validatePassword(password, required = true) {
        let errors = [];

        if (required && this.isEmpty(password)) {
            return ["Password is required"];
        }

        if (password.length < 8 || password.length > 14) {
            errors.push("8 to 14 characters required");
        }

        if (!this.patterns.password.upper.test(password)) {
            errors.push("At least 1 uppercase letter required");
        }

        if (!this.patterns.password.lower.test(password)) {
            errors.push("At least 1 lowercase letter required");
        }

        if (!this.patterns.password.number.test(password)) {
            errors.push("At least 1 number required");
        }

        if (!this.patterns.password.special.test(password)) {
            errors.push("At least 1 special character required");
        }

        return errors;
    }

    // ✅ Confirm password
    validateConfirmPassword(password, confirmPassword) {
        if (this.isEmpty(confirmPassword)) {
            return ["Confirm password is required"];
        }

        if (password !== confirmPassword) {
            return ["Passwords do not match"];
        }

        return [];
    }

    // ✅ Phone number (basic)
    validateMobile(phone, required = true) {
        let errors = [];

        if (this.isEmpty(phone)) {
            return ["Phone number is required"];
        }

        if (!this.isMobile(phone)) {
            errors.push("Phone must be 10 digits");
        }

        return errors;
    }

    // ✅ Array validation
    validateArray(arr) {
        if (!Array.isArray(arr) || arr.length === 0) {
            return ["Array is empty or invalid"];
        }
        return [];
    }
    hasElements(arr) {
        return Array.isArray(arr) && arr.length > 0;
    }

    // ✅ Address validation with sanitization
    validateAddress(address) {
        let errors = [];

        if (this.isEmpty(address)) {
            return {
                value: "",
                errors: ["Address is required"]
            };
        }

        // Sanitize
        const sanitized = address
            .trim()
            .replace(/\s+/g, " ")                  // Multiple spaces → single
            .replace(/[^\w\s,./#\-()]/g, "");      // Allow letters, numbers and common address symbols

        if (sanitized.length < 5) {
            errors.push("Address must be at least 5 characters");
        }

        if (sanitized.length > 255) {
            errors.push("Address must not exceed 255 characters");
        }

        return {
            value: sanitized,
            errors
        };
    }
}
class Tools {
    wait(milliseconds) {
        return new Promise(resolve => {
            setTimeout(resolve, milliseconds);
        });
    }
    closeModal(modalId) {
        const modalEl = document.getElementById(modalId);
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal?.hide();
    }
}


// Navigation ---------------------------------------------------------------------------------------
export const navigationService = {

    // Navigate with history (Back button works)
    goto(url) {
        window.location.href = url;
    },

    // Navigate without history (Back button won't return)
    open(url) {
        window.location.replace(url);
    },
    openWhatsApp(phone, message = "") {
        const url = `https://wa.me/91${phone}?text=${encodeURIComponent(message)}`;
        window.open(url, "_blank");
    }
};

export const helperService = {
    timeAgo(dateTime) {
        const now = new Date();
        const past = new Date(dateTime);
        const seconds = Math.floor((now - past) / 1000);

        const intervals = {
            year: 31536000,
            month: 2592000,
            week: 604800,
            day: 86400,
            hour: 3600,
            minute: 60,
            second: 1
        };

        for (let key in intervals) {
            const interval = Math.floor(seconds / intervals[key]);
            if (interval >= 1) {
                return interval + " " + key + (interval > 1 ? "s" : "") + " ago";
            }
        }

        return "just now";
    }
}
const productService = new Product();
const sound = new Sound();// { playBuzzer, playSiren };
const validations = new Validation();
const emailService = new Eamil();
const storageService = new LocalStorage();
const tools = new Tools();
const services = { userService, productService, storageService, emailService, sound, tools };

export default services;
export { userService, productService, storageService, emailService, sound, validations, tools };