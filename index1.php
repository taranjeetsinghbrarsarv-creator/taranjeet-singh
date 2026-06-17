<?php
// ===== 1. DATABASE CONNECTION & LIVE SLOTS FETCH =====
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "brar_parking";

$conn = new mysqli($host, $user, $pass, $dbname);

// Active reservations ko live read karenge taaki index page par real data dikhe
$booked_slots = [];
if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT slot_id, driver_name FROM reservations");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $booked_slots[intval($row['slot_id'])] = $row['driver_name'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safe & Secure Parking System | Brar Parking</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ===== AI SMART PARKING HIGH-LEVEL GLASSMORPHISM UI UPGRADE ===== */
        .live-status {
            display: flex;
            gap: 20px;
            margin-top: 25px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            perspective: 1000px;
        }

        .status-box {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 20px;
            border-radius: 16px;
            min-width: 160px;
            flex: 1;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }

        /* Rotation Animation Effect when content updates */
        .status-box.rotate-effect {
            transform: rotateX(360deg);
            background: rgba(255, 255, 255, 0.15);
        }

        .status-box h3 {
            margin: 0 0 6px 0;
            font-size: 18px;
            color: #ffffff;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .status-box .slot-loc {
            font-size: 12px;
            color: #94a3b8;
            margin: 0 0 12px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .status-box p {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* Pulsing Dot Effects for realistic AI look */
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
        }

        .status-dot.green { background-color: #16a34a; box-shadow: 0 0 12px #16a34a; }
        .status-dot.green::after {
            content: ''; width: 100%; height: 100%; border-radius: 50%; background: #16a34a;
            position: absolute; animation: pulse-glow 1.5s infinite ease-in-out;
        }

        .status-dot.red { background-color: #dc2626; box-shadow: 0 0 12px #dc2626; }
        .status-dot.red::after {
            content: ''; width: 100%; height: 100%; border-radius: 50%; background: #dc2626;
            position: absolute; animation: pulse-glow 1.5s infinite ease-in-out;
        }

        @keyframes pulse-glow {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(2.4); opacity: 0; }
        }

        .text-green { color: #10b981; }
        .text-red { color: #f43f5e; }
    </style>
</head>
<body>
<nav class="navbar" id="mainNavbar">
    <div class="logo">Brar Parking</div>
    
    <div class="menu-toggle" id="mobileMenuBtn" onclick="toggleMobileMenu()">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>

    <ul class="nav-links" id="navLinksMenu">
        <li><a href="#" onclick="checkLogin(event, '#')">Home</a></li>
        <li><a href="ambala.php" onclick="checkLogin(event, 'ambala.php')">Ambala Location</a></li>
        <li><a href="reviews.php" onclick="checkLogin(event, 'About.php')">About</a></li>
        <li><a href="s.php" onclick="checkLogin(event, 's.php')">Slots</a></li>
        <li><a href="contact.php" onclick="checkLogin(event, 'contact.php')">Contact</a></li>
        <li><button id="accountNavBtn" class="account-btn" onclick="handleAccountClick(event)">Account</button></li>
    </ul>
</nav>

<div id="authModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="formTitle">Register</h2>
        
        <form id="registerForm" onsubmit="registerUser(event)">
            <input type="text" id="regName" placeholder="Full Name" required>
            <input type="email" id="regEmail" placeholder="Email Address" required>
            <input type="password" id="regPassword" placeholder="Password" required>
            <button type="submit" class="submit-btn">Register & Proceed</button>
            <p>Already have an account? <span class="switch-link" onclick="showLogin()">Login here</span></p>
        </form>

        <form id="loginForm" onsubmit="loginUser(event)" style="display: none;">
            <input type="email" id="loginEmail" placeholder="Email Address" required>
            <input type="password" id="loginPassword" placeholder="Password" required>
            <button type="submit" class="submit-btn">Login & Proceed</button>
            <p>Don't have an account? <span class="switch-link" onclick="showRegister()">Register here</span></p>
        </form>
    </div>
</div>

    <section class="hero">
        <video autoplay muted loop playsinline class="bg-video">
            <source src="mp3.mp4" type="video/mp4">
        </video>
        <div class="hero-content">
            <h1>Safe & Secure Parking System</h1>
            <p>Smart online parking booking website with secure slots, fast booking and 24/7 parking availability for users.</p>
            <div class="hero-buttons">
                <button class="book-btn" onclick="checkLogin(event, 's.php')">Book Parking</button>
                <button class="learn-btn">Learn More</button>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="section-title">
            <h2>Smart Parking Features</h2>
            <p>Modern online parking system with secure booking, live parking slots and fast access.</p>
        </div>
        <div class="features-container">
            <div class="feature-card">
                <img src="https://cdn-icons-png.flaticon.com/512/854/854878.png" alt="Easy Booking">
                <h3>Easy Booking</h3>
                <p>Users can book parking slots online in just one click.</p>
            </div>
            <div class="feature-card">
                <img src="https://cdn-icons-png.flaticon.com/512/3063/3063822.png" alt="Secure Parking">
                <h3>Secure Parking</h3>
                <p>24/7 security cameras and safe parking environment.</p>
            </div>
            <div class="feature-card">
                <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="Live Location">
                <h3>Live Location</h3>
                <p>Find parking locations easily with live directions.</p>
            </div>
        </div>
    </section>

    <section class="video-section">
        <div class="video-content">
            <h2>Smart Parking Experience</h2>
            <p>Watch how our secure parking management system works for users and vehicles.</p>
        </div>
        <div class="video-box">
            <video autoplay muted loop playsinline>
                <source src="car.mp4" type="video/mp4">
            </video>
        </div>
    </section>

    <section class="gallery-section">
        <div class="section-title">
            <h2>Parking Gallery</h2>
            <p>Modern parking areas and premium smart parking slots.</p>
        </div>
        <div class="gallery-container">
            <img src="indain1.jpg" alt="Gallery 1">
            <img src="img4.jpg" alt="Gallery 2">
            <img src="img.jpg" alt="Gallery 3">
        </div>
    </section>

    <section class="smart-parking-section">
        <div class="smart-left">
            <span class="live-badge">● LIVE AI MONITORING</span>
            <h2>AI Smart Parking Experience</h2>
            <p>Advanced parking technology with live slot monitoring, smart vehicle detection and real-time database verification updates.</p>
            
            <div class="live-status">
                <div class="status-box" id="aiBox0">
                    </div>
                <div class="status-box" id="aiBox1">
                    </div>
                <div class="status-box" id="aiBox2">
                    </div>
            </div>
            
            <div class="smart-buttons">
                <button class="smart-btn" onclick="checkLogin(event, 's.php')">Explore Parking</button>
                <button class="video-btn">Watch Demo</button>
            </div>
        </div>
        <div class="smart-right">
            <img src="https://images.unsplash.com/photo-1506521781263-d8422e82f27a?q=80&w=1200&auto=format&fit=crop" class="main-img" alt="Smart Parking">
            <div class="floating-card">
                <h3>Parking Security</h3>
                <p>AI Camera Monitoring Active</p>
            </div>
        </div>
    </section>

<section class="auto-review-section">
    <div class="review-heading">
        <span>● LIVE USER FEEDBACK</span>
        <h2>Customer Parking Reviews</h2>
        <p>Real-time reviews from active parking users.</p>
    </div>
    <div class="review-main-box">
        <div class="review-form-box">
            <h3>Post Your Review</h3>
            <input type="text" id="userName" placeholder="Enter Your Name">
            <textarea id="userReview" placeholder="Write your parking experience..."></textarea>
            <button onclick="addReview()">
                <i class="fa-solid fa-paper-plane"></i>
                Submit Review
            </button>
        </div>
        <div class="review-live-box">
            <div class="review-scroll" id="reviewScroll"></div>
        </div>
    </div>
</section>

    <footer class="main-footer">
        <div class="footer-top-grid">
            <div class="footer-info-col">
                <h2 class="footer-brand-logo">Brar Parking</h2>
                <p>Providing cutting-edge AI smart cloud parking systems across Ambala. Book secure slots, enjoy instant digital receipts, and secure absolute peace of mind.</p>
                <div class="footer-social-links">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-links-col">
                <h3>Quick Navigation</h3>
                <ul>
                    <li><a href="#" onclick="checkLogin(event, '#')">Home Hub</a></li>
                    <li><a href="ambala.php" onclick="checkLogin(event, 'ambala.php')">Ambala Slots Map</a></li>
                    <li><a href="s.php" onclick="checkLogin(event, 's.php')">Active Status</a></li>
                    <li><a href="contact.php" onclick="checkLogin(event, 'contact.php')">Support Desk</a></li>
                </ul>
            </div>
            <div class="footer-links-col">
                <h3>Active Support Areas</h3>
                <ul>
                    <li><a href="#">Ambala City Junction</a></li>
                    <li><a href="#">Ambala Cantt Multi-Level</a></li>
                    <li><a href="#">Sadar Commercial Bazaar</a></li>
                    <li><a href="#">Model Town Sector Plots</a></li>
                </ul>
            </div>
            <div class="footer-contact-col">
                <h3>Corporate Desk</h3>
                <p><i class="fa-solid fa-envelope"></i> support@brarparking.com</p>
                <p><i class="fa-solid fa-phone-volume"></i> +91 98765 43210</p>
                <p><i class="fa-solid fa-location-dot"></i> Ambala City, Haryana, India</p>
            </div>
        </div>
        <div class="footer-bottom-bar">
            <p>&copy; 2026 Online Parking System. All rights reserved.</p>
            <div class="developer-credit">
                <p>Developed with <i class="fa-solid fa-heart" style="color: #ef4444;"></i> by <span>Taranjeet Singh</span></p>
            </div>
        </div>
    </footer>

    <script src="project.js"></script>

    <script>
    // 1. Array mapping list matching exactly your slots page layout
    const allParkingLocations = [
        { id: 1, name: "Slot A1", loc: "Ambala City Railway Station" },
        { id: 2, name: "Slot B2", loc: "Sadar Multilevel Parking" },
        { id: 3, name: "Slot C3", loc: "Kapra Market Lot" },
        { id: 4, name: "Slot D4", loc: "Shalimar Market Base" },
        { id: 5, name: "Slot E5", loc: "Main Bus Stand Yard" },
        { id: 6, name: "Slot F6", loc: "Civil Hospital Compound" },
        { id: 7, name: "Slot G7", loc: "Judicial Court Complex" },
        { id: 8, name: "Slot H8", loc: "Mall Road Premium Parking" },
        { id: 9, name: "Slot I9", loc: "Wholesale Anaj Mandi Lot" },
        { id: 10, name: "Slot J10", loc: "Galaxy Mall Grid" },
        { id: 11, name: "Slot K11", loc: "Hartron Skill Hub Complex" },
        { id: 12, name: "Slot L12", loc: "War Heroes Stadium Yard" },
        { id: 13, name: "Slot M13", loc: "Cloth Market Premium Hub" },
        { id: 14, name: "Slot N14", loc: "Polytechnic College Line" },
        { id: 15, name: "Slot O15", loc: "Ambala Cantt Junction West" },
        { id: 16, name: "Slot P16", loc: "Prem Nagar Public Yard" },
        { id: 17, name: "Slot Q17", loc: "Model Town Central Market" },
        { id: 18, name: "Slot R18", loc: "Vividh Bharti Office Strip" },
        { id: 19, name: "Slot S19", loc: "Aggarsain Chowk Commercial" },
        { id: 20, name: "Slot T20", loc: "King Fisher Resort Annex" }
    ];

    // 2. Fetching booked reservation slots dictionary from PHP backend
    const databaseBookedMap = <?php echo json_encode($booked_slots); ?>;
    
    let baseTrackIndex = 0;

    function renderRotatorPanel() {
        for (let i = 0; i < 3; i++) {
            // Loop round items array safely inside bounds
            let targetItemIndex = (baseTrackIndex + i) % allParkingLocations.length;
            let targetSlot = allParkingLocations[targetItemIndex];
            
            let boxElement = document.getElementById(`aiBox${i}`);
            if(!boxElement) continue;

            // Check dynamic booking inside map registry
            let isOccupied = databaseBookedMap.hasOwnProperty(targetSlot.id);
            let driverName = isOccupied ? databaseBookedMap[targetSlot.id] : "";

            // Add flip rotation visual animation class trigger
            boxElement.classList.add('rotate-effect');

            // Insert matching text status context
            setTimeout(() => {
                if (isOccupied) {
                    boxElement.innerHTML = `
                        <h3>${targetSlot.name}</h3>
                        <div class="slot-loc">📍 ${targetSlot.loc}</div>
                        <p class="text-red"><span class="status-dot red"></span> Occupied</p>
                        <div style="font-size:11px; margin-top:5px; color:#ef4444; font-weight:bold;">👤 By: ${driverName}</div>
                    `;
                } else {
                    boxElement.innerHTML = `
                        <h3>${targetSlot.name}</h3>
                        <div class="slot-loc">📍 ${targetSlot.loc}</div>
                        <p class="text-green"><span class="status-dot green"></span> Available</p>
                        <div style="font-size:11px; margin-top:5px; color:#10b981; font-weight:bold;">🟢 Ready to Book</div>
                    `;
                }
            }, 300); // sync text right in the middle of card flip transition

            // Remove class so animation can be triggered again next time
            setTimeout(() => {
                boxElement.classList.remove('rotate-effect');
            }, 600);
        }

        // Shift next slots step index window ahead
        baseTrackIndex = (baseTrackIndex + 3) % allParkingLocations.length;
    }

    // Run first step and set interval loop execution for every 4 seconds
    document.addEventListener("DOMContentLoaded", () => {
        renderRotatorPanel();
        setInterval(renderRotatorPanel, 4000);
    });
    </script>
</body>
</html>
