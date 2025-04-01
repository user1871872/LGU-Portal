<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 56px; /* Adjust if navbar exists */
            left: -250px; /* Hidden by default on mobile */
            background: #343a40;
            color: white;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            transition: left 0.3s ease-in-out;
            z-index: 1050;
        }

        /* Show Sidebar on mobile */
        .sidebar.show {
            left: 0;
        }

        /* Always visible on desktop */
        @media (min-width: 768px) {
            .sidebar {
                left: 0;
            }
        }

        /* Hide toggle button on desktop */
        @media (min-width: 768px) {
            .sidebar-toggle {
                display: none;
            }
        }

        /* Background overlay (only for mobile) */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1049;
        }

        .overlay.show {
            display: block;
        }

        /* Sidebar Links */
        .sidebar .nav-link {
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            font-weight: bold;
        }

        /* User Info */
        .sidebar-footer {
            margin-top: auto;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Main content adjustment */
        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease-in-out;
        }

        @media (min-width: 768px) {
            .main-content {
                margin-left: 250px; /* Adjust for sidebar */
            }
        }

    </style>
</head>
<body class="bg-light">



    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white" id="sidebar">
    <div class="sidebar-sticky py-3 text-center">
        <img src="{{ asset('images/logo.jpg') }}" alt="LGU Anda" class="mb-3 rounded-circle" width="80">
    </div>
   
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.dashboard') }}" data-link="dashboard">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('apply-permit') }}" data-link="apply-permit">
                    <i class="bi bi-file-earmark"></i> Apply Permit
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.transactions') }}" data-link="transactions">
                    <i class="bi bi-receipt"></i> Transactions
                </a>
            </li>
        </ul>
    </div>

    <!-- Background overlay for mobile -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>



    <!-- JavaScript for Sidebar Toggle -->
    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            let overlay = document.getElementById("overlay");
            let mainContent = document.getElementById("main-content");
            let toggleButton = document.querySelector(".sidebar-toggle i");

            sidebar.classList.toggle("show");
            overlay.classList.toggle("show");

            // Shift content only on mobile
            if (window.innerWidth < 768) {
                if (sidebar.classList.contains("show")) {
                    mainContent.style.marginLeft = "250px";
                } else {
                    mainContent.style.marginLeft = "0";
                }
            }

            // Change toggle icon
            if (sidebar.classList.contains("show")) {
                toggleButton.classList.replace("bi-list", "bi-x-lg");
            } else {
                toggleButton.classList.replace("bi-x-lg", "bi-list");
            }
        }

        // Function to highlight active sidebar link
        function setActiveLink() {
            const links = document.querySelectorAll(".sidebar .nav-link");
            const activePage = localStorage.getItem("activeSidebarLink");

            links.forEach(link => {
                link.classList.remove("active");
                if (link.getAttribute("data-link") === activePage) {
                    link.classList.add("active");
                }

                link.addEventListener("click", function () {
                    localStorage.setItem("activeSidebarLink", link.getAttribute("data-link"));
                });
            });
        }

        document.addEventListener("DOMContentLoaded", setActiveLink);
    </script>

</body>
</html>
