<?PHP
    session_start();
    include '../connection.php';
    //$pass='Sikandar@int11';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManavikFab Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS (kept for utility classes) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root{
            --pink-100: #f8c9d8;
            --pink-200: #f4b6cc;
            --accent-1: #eaaec0;
            --panel-radius: 16px;
        }
        html,body{height:100%;}
        body {
            margin:0;
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(180deg,#efe6ee 0%, #f8f0f5 100%);
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:2rem;
        }

        /* Card wrapper */
        .login-wrapper{
            width:100%;
            max-width:1000px;
            height:calc(100vh - 4rem);
            border-radius:var(--panel-radius);
            overflow:hidden;
            display:flex;
            box-shadow:0 20px 60px rgba(16,24,40,0.25);
            background:transparent;
        }

        /* Left column: illustration / gradient */
        .login-illustration{
            flex:1.1;
            background: linear-gradient(135deg,var(--pink-100) 0%, var(--pink-200) 100%);
            position:relative;
            display:flex;
            align-items:center;
            justify-content:center;
            color:rgba(255,255,255,0.95);
            padding:2.5rem;
        }

        /* Decorative shapes for a dynamic look */
        .login-illustration::before{
            content:"";
            position:absolute;
            width:260px;height:260px;
            background:radial-gradient(circle at 30% 30%, rgba(255,255,255,0.12), transparent 40%);
            border-radius:50%;
            top:20px;left:40px;
            transform:rotate(10deg);
        }
        .login-illustration::after{
            content:"";
            position:absolute;
            right:-80px;bottom:-60px;
            width:420px;height:420px;
            background: radial-gradient(circle at 70% 70%, rgba(255,255,255,0.06), transparent 30%);
            border-radius:50%;
        }

        .illustration-inner{
            position:relative;
            z-index:2;
            max-width:320px;
            text-align:center;
        }
        .illustration-title{
            font-size:1.8rem;
            font-weight:700;
            margin-bottom:0.5rem;
            color:#5b2b4a;
        }
        .illustration-sub{
            color:rgba(0,0,0,0.45);
            background:rgba(255,255,255,0.6);
            display:inline-block;
            padding:0.5rem 1rem;
            border-radius:999px;
            font-size:0.95rem;
            margin-top:1rem;
        }

        /* Right column: panel */
        .login-panel{
            flex:0.9;
            background: #ffffff;
            padding:2.75rem 2.5rem;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .brand {
            font-size:1.6rem;
            font-weight:700;
            color:#3a2a3f;
            letter-spacing:0.2px;
        }
        .brand-sub{
            color:#7a6a78;
            font-size:0.95rem;
            margin-top:0.25rem;
        }

        .login-form{
            width:100%;
            margin-top:1.5rem;
        }
        .form-control{
            border-radius:8px;
            border:1px solid #e6d7de;
            padding:0.85rem 0.9rem;
            box-shadow:none;
        }
        .form-control:focus{
            border-color:var(--accent-1);
            box-shadow:0 6px 20px rgba(234,174,190,0.12);
            outline:none;
        }

        .btn-login{
            background: linear-gradient(90deg,var(--pink-200),var(--accent-1));
            color:#fff;
            border:none;
            padding:0.9rem;
            border-radius:10px;
            font-weight:700;
            box-shadow:0 8px 24px rgba(234,174,190,0.18);
            transition:transform .18s ease, box-shadow .18s ease;
        }
        .btn-login:hover{transform:translateY(-2px); box-shadow:0 18px 36px rgba(234,174,190,0.22)}

        .form-note{font-size:0.9rem;color:#6b5a66;margin-top:0.75rem}

        /* Responsive: stack columns */
        @media (max-width: 900px){
            .login-wrapper{flex-direction:column;height:auto}
            .login-illustration{order:2;padding:1.5rem}
            .login-panel{order:1;padding:1.5rem}
        }
    </style>
</head>
<body>
    <div class="login-wrapper" role="main">
        <div class="login-illustration" aria-hidden="true">
            <div class="illustration-inner">
                <!-- Decorative SVG could be added here; keeping it simple and CSS-driven -->
                <svg width="160" height="160" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect x="0" y="0" width="160" height="160" rx="20" fill="rgba(255,255,255,0.06)"/>
                    <g transform="translate(16,20)">
                        <path d="M56 12c-9 0-16 7-16 16s7 16 16 16 16-7 16-16S65 12 56 12z" fill="#5b2b4a"/>
                        <path d="M10 90c12-20 40-40 72-30" stroke="#7a4361" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" opacity="0.12"/>
                    </g>
                </svg>
                <h3 class="illustration-title">Welcome to ManavikFab</h3>
                <div class="illustration-sub">Premium fashion, curated for you.</div>
            </div>
        </div>

        <div class="login-panel">
            <div>
                <div class="brand">ManavikFab <small class="text-muted">Admin</small></div>
                <div class="brand-sub">Sign in to manage products, orders & customers</div>
            </div>

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login-form">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="you@domain.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="pass" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="text-decoration-none" style="color:#7a6a78;font-size:0.9rem">Forgot?</a>
                </div>
                <button type="submit" name="login" class="btn-login w-100">Sign in</button>
                <div class="form-note">New to ManavikFab? <a href="#" style="color:var(--pink-200);text-decoration:none;font-weight:600">Create an account</a></div>
            </form>
            <?PHP
                if(isset($_POST['login']))
                {
                    $email=$_POST['email'];
                    $pass=$_POST['pass'];
                    $sql="SELECT * FROM `Admin` WHERE `Email`='$email'";
                    $result=mysqli_query($con,$sql);
                    $rows=mysqli_num_rows($result);
                    if($rows>0)
                    {
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $hpass=$row['Password'];
                            $id=$row['AdminID'];
                        }
                        if(password_verify($pass, $hpass))
                        {
                            $_SESSION['adminid']=$id;
                            echo "<script>window.open('../Admin','_self')</script>";
                        }
                        else
                        {
                            echo "<div class='alert alert-danger mt-4' role='alert'>\n  Invalid Password!\n</div>";
                        }
                    }
                    else
                    {
                        echo "<div class='alert alert-danger mt-4' role='alert'>\n  Admin not Found!\n</div>";
                    }
                }
            ?>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
            <?PHP
                if(isset($_POST['login']))
                {
                    $email=$_POST['email'];
                    $pass=$_POST['pass'];
                    $sql="SELECT * FROM `Admin` WHERE `Email`='$email'";
                    $result=mysqli_query($con,$sql);
                    $rows=mysqli_num_rows($result);
                    if($rows>0)
                    {
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $hpass=$row['Password'];
                            $id=$row['AdminID'];
                        }
                        if(password_verify($pass, $hpass))
                        {
                            $_SESSION['adminid']=$id;
                            echo "<script>window.open('../Admin','_self')</script>";
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
  Admin not Found!
</div>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>