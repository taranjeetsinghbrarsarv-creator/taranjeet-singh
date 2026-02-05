// ================= ELEMENTS SELECTION =================
const registerBtn = document.querySelector(".register");
const loginBtn = document.querySelector(".login");
const registerModal = document.getElementById("registerModal");
const loginModal = document.getElementById("loginModal");
const successModal = document.getElementById("successModal");
const registerClose = registerModal.querySelector(".close");
const loginClose = document.querySelector(".login-close");
const registerForm = document.getElementById("registerForm");
const loginForm = document.getElementById("loginForm");
const okBtn = document.getElementById("okBtn");

// ================= CHECK LOGIN ON LOAD =================
// यह हिस्सा सुनिश्चित करता है कि रिफ्रेश करने पर भी यूजर लॉग इन रहे
document.addEventListener("DOMContentLoaded", () => {
    const isLoggedIn = localStorage.getItem("isLoggedIn");
    const storedData = JSON.parse(localStorage.getItem("parkingUser"));
    
    if (isLoggedIn === "true" && storedData) {
        updateNavbar(storedData.name);
    }
});

// ================= MODAL OPEN/CLOSE =================
registerBtn.addEventListener("click", () => {
    registerModal.style.display = "flex";
});

loginBtn.addEventListener("click", () => {
    loginModal.style.display = "flex";
});

registerClose.addEventListener("click", () => {
    registerModal.style.display = "none";
});

loginClose.addEventListener("click", () => {
    loginModal.style.display = "none";
});

okBtn.addEventListener("click", () => {
    successModal.style.display = "none";
});

// ================= REGISTRATION LOGIC =================
registerForm.addEventListener("submit", function(e) {
    e.preventDefault();

    const fullName = registerForm.querySelectorAll("input")[0].value.trim();
    const email = registerForm.querySelectorAll("input")[1].value.trim();
    const phone = registerForm.querySelectorAll("input")[2].value.trim();
    const password = registerForm.querySelectorAll("input")[3].value.trim();

    // Strict Validation: अगर कोई भी फील्ड खाली है तो रोक दें
    if (!fullName || !email || !phone || !password) {
        alert("कृपया सभी जानकारी भरें!");
        return;
    }

    const userData = {
        name: fullName,
        email: email,
        phone: phone,
        pass: password
    };

    localStorage.setItem("parkingUser", JSON.stringify(userData));
    registerModal.style.display = "none";
    successModal.style.display = "flex";
    registerForm.reset();
});

// ================= LOGIN LOGIC =================
loginForm.addEventListener("submit", function(e) {
    e.preventDefault();

    const emailInput = loginForm.querySelectorAll("input")[0].value.trim();
    const passInput = loginForm.querySelectorAll("input")[1].value.trim();
    const storedData = JSON.parse(localStorage.getItem("parkingUser"));

    if (storedData && storedData.email === emailInput && storedData.pass === passInput) {
        alert("✅ Login Successful! Welcome " + storedData.name);
        localStorage.setItem("isLoggedIn", "true"); 
        loginModal.style.display = "none";
        loginForm.reset();
        updateNavbar(storedData.name);
    } else {
        alert("❌ गलत ईमेल या पासवर्ड! कृपया पहले रजिस्टर करें।");
    }
});

// Navbar अपडेट और Logout फंक्शन
function updateNavbar(userName) {
    loginBtn.innerText = "Hi, " + userName.split(" ")[0];
    registerBtn.innerText = "Logout";
    registerBtn.style.background = "#ff4d4d";
    
    // पुराने इवेंट्स हटाकर नया Logout इवेंट जोड़ना
    registerBtn.onclick = () => {
        localStorage.removeItem("isLoggedIn");
        // नोट: हम user का डेटा (parkingUser) डिलीट नहीं कर रहे ताकि वो दोबारा लॉगिन कर सके
        location.reload(); 
    };
}

// ================= SLIDER & PROTECTION =================
let slides = document.querySelectorAll(".slide");
let index = 0;

function showSlide(i) {
    slides.forEach(slide => slide.classList.remove("active"));
    if(slides[i]) slides[i].classList.add("active");
}

setInterval(() => {
    index = (index + 1) % slides.length;
    showSlide(index);
}, 3000);

// Restricted Links Control
document.querySelectorAll('a[href="slots.html"], a[href="find parking.html"]').forEach(link => {
    link.addEventListener("click", function (e) {
        if (localStorage.getItem("isLoggedIn") !== "true") {
            e.preventDefault();
            alert("🔒 स्लॉट्स बुक करने के लिए कृपया लॉगिन करें।");
            loginModal.style.display = "flex";
        }
    });
});

// Outside Click to Close
window.addEventListener("click", (e) => {
    if (e.target === registerModal) registerModal.style.display = "none";
    if (e.target === loginModal) loginModal.style.display = "none";
    if (e.target === successModal) successModal.style.display = "none";
});