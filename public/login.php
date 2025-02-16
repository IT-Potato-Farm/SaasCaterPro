<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/output.css">
    <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
    <script src="sweetalert/jqueryv3.7.1.min.js"></script>
    <script src="sweetalert/sweetalert2.all.min.js"></script>
</head>
<body class="bg-[#0F0F0F]">
    <main class="h-screen flex items-center justify-center">
        <div class="bg-[#1F1F1F] bg-opacity-80 shadow-xl backdrop-blur-lg rounded-2xl p-8 w-96 border border-gray-700">
            <h2 class="text-center text-white text-2xl font-semibold">Login</h2>
            
            <form id="logform" class="space-y-5 mt-5">
                <input id="email" name="email" type="text" placeholder="Email" class="w-full p-3 bg-[#2B2B2B] text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-400 focus:outline-none" >
                <div class="relative">
                    <input id="password" name="password" type="password" placeholder="Password" class="w-full p-3 bg-[#2B2B2B] text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-400 focus:outline-none" >
                    <i id="togglePassword" class="fas fa-eye-slash text-gray-400 absolute top-4 right-3 cursor-pointer"></i>

                </div>
                
                <button id="loginBtn" type="submit" class="text-white w-full bg-gray-700 px-5 py-3 rounded-lg text-lg font-semibold hover:bg-gray-600 hover:cursor-pointer transition relative duration-200 ">
                    Log in 
                </button>
                <div class="text-center text-gray-400 text-sm mt-2">
                    Don't have an account? 
                    <a href="register.php" class="text-white font-semibold hover:underline hover:text-cyan-300 duration-300">Sign up here</a>
                </div>
            </form>
        </div>
    </main>

    <script>
        const logform = document.getElementById("logform");
        const loginBtn = document.getElementById("loginBtn");
        const emailField = document.getElementById("email");
        const passwordField = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");
        
        logform.addEventListener("submit", async function (e) {
            e.preventDefault(); // Prevent form from submitting immediately

            const email = emailField.value.trim();
            const password = passwordField.value.trim();
            
            // Validate input
            if (email === "" && password === "") {
                Swal.fire({
                    icon: "error",
                    title: "Missing Fields",
                    text: "All fields are required!",
                    confirmButtonColor: "#d33"
                });
                return;
            }

            if(email ===""){
                Swal.fire({
                    icon: "error",
                    title: "Missing Email",
                    text: "Pls input an email",
                    confirmButtonColor: "#d33"
                });
                return;
            }
            if(password ===""){
                Swal.fire({
                    icon: "error",
                    title: "Missing Password",
                    text: "Pls input a password",
                    confirmButtonColor: "#d33"
                });
                return;
            }
            
            

            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Email",
                    text: "Please enter a valid email address!",
                    confirmButtonColor: "#d33"
                });
                return;
            }

            // Prepare data for API call
            const userData = {
                email: email,
                password: password
            };

            try {
                const response = await fetch("../api/login_api.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(userData)
                });

                const result = await response.json();

                if (response.ok) {
                    const userRole = result.user.role;
                    
                    Swal.fire({
                        icon: "success",
                        title: "Login Successful!",
                        text: "Redirecting...",
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        // punta sa certain page based sa role 
                        if (userRole === "admin") {
                            window.location.href = "dashboard.php";
                        } else {
                            window.location.href = "index.php";
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Login Failed",
                        text: result.message,
                        confirmButtonColor: "#d33"
                    });
                }
            } catch (error) {
                console.error("Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Unexpected Error",
                    text: "An unexpected error occurred. Please try again later.",
                    confirmButtonColor: "#d33"
                });
            }
        });
        togglePassword.addEventListener("click", function () {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                togglePassword.classList.remove("fa-eye-slash");
                togglePassword.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                togglePassword.classList.remove("fa-eye");
                togglePassword.classList.add("fa-eye-slash");
            }
        });
    </script>
</body>
</html>