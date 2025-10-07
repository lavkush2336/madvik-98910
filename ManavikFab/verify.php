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
    <title>ManavikFab OTP Verification</title>
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
        .verify-container {
            padding: 1.5rem;
            width: 100%;
            max-width: 520px;
        }
        .verify-card {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.15);
            padding: 2.5rem;
            width: 100%;
            transition: transform 0.3s ease;
        }
        .verify-card:hover {
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
            margin-bottom: 1.5rem;
        }
        .alert-message {
            background-color: #f8c9d8;
            color: #2d2d2d;
            font-size: 0.95rem;
            text-align: center;
            padding: 0.85rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .alert-message .bi-exclamation-circle {
            font-size: 1rem;
            color: #2d2d2d;
        }
        .form-label {
            font-size: 0.95rem;
            font-weight: 500;
            color: #2d2d2d;
            margin-bottom: 0.5rem;
        }
        .otp-input-container {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-bottom: 0.5rem;
        }
        .otp-input {
            width: 2.5rem;
            height: 2.5rem;
            text-align: center;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            font-size: 1rem;
            color: #2d2d2d;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .otp-input:focus {
            border-color: #f8c9d8;
            box-shadow: 0 0 0 0.2rem rgba(248, 201, 216, 0.3);
        }
        .btn-signup {
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
        .btn-signup:hover {
            background-color: #f4b6cc;
            transform: scale(1.02);
        }
        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            font-weight: 400;
            margin-top: 0.5rem;
            display: none;
            text-align: center;
        }
        @media (max-width: 576px) {
            .verify-container {
                padding: 1rem;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .verify-card {
                padding: 1.75rem;
                max-width: 90%;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            }
            .verify-card:hover {
                transform: translateY(0);
            }
            .logo-text {
                font-size: 1.75rem;
            }
            .tagline {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }
            .alert-message {
                font-size: 0.85rem;
                padding: 0.65rem;
                gap: 0.3rem;
            }
            .alert-message .bi-exclamation-circle {
                font-size: 0.9rem;
            }
            .form-label {
                font-size: 0.85rem;
            }
            .otp-input-container {
                gap: 0.3rem;
            }
            .otp-input {
                width: 2rem;
                height: 2rem;
                font-size: 0.9rem;
            }
            .btn-signup {
                padding: 0.65rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="verify-card">
            <div class="logo-text">ManavikFab</div>
            <div class="tagline">"Wear a Style That You Love."</div>
            <div class="alert-message">
                <i class="bi bi-exclamation-circle"></i>
                OTP sent to the EmailID and Password
            </div>
            <form id="verify-form" method="POST" onsubmit="return validateForm(event)">
                <div class="mb-3">
                    <label for="email-otp" class="form-label">Enter OTP sent to EmailID</label>
                    <div class="otp-input-container">
                        <input type="text" class="otp-input email-otp" maxlength="1" required name="e1">
                        <input type="text" class="otp-input email-otp" maxlength="1" required name="e2">
                        <input type="text" class="otp-input email-otp" maxlength="1" required name="e3">
                        <input type="text" class="otp-input email-otp" maxlength="1" required name="e4">
                        <input type="text" class="otp-input email-otp" maxlength="1" required name="e5">
                        <input type="text" class="otp-input email-otp" maxlength="1" required name="e6">
                    </div>
                    <input type="hidden" name="email_otp" id="email_otp">
                    <div id="email-otp-error" class="error-message">Please enter a valid 6-digit OTP.</div>
                </div>
                <div class="mb-3">
                    <label for="phone-otp" class="form-label">Enter OTP sent to Phone Number</label>
                    <div class="otp-input-container">
                        <input type="text" class="otp-input phone-otp" maxlength="1" required name="p1">
                        <input type="text" class="otp-input phone-otp" maxlength="1" required name="p2">
                        <input type="text" class="otp-input phone-otp" maxlength="1" required name="p3">
                        <input type="text" class="otp-input phone-otp" maxlength="1" required name="p4">
                        <input type="text" class="otp-input phone-otp" maxlength="1" required name="p5">
                        <input type="text" class="otp-input phone-otp" maxlength="1" required name="p6">
                    </div>
                    <input type="hidden" name="phone_otp" id="phone_otp">
                    <div id="phone-otp-error" class="error-message">Please enter a valid 6-digit OTP.</div>
                </div>
                <button type="submit" class="btn-signup" name="sign">Sign Up</button>
            </form>
            <?PHP
                if (isset($_POST['sign'])) {
    $eotp = $_POST['email_otp'];
    $potp = $_POST['phone_otp'];

    if ($eotp == $_SESSION['eotp'] && $potp == $_SESSION['potp']) {
        $sql = "UPDATE `User` SET `Verified` = '1' WHERE `eotp` = ? AND `potp` = ? AND `Verified` = '0'";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $eotp, $potp);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Clear session OTPs
            unset($_SESSION['eotp']);
            unset($_SESSION['potp']);
            echo "<script>alert('Registeration Successfull, Kindly LogIn!')</script>";
            echo "<script>window.open('login.php','_self')</script>";
        } else {
            echo "<div class='alert alert-danger mt-4' role='alert'>
  Invalid OTP(s), Please Try Again!
</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger mt-4' role='alert'>
  Invalid OTP(s), Please Try Again!
</div>";
    }
}
            ?>
        </div>
    </div>

    <script>
        // Auto-focus for OTP inputs
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });
            // Restrict input to numbers only
            input.addEventListener('input', () => {
                input.value = input.value.replace(/[^0-9]/g, '');
            });
        });

        function validateForm(event) {
            // Reset error messages
            document.querySelectorAll('.error-message').forEach(error => error.style.display = 'none');

            let isValid = true;

            // Email OTP validation
            const emailOtpInputs = document.querySelectorAll('.email-otp');
            const emailOtp = Array.from(emailOtpInputs).map(input => input.value).join('');
            const otpPattern = /^[0-9]{6}$/;
            if (!otpPattern.test(emailOtp)) {
                document.getElementById('email-otp-error').style.display = 'block';
                isValid = false;
            }

            // Phone OTP validation
            const phoneOtpInputs = document.querySelectorAll('.phone-otp');
            const phoneOtp = Array.from(phoneOtpInputs).map(input => input.value).join('');
            if (!otpPattern.test(phoneOtp)) {
                document.getElementById('phone-otp-error').style.display = 'block';
                isValid = false;
            }

            // Set hidden inputs for PHP
            if (isValid) {
                document.getElementById('email_otp').value = emailOtp;
                document.getElementById('phone_otp').value = phoneOtp;
            }

            return isValid;
        }
    </script>
</body>
</html>
<?PHP
mysqli_close($con);
?>