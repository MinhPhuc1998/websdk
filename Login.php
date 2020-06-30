<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include('connect.php');
if (isset($_POST['dangnhap'])) 
{    
    $email = mysqli_real_escape_string($conn,$_POST['email2']);
    $password = mysqli_real_escape_string($conn,$_POST['password2']);
    if (!$email || !$password) {
        echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
    $password = md5($password);
    $sql="SELECT * FROM user WHERE email='$email'";
    $query=mysqli_query($conn, $sql);
    $num_row=mysqli_num_rows($query);
    if($num_row!= 0){
        //Lấy mật khẩu trong database ra
        $row = mysqli_fetch_array($query);
     
        //So sánh 2 mật khẩu có trùng khớp hay không
        if ($password != $row['password']) {
        echo '<script language="javascript">alert("Mật khẩu không đúng!"); window.location="login.php";</script>';
        }else{
        echo "successfully";
        //Lưu tên đăng nhập
        $_SESSION['email'] = $email;
        echo '<script language="javascript">alert("Đăng nhập thành công!"); window.location="login.php";</script>';
        /*echo "Xin chào " . $email . ". Bạn đã đăng nhập thành công. <a href='/'>Về trang chủ</a>";*/
        die();
        }
    }else{
        echo "không thành công";
    }
    
    
    
}
if(isset($_POST['dangky']))
{
    $namee = mysqli_real_escape_string($conn,$_POST['name1']);
    $emaill = mysqli_real_escape_string($conn,$_POST['email1']);
    $passwordd = mysqli_real_escape_string($conn,$_POST['password1']);
    $passwordd=md5($passwordd);
    $sql = "SELECT * FROM user WHERE name = '$namee' OR email = '$emaill'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
        // Sử dụng javascript để thông báo
        echo '<script language="javascript">alert("Thông tin đăng nhập này đã được sử dụng!"); window.location="login.php";</script>';
          
        // Dừng chương trình
        die ();
    }
    else {
    $sql = "INSERT INTO user(name,email,password) VALUES('$namee','$emaill','$passwordd')";
    $query=mysqli_query($conn,$sql);
    echo '<script language="javascript">alert("Đăng ký thành công"); window.location="login.php";</script>';
    }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<!-- Nhúng file CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css" />
</head>
<body>
<!-- <h2>Sign in/up Form</h2> -->
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="" method="POST">
                <h1>Create Account</h1>
                <div class="social-container">
                    <!-- <a href="#" class="social"><i class="fab fa-facebook-f"></i></a> -->
                    <a href="#" class="social"><i class="fa fa-google"></i></a>
                    <!-- <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a> -->
                </div>
                <span>or use your email for registration</span>
                <input type="text" placeholder="Name" value ="" name="name1" required pattern="[a-z]{1,20}"
        		title="Username should only contain lowercase letters and less than 20 letters"/>
                <input type="email" placeholder="Email" name="email1" value ="" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                title="Invalid email!"/>
                <input type="password" placeholder="Password" name="password1" value ="" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                title="Password must contain 8 characters, including uppercase, lowercase letters and numbers."/>
                <input class="submit-form" type='submit' name="dangky" value='Sign up' />
               <!--  <button>Sign Up</button> -->
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="" method="POST">
                <h1>Sign in</h1>
                <div class="social-container">
                    <!-- <a href="#" class="social"><i class="fab fa-facebook-f"></i></a> -->
                    <a href="#" class="social"><i class="fa fa-google"></i></a>
                    <!-- <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a> -->
                </div>
                <span>or use your account</span>
                <input type="email" placeholder="Email" name="email2" value ="" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                title="Invalid email!"/>
                <input type="password" name="password2" placeholder="Password"
	            value ="" required  title="Invalid password!"/>
                <a href="reset-password.php">Forgot your password?</a>
                <input class="submit-form" type='submit' name="dangnhap" value='Sign in' />
               <!--  <button>Sign In</button> -->
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
<script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });

</script>
</body>
</html>

