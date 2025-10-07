<?PHP
session_start();
include 'connection.php';

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManavikFab User Signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts (Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f8c9d8;
            font-family: 'Roboto', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .signup-container {
            padding: 1.5rem;
            width: 100%;
            max-width: 520px;
        }
        .signup-card {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.15);
            padding: 2.5rem;
            width: 100%;
            transition: transform 0.3s ease;
        }
        .signup-card:hover {
            transform: translateY(-5px);
        }
        .logo-text {
            font-size: 2.25rem;
            font-weight: 700;
            color: #2d2d2d;
            text-align: center;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }
        .tagline {
            font-size: 1rem;
            font-weight: 300;
            color: #6b7280;
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-label {
            font-size: 0.95rem;
            font-weight: 500;
            color: #2d2d2d;
            margin-bottom: 0.5rem;
        }
        .form-label .info-icon {
            margin-left: 0.5rem;
            cursor: pointer;
            color: #4b5563;
            font-size: 1rem;
            transition: color 0.3s ease, transform 0.3s ease;
        }
        .form-label .info-icon:hover {
            color: #f4b6cc;
            transform: scale(1.2);
        }
        .form-control {
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: #2d2d2d;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #f8c9d8;
            box-shadow: 0 0 0 0.2rem rgba(248, 201, 216, 0.3);
            outline: none;
        }
        .form-control::placeholder {
            color: #9ca3af;
            font-weight: 300;
        }
        .btn-verify {
            background-color: #f8c9d8;
            color: #2d2d2d;
            border: none;
            padding: 0.85rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
            width: 100%;
        }
        .btn-verify:hover {
            background-color: #f4b6cc;
            transform: scale(1.02);
        }
        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            font-weight: 400;
            margin-top: 0.5rem;
            display: none;
        }
        .login-text {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.95rem;
            font-weight: 400;
            color: #4b5563;
        }
        .btn-login {
            background-color: #f8c9d8;
            color: #2d2d2d;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-left: 0.75rem;
        }
        .btn-login:hover {
            background-color: #f4b6cc;
            transform: scale(1.05);
        }
        .dialogue-box {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.95);
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 90%;
            max-width: 420px;
            max-height: calc(100vh - 3rem);
            overflow-y: auto;
            padding: 1.75rem;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .dialogue-box.active {
            display: block;
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
        .dialogue-header {
            background-color: #f8c9d8;
            padding: 0.85rem;
            border-radius: 0.75rem 0.75rem 0 0;
            margin: -1.75rem -1.75rem 1.25rem -1.75rem;
        }
        .dialogue-header h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d2d2d;
            text-align: center;
        }
        .dialogue-content {
            font-size: 0.95rem;
            font-weight: 400;
            color: #4b5563;
            line-height: 1.6;
        }
        .dialogue-content ul {
            padding-left: 1.5rem;
            margin: 0;
        }
        .btn-close-dialogue {
            display: block;
            margin: 1.25rem auto 0;
            background-color: #f8c9d8;
            color: #2d2d2d;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-close-dialogue:hover {
            background-color: #f4b6cc;
            transform: scale(1.05);
        }
        .dialogue-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            z-index: 999;
            transition: opacity 0.3s ease;
        }
        .dialogue-overlay.active {
            display: block;
            opacity: 1;
        }
        @media (max-width: 576px) {
            .signup-container {
                padding: 1rem;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .signup-card {
                padding: 1.75rem;
                max-width: 90%;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            }
            .signup-card:hover {
                transform: translateY(0); /* Disable hover effect on small screens */
            }
            .logo-text {
                font-size: 1.75rem;
            }
            .tagline {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }
            .form-label {
                font-size: 0.85rem;
            }
            .form-label .info-icon {
                font-size: 0.9rem;
            }
            .form-control {
                padding: 0.65rem 0.85rem;
                font-size: 0.85rem;
            }
            .btn-verify {
                padding: 0.65rem;
                font-size: 0.9rem;
            }
            .error-message {
                font-size: 0.75rem;
            }
            .login-text {
                font-size: 0.85rem;
                margin-top: 1.5rem;
            }
            .btn-login {
                padding: 0.4rem 1rem;
                font-size: 0.85rem;
            }
            .dialogue-box {
                width: 90%;
                max-width: 320px;
                padding: 1.25rem;
                max-height: calc(80vh - 2rem);
            }
            .dialogue-header {
                padding: 0.65rem;
                margin: -1.25rem -1.25rem 0.85rem -1.25rem;
            }
            .dialogue-header h3 {
                font-size: 1.1rem;
            }
            .dialogue-content {
                font-size: 0.85rem;
            }
            .dialogue-content ul {
                padding-left: 1rem;
            }
            .btn-close-dialogue {
                padding: 0.4rem 1rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-card">
            <div class="logo-text">ManavikFab</div>
            <div class="tagline">"Wear a Style That You Love."</div>
            <form id="signup-form" method="POST" onsubmit="return validateForm(event)">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter your name" required name="name">
                    <div id="name-error" class="error-message">Name is required.</div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required name="email">
                    <div id="email-error" class="error-message">Please enter a valid email address.</div>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" pattern="[0-9]{10}" required name="num">
                    <div id="phone-error" class="error-message">Please enter a valid 10-digit phone number.</div>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" max="2020-06-12" required name="dob">
                    <div id="dob-error" class="error-message">You must be at least 5 years old.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">
                        Password
                        <i class="bi bi-info-circle info-icon" onclick="showPasswordPattern()"></i>
                    </label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" 
                           pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$" required name="pass">
                    <div id="password-error" class="error-message">Password must be at least 8 characters long and include an uppercase letter, lowercase letter, number, and special character (e.g., !@#$%^&*).</div>
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" placeholder="Confirm your password" required>
                    <div id="confirm-password-error" class="error-message">Passwords do not match.</div>
                </div>
                <button type="submit" class="btn-verify" name="verify">Verify</button>
            </form>
            <?PHP
            if (isset($_POST['verify'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['num']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $pass = $_POST['pass'];

    $hpass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM `User` WHERE `Email` = ? OR `Phone` = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_num_rows($result);
    mysqli_stmt_close($stmt);

    if ($rows > 0) {
        echo "<div class='alert alert-danger mt-4' role='alert'>
  Email ID or Phone Number already exists!
</div>";
    } else {
        $potp = rand(100000, 999999);
        $eotp = rand(100000, 999999);
        $_SESSION['potp'] = $potp;
        $_SESSION['eotp'] = $eotp;
        
        $sql = "INSERT INTO `User` (`Name`, `Email`, `Phone`, `DOB`, `Password`, `Verified`, `eotp`, `potp`) VALUES (?, ?, ?, ?, ?, '0', ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $phone, $dob, $hpass, $eotp, $potp);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header("Location: verify.php");
            exit();
        } else {
            echo "<div class='alert alert-danger mt-4' role='alert'>
  Failed to register user. Please try again.
</div>";
        }
        mysqli_stmt_close($stmt);
    }
}
            ?>
            <div class="login-text">
                Already have an account?
                <a href="login.php" class="btn-login">Login</a>
            </div>
        </div>
    </div>

    <!-- Dialogue Box for Password Pattern -->
    <div class="dialogue-overlay" id="dialogue-overlay"></div>
    <div class="dialogue-box" id="password-pattern-dialogue">
        <div class="dialogue-header">
            <h3>Password Requirements</h3>
        </div>
        <div class="dialogue-content">
            Your password must:
            <ul>
                <li>Be at least 8 characters long</li>
                <li>Include at least one uppercase letter (A-Z)</li>
                <li>Include at least one lowercase letter (a-z)</li>
                <li>Include at least one number (0-9)</li>
                <li>Include at least one special character (e.g., !@#$%^&*)</li>
            </ul>
        </div>
        <button class="btn-close-dialogue" onclick="hidePasswordPattern()">Close</button>
    </div>

    <script>
        function validateForm(event) {
            // Reset error messages
            document.querySelectorAll('.error-message').forEach(error => error.style.display = 'none');

            let isValid = true;

            // Name validation
            const name = document.getElementById('name').value.trim();
            if (!name) {
                document.getElementById('name-error').style.display = 'block';
                isValid = false;
            }

            // Email validation
            const email = document.getElementById('email').value.trim();
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('email-error').style.display = 'block';
                isValid = false;
            }

            // Phone validation
            const phone = document.getElementById('phone').value.trim();
            const phonePattern = /^[0-9]{10}$/;
            if (!phonePattern.test(phone)) {
                document.getElementById('phone-error').style.display = 'block';
                isValid = false;
            }

            // DOB validation
            const dob = document.getElementById('dob').value;
            const dobDate = new Date(dob);
            const maxDate = new Date('2020-06-12');
            if (!dob || dobDate > maxDate) {
                document.getElementById('dob-error').style.display = 'block';
                isValid = false;
            }

            // Password validation
            const password = document.getElementById('password').value;
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
            if (!passwordPattern.test(password)) {
                document.getElementById('password-error').style.display = 'block';
                isValid = false;
            }

            // Confirm Password validation
            const confirmPassword = document.getElementById('confirm-password').value;
            if (confirmPassword !== password) {
                document.getElementById('confirm-password-error').style.display = 'block';
                isValid = false;
            }

            return isValid;
        }

        function showPasswordPattern() {
            document.getElementById('password-pattern-dialogue').classList.add('active');
            document.getElementById('dialogue-overlay').classList.add('active');
        }

        function hidePasswordPattern() {
            document.getElementById('password-pattern-dialogue').classList.remove('active');
            document.getElementById('dialogue-overlay').classList.remove('active');
        }
    </script>
</body>
</html>
<?PHP
mysqli_close($con);
?>