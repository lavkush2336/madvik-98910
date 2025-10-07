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
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f8c9d8;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }
        .login-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }
        .logo-text {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            text-align: center;
        }
        .tagline {
            font-size: 1rem;
            color: #666;
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ddd;
            padding: 0.75rem;
        }
        .form-control:focus {
            border-color: #f8c9d8;
            box-shadow: 0 0 0 0.2rem rgba(248, 201, 216, 0.25);
        }
        .btn-login {
            background-color: #f8c9d8;
            color: #333;
            border: none;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-login:hover {
            background-color: #f4b6cc;
        }
        @media (max-width: 576px) {
            .login-card {
                padding: 1.5rem;
                max-width: 90%;
            }
            .logo-text {
                font-size: 1.5rem;
            }
            .tagline {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-text">ManavikFab</div>
            <div class="tagline">"Wear a Style That You Love."</div>
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="email" class="form-control mt-1 w-full" placeholder="Enter your email" required name="email">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" class="form-control mt-1 w-full" placeholder="Enter your password" required name="pass">
                </div>
                <button type="submit" class="btn-login w-full" name="login">Login</button>
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