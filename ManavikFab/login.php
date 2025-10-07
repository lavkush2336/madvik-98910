<?PHP
    session_start();
    include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManavikFab User Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8c9d8 0%, #f4b6cc 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
            position: relative;
        }
        /* Background Animation */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            animation: pulse 12s infinite;
            z-index: -1;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.25; }
            50% { transform: scale(1.15); opacity: 0.1; }
            100% { transform: scale(1); opacity: 0.25; }
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        .login-card {
            background: rgb(255, 255, 255); /* Solid white */
            border-radius: 1.5rem; /* Reduced for cleaner edges */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); /* Softer shadow */
            padding: 3rem;
            width: 100%;
            max-width: 480px;
            position: relative;
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            z-index: 10; /* Ensure above body background */
            border: 1px solid rgba(255, 255, 255, 1); /* Subtle border to define edges */
        }
        .login-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15); /* Neutral hover shadow */
        }
        /* Card Accent */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0px;
            background: linear-gradient(90deg, #f8c9d8, #f4b6cc);
            z-index: 1; /* Below card content */
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
        }
        .logo-text {
            font-size: 2.8rem;
            font-weight: 700;
            color: #000000;
            text-align: center;
            margin-bottom: 0.5rem;
            animation: fadeIn 1s ease-in;
            position: relative;
            z-index: 2; /* Above pseudo-element */
        }
        .tagline {
            font-size: 1.15rem;
            color: #4a4a4a;
            text-align: center;
            margin-bottom: 2.5rem;
            font-weight: 300;
            letter-spacing: 0.5px;
            animation: fadeIn 1.5s ease-in;
            position: relative;
            z-index: 2;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .input-group {
            position: relative;
            margin-bottom: 2rem;
        }
        /* Input Field Styling */
        .form-control {
    border-radius: 0.75rem;
    border: 1px solid #e0e0e0;
    padding: 1.2rem 1.2rem 1.2rem 3.5rem;
    font-size: 1rem;
    background: #ffffff;
    transition: all 0.3s ease;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    width: 143%; /* Default width for mobile */
    box-sizing: border-box;
    position: relative;
    z-index: 2;
}

/* Large screens: Set to 168% */
@media (min-width: 992px) {
    .form-control {
        width: 168%;
    }
}

        .form-control:focus {
            border-color: #f8c9d8;
            box-shadow: 0 0 0 0.25rem rgba(248, 201, 216, 0.3), inset 0 2px 4px rgba(0, 0, 0, 0.05);
            background: #ffffff;
            outline: none;
        }
        /* Floating Label Styling */
        .form-label {
            position: absolute;
            top: 1.2rem;
            left: 3.5rem;
            font-size: 1rem;
            color: #6b7280;
            transition: all 0.2s ease;
            pointer-events: none;
            font-weight: 400;
            z-index: 3;
        }
        .form-control:focus + .form-label,
        .form-control:not(:placeholder-shown) + .form-label {
            top: -0.6rem;
            left: 1.75rem;
            font-size: 0.8rem;
            color: #f8c9d8;
            background: #ffffff;
            padding: 0 0.3rem;
            font-weight: 500;
        }
        /* Icon Styling */
        .input-icon {
            position: absolute;
            top: 50%;
            left: 1.2rem;
            transform: translateY(-50%);
            color: #a0a0a0;
            z-index: 3;
            transition: color 0.3s ease;
            width: 20px;
            height: 20px;
        }
        .form-control:focus + .form-label + .input-icon,
        .form-control:not(:placeholder-shown) + .form-label + .input-icon {
            color: #f8c9d8;
        }
        .btn-login {
            background: linear-gradient(90deg, #f8c9d8, #f4b6cc);
            color: #2d2d2d;
            border: none;
            padding: 1.1rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1.2rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            width: 100%;
            z-index: 2;
        }
        .btn-login:hover {
            background: linear-gradient(90deg, #f4b6cc, #f8c9d8);
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(248, 201, 216, 0.5);
        }
        .btn-login::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.5s ease, height 0.5s ease;
        }
        .btn-login:hover::after {
            width: 400px;
            height: 400px;
        }
        /* Sign Up Section */
        .signup-section {
            margin-top: 1.5rem;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            color: #4a4a4a;
            font-weight: 400;
            animation: fadeIn 1.8s ease-in;
            position: relative;
            z-index: 2;
        }
        .btn-signup {
            background: #f8c9d8;
            color: #2d2d2d;
            border: 2px solid #f4b6cc;
            padding: 0.6rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-signup:hover {
            background: #f4b6cc;
            border-color: #f4b6cc;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(248, 201, 216, 0.4);
        }
        .btn-signup::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.5s ease, height 0.5s ease;
        }
        .btn-signup:hover::after {
            width: 200px;
            height: 200px;
        }
        .error-message {
            display: none;
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 300;
            animation: fadeInError 0.3s ease;
            position: relative;
            z-index: 2;
        }
        @keyframes fadeInError {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        /* Responsive Design */
        @media (max-width: 576px) {
            .login-card {
                padding: 2rem;
                max-width: 90%;
                border-radius: 1.2rem;
            }
            .logo-text {
                font-size: 2.2rem;
            }
            .tagline {
                font-size: 1rem;
            }
            .btn-login {
                font-size: 1.1rem;
                padding: 1rem;
            }
            .form-control {
                font-size: 0.95rem;
                padding: 1.1rem 1.1rem 1.1rem 3.25rem;
            }
            .form-label {
                font-size: 0.95rem;
                left: 3.25rem;
            }
            .form-control:focus + .form-label,
            .form-control:not(:placeholder-shown) + .form-label {
                font-size: 0.75rem;
                left: 1.5rem;
            }
            .input-icon {
                left: 1.1rem;
                width: 18px;
                height: 18px;
            }
            .signup-section {
                font-size: 0.9rem;
                flex-direction: column;
                gap: 0.75rem;
            }
            .btn-signup {
                font-size: 0.9rem;
                padding: 0.5rem 1.25rem;
            }
        }
        @media (min-width: 1200px) {
            .login-card {
                max-width: 520px;
                padding: 3.5rem;
            }
            .logo-text {
                font-size: 3rem;
            }
            .signup-section {
                font-size: 1rem;
            }
            .btn-signup {
                font-size: 1rem;
                padding: 0.7rem 1.75rem;
            }
        }
        /* Animation for Form Elements */
        .input-group, .signup-section {
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-text">ManavikFab</div>
            <div class="tagline">"Wear a Style That You Love."</div>
            <form id="loginForm" method="POST">
                <div class="input-group">
                    <div class="relative">
                        <input type="email" id="email" class="form-control" placeholder=" " required name="email">
                        <label for="email" class="form-label">Email Address</label>
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-6.757 4.062L1 5.383V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5.383Z"/>
                            </svg>
                        </span>
                    </div>
                    <div id="email-error" class="error-message"></div>
                </div>
                <div class="input-group">
                    <div class="relative">
                        <input type="password" id="password" class="form-control" placeholder=" " required name="pass">
                        <label for="password" class="form-label">Password</label>
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                            </svg>
                        </span>
                    </div>
                    <div id="password-error" class="error-message"></div>
                </div>
                <button type="submit" class="btn-login" name="log">Login</button>
                <div class="signup-section">
                    <span>Don't have an Account?</span>
                    <a href="signup.php"><button type="button" class="btn-signup">Sign Up</button></a>
                </div>
            </form>
            <?PHP
                if(isset($_POST['log']))
                {
                    $email=$_POST['email'];
                    $pass=$_POST['pass'];
                    $sql="SELECT * FROM `User` WHERE `Email`='$email'";
                    $result=mysqli_query($con,$sql);
                    $rows=mysqli_num_rows($result);
                    if($rows>0)
                    {
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $hpass=$row['Password'];
                            $id=$row['UserID'];
                            $name=$row['Name'];
                        }
                        if(password_verify($pass, $hpass))
                        {
                            $_SESSION['userid']=$id;
                            $_SESSION['name']=$name;
                            $_SESSION['email']=$email;
                            echo "<script>window.open('index.php','_self')</script>";
                        }
                        else
                        {
                            echo "<div class='alert alert-danger mt-4' role='alert'>
  Invalid Password!
</div>";
                        }
                    }
                    else
                    {
                        echo "<div class='alert alert-danger mt-4' role='alert'>
  User not Found!
</div>";
                    }
                }
            ?>
        </div>
    </div>
    <script>
        // function validateForm(event) {
        //     event.preventDefault();
        //     const email = document.getElementById('email').value;
        //     const password = document.getElementById('password').value;
        //     const emailError = document.getElementById('email-error');
        //     const passwordError = document.getElementById('password-error');
        //     let isValid = true;

        //     // Reset error messages
        //     emailError.style.display = 'none';
        //     emailError.textContent = '';
        //     passwordError.style.display = 'none';
        //     passwordError.textContent = '';

        //     // Email validation
        //     const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        //     if (!emailRegex.test(email)) {
        //         emailError.textContent = 'Please enter a valid email address';
        //         emailError.style.display = 'block';
        //         isValid = false;
        //     }

        //     // Password validation
        //     if (password.length < 6) {
        //         passwordError.textContent = 'Password must be at least 6 characters long';
        //         passwordError.style.display = 'block';
        //         isValid = false;
        //     }

        //     if (isValid) {
        //         alert('Login successful! Redirecting...');
        //         // window.location.href = '/dashboard'; // Replace with actual redirect
        //     }

        //     return isValid;
        // }
    </script>