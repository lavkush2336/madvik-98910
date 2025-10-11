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
        /* Split-screen login styles inspired by reference image */
        :root{
            --pink-500: #f4b6cc;
            --pink-600: #f8c9d8;
            --pink-700: #ffb0d2;
            --muted: #6b7280;
            --text: #111827;
        }
        html,body{height:100%;margin:0;font-family:'Poppins',sans-serif;-webkit-font-smoothing:antialiased}
        body{background:linear-gradient(135deg,var(--pink-600) 0%,var(--pink-500) 100%);}

        .login-container{min-height:100vh;display:flex;align-items:stretch}
        .split{display:flex;width:100%;min-height:100vh}

        /* Left visual column */
        .visual{flex:1;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;padding:3rem;background:linear-gradient(180deg,var(--pink-600),var(--pink-500))}
        .visual .panel{position:relative;z-index:3;color:rgba(17,24,39,0.95);max-width:520px}
        .visual h2{font-size:2.4rem;margin:0 0 .5rem;color:rgba(122,19,48,0.98);font-weight:800}
        .visual p{margin:0;color:rgba(91,42,58,0.9)}
        /* Decorative shapes */
        .visual .shape-1{position:absolute;right:-12%;top:-8%;width:520px;height:520px;border-radius:40% 60% 40% 60%;background:radial-gradient(circle at 30% 30%,rgba(255,255,255,0.12),transparent 40%),linear-gradient(135deg,rgba(255,255,255,0.06),rgba(255,255,255,0));filter:blur(18px);transform:rotate(12deg);animation:float 8s ease-in-out infinite}
        .visual .shape-2{position:absolute;left:-10%;bottom:-8%;width:360px;height:360px;border-radius:50%;background:linear-gradient(135deg,rgba(255,255,255,0.05),transparent);filter:blur(8px);opacity:.9}
        .visual .grid-lines{position:absolute;inset:18px;background-image:linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px);background-size:60px 60px;opacity:.5;pointer-events:none}
        @keyframes float{0%{transform:translateY(0) rotate(12deg)}50%{transform:translateY(-12px) rotate(14deg)}100%{transform:translateY(0) rotate(12deg)}}

        /* Right column (form) */
        .right{flex:0 0 520px;display:flex;align-items:center;justify-content:center;padding:4rem}
        .login-card{background:#fff;border-radius:12px;box-shadow:0 18px 40px rgba(0,0,0,0.08);padding:2.5rem;width:100%;max-width:420px;border:1px solid rgba(0,0,0,0.04)}
        .logo-text{font-size:2.6rem;font-weight:800;color:var(--text);text-align:center;margin-bottom:.25rem}
        .tagline{font-size:1rem;color:var(--muted);text-align:center;margin-bottom:1.5rem;font-weight:300}

        .input-group{position:relative;margin-bottom:1.4rem}
        .form-control{border-radius:.75rem;border:1px solid #e6e6e6;padding:1rem 1rem 1rem 3.5rem;font-size:1rem;background:#fff;transition:all .22s ease;box-shadow:inset 0 2px 4px rgba(0,0,0,0.04);width:100%;box-sizing:border-box}
        .form-control:focus{border-color:var(--pink-600);box-shadow:0 0 0 .22rem rgba(244,182,204,0.18);outline:none}
        .form-label{position:absolute;top:1rem;left:3.5rem;font-size:1rem;color:var(--muted);transition:all .18s ease;pointer-events:none}
        .form-control:focus + .form-label,.form-control:not(:placeholder-shown) + .form-label{top:-.6rem;left:1.5rem;font-size:.78rem;color:var(--pink-600);background:#fff;padding:0 .3rem}
        .input-icon{position:absolute;top:50%;left:1.1rem;transform:translateY(-50%);color:#a0a0a0;width:20px;height:20px}

        .btn-login{background:linear-gradient(90deg,var(--pink-600),var(--pink-500));color:var(--text);border:none;padding:.95rem;border-radius:.75rem;font-weight:700;font-size:1.05rem;transition:transform .22s ease,box-shadow .22s ease;width:100%;box-shadow:0 10px 30px rgba(244,182,204,0.18)}
        .btn-login:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(244,182,204,0.22)}

        .signup-section{margin-top:1rem;text-align:center;display:flex;justify-content:center;align-items:center;gap:.5rem;color:var(--muted)}
        .btn-signup{background:var(--pink-600);color:var(--text);border:0;padding:.5rem .9rem;border-radius:.6rem;font-weight:600}
        .btn-signup:hover{background:var(--pink-500);transform:scale(1.03)}

        .error-message{display:none;color:#dc3545;font-size:.85rem;margin-top:.4rem}

        @media(max-width:991px){.split{flex-direction:column}.visual{flex:0 0 220px;height:220px;padding:1.25rem}.right{flex:1 1 auto;padding:2rem}.login-card{margin:0 auto}}
    </style>
</head>
<body>
    <div class="login-container">
        <div class="split">
            <div class="visual">
                <div class="shape-1" aria-hidden="true"></div>
                <div class="shape-2" aria-hidden="true"></div>
                <div class="grid-lines" aria-hidden="true"></div>
                <div class="panel">
                    <h2>ManavikFab</h2>
                    <p>Timeless designs, crafted for you. Discover handcrafted elegance and contemporary silhouettes.</p>
                </div>
            </div>
            <div class="right">
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
                                    echo "<div class='alert alert-danger mt-4' role='alert'>\n  Invalid Password!\n</div>";
                                }
                            }
                            else
                            {
                                echo "<div class='alert alert-danger mt-4' role='alert'>\n  User not Found!\n</div>";
                            }
                        }
                    ?>
                </div>
            </div>
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