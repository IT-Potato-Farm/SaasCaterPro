<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="assets/css/output.css">
    <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
    <script src="sweetalert/jqueryv3.7.1.min.js"></script>
    <script src="sweetalert/sweetalert2.all.min.js"></script>
    <script>
        async function registerUser(event) {
            event.preventDefault();
            try {
                let form = document.forms["registerForm"];


                const requiredFields = [
                    "first_name",
                    "last_name",
                    "email",
                    "mobile",
                    "password",
                    "confirm_password"
                ];

                let missingFields = [];

                for (const field of requiredFields) {
                    if (form[field].value.trim() === "") {
                        missingFields.push(field);
                    }
                }
                
                // If there are missing fields, show an alert
                if (missingFields.length > 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Missing Fields",
                        text: `The following fields are required: ${missingFields.join(", ")}`,
                        confirmButtonColor: "#d33"
                    });
                    return; // Stop if there are missing fields
                }

                //email validate
                const emailField = form["email"];
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                if (!emailPattern.test(emailField.value.trim())) {
                    Swal.fire({
                        icon: "error",
                        title: "Invalid Email",
                        text: "Please enter a valid email address!",
                        confirmButtonColor: "#d33"
                    });
                    return; // Stop if email invalid
                }

                const passwordField = form["password"];
                const confirmPasswordField = form["confirm_password"];

                if (passwordField.value.length < 8 ||
                    !/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/.test(passwordField.value)) {
                    Swal.fire({
                        icon: "error",
                        title: "Invalid Password",
                        text: "Password must contain at least one number, one uppercase letter, one lowercase letter, and be at least 8 characters long.",
                        confirmButtonColor: "#d33"
                    });
                    return; // Stop if password is invalid
                }

                if (passwordField.value !== confirmPasswordField.value) {
                    Swal.fire({
                        icon: "error",
                        title: "Password Mismatch",
                        text: "Passwords do not match!",
                        confirmButtonColor: "#d33"
                    });
                    return; // Stop if passwords do not match
                }

                const mobileField = form["mobile"];
                const mobilePattern = /^[0-9]{11}$/;
                if (!mobilePattern.test(mobileField.value.trim())) {
                    Swal.fire({
                        icon: "error",
                        title: "Invalid Phone Number",
                        text: "Phone number must be exactly 11 digits.",
                        confirmButtonColor: "#d33"
                    });
                    return; // Stop if phone number is invalid
                }
                //I-PREPARE NA UNG DATA ISEND SA SERVER
                let userData = {
                    first_name: form["first_name"].value.trim(),
                    last_name: form["last_name"].value.trim(),
                    email: form["email"].value.trim(),
                    mobile: form["mobile"].value.trim(),
                    password: form["password"].value.trim(),
                    confirm_password: form["confirm_password"].value.trim()
                };
                // sending the data
                let response = await fetch("register_api.php", {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json"
                    },
                    body: JSON.stringify(userData)
                });

                let result = await response.json();
                // if success register
                if (result.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Registration Successfully",
                        text: result.message,
                        confirmButtonColor: "#3085d6"
                    }).then(() => {
                        window.location.href = "login.php";
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: result.message,
                        confirmButtonColor: "#d33"
                    });
                }
            } catch (error) {
                console.error("Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Unexpected Error",
                    text: "An unexpected error occurred.",
                    confirmButtonColor: "#d33"
                });
            }
        }
    </script>
</head>

<body class="bg-[#121212]  flex items-center justify-center">


    <div class="bg-[#1f1f1f] p-8 rounded-2xl   shadow-xl w-full max-w-lg mt-15">
        <h2 class="text-center text-white text-3xl font-semibold mb-4">Create an Account</h2>


        <form id="registrationForm" name="registerForm" onsubmit="registerUser(event)" novalidate class="space-y-5">
            <input type="text" id="firstname" name="first_name" placeholder="First Name"
                class="w-full p-4 bg-[#2A2A2A] text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

            <input type="text" id="middlename" name="middlename" placeholder="Middle Name (Optional)"
                class="w-full p-4 bg-[#2A2A2A] text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

            <input type="text" id="lastname" name="last_name" placeholder="Last Name"
                class="w-full p-4 bg-[#2A2A2A] text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

            <div class="relative">
                <input type="email" id="email" name="email" placeholder="Email"
                    class="w-full p-4 bg-[#2A2A2A] text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

            </div>

            <div class="relative">
                <input type="password" id="pw" name="password" placeholder="Password"
                    class="w-full p-4 bg-[#2A2A2A] text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <i id="togglePassword" class="fas fa-eye absolute right-3 top-5 text-gray-400 cursor-pointer" onclick="togglePasswordVisibility('pw', 'togglePassword')"></i>

            </div>

            <div class="relative">
                <input type="password" id="confirmpw" name="confirm_password" placeholder="Confirm Password"
                    class="w-full p-4 bg-[#2A2A2A] text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <i id="toggleConfirmPassword" class="fas fa-eye absolute right-3 top-5 text-gray-400 cursor-pointer" onclick="togglePasswordVisibility('confirmpw', 'toggleConfirmPassword')"></i>
            </div>

            <input type="tel" id="cpnum" name="mobile" placeholder="Phone Number"
                class="w-full p-4 bg-[#2A2A2A] text-white border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

            <button type="submit" class="w-full py-3 bg-gray-700 text-white text-lg font-semibold rounded-lg hover:bg-gray-600 hover:cursor-pointer transition">
                Register
            </button>

            <div class="text-center text-gray-400 text-sm mt-2">
                Already have an account?
                <a href="login.php" class="text-white font-semibold hover:underline hover:text-cyan-300 duration-300">Log in here</a>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>