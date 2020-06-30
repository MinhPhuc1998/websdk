<?php 
session_start();
header('Content-Type: text/html; charset=UTF-8');
include('connect.php');
include ("PHPMailer-5.2.0/class.phpmailer.php");
if (isset($_POST['reset-password'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  // ensure that the user exists on our system
  //$query = "SELECT email FROM user WHERE email='$email'";
  //$results = mysqli_query($db, $query);
  $sql = "SELECT email FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0)
    {
        echo '<script language="javascript">alert("Email này không tồn tại!"); window.location="reset-password.php";</script>';
        die ();
    }else{
      $_SESSION['email'] = $email;
      $token = bin2hex(random_bytes(10));
      $_SESSION['token'] = $token;
      $sql1 = "UPDATE user SET _token='$token' WHERE email='$email'";
      $results = mysqli_query($conn, $sql1);
      //send mail
      $mail = new PHPMailer();
      //$mail->setMail('smtp'); // smtp | mail (ham mail trong PHP), default: mail
      $mail->IsSMTP();
      $mail->Host = "smtp.gmail.com"; //
      $mail->Port = 465;
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'ssl'; // ssl hoac tls, neu su dung tls thi $mail->Port la: 587
      $mail->Username = "minhphuc130298@gmail.com"; // tai khoan dang nhap de gui email
      $mail->Password = "MP98*sheepbee";            // mat khau gui email

      $mail->From = "minhphuc130298@gmail.com"; // email se duoc thay the email trong smtp
      $mail->AddReplyTo("minhphuc130298@gmail.com");  // email cho phep nguoi dung reply lai
      $mail->FromName = "phuc minh"; // ho ten nguoi gui email

      $mail->WordWrap = 50;
      $mail->IsHTML('text/html');     //text/html | text/plain, default:text/html

      $mail->AltBody = "Send from ITNetCorp class_smtp_mail"; //Text Body

      $mail->Body = "Hi there, click on this '<a href=\"http://localhost/F_PROJECT/f/new-password.php?email=" . $email . "?token=" . $token . "\">link</a>' to reset your password on our site";; //HTML Body
      $mail->Subject = "Reset password";
      $mail->AddAddress($email); // email nguoi nhan

      $mail->Send();
      $mail->ClearAddresses();
      echo '<script language="javascript">alert("Đã gửi email!"); window.location="login.php";</script>';
    	// Send email to user with the token in a link they can click on
    	/*$to_email = $email;
	    $subject = "Reset your password on my page";
	    $msg = "Hi there, click on this <a href=\"new-password.php?token=" . $token . "\">link</a> to reset your password on our site";
	    $msg = wordwrap($msg,70);
	    $headers = "From: minhphuc130298@gmail.com";
	    if (mail($to_email, $subject, $msg, $headers)) {
    		echo "Email successfully sent to." .'$email';
		  } else {
    		echo "Email sending failed...";
		  }*/
	  }
  /*if (empty($email)) {
    array_push($errors, "Your email is required");
  }else if(mysqli_num_rows($results) <= 0) {
    array_push($errors, "Sorry, no user exists on our system with that email");
  }
  // generate a unique random token of length 100
  $token = bin2hex(random_bytes(50));
  if (count($errors) == 0) {
    // store token in the password-reset database table against the user's email
    $sql = "INSERT INTO password_reset(email, token) VALUES ('$email', '$token')";
    $results = mysqli_query($db, $sql);

    // Send email to user with the token in a link they can click on
    $to = $email;
    $subject = "Reset your password on examplesite.com";
    $msg = "Hi there, click on this <a href=\"new_password.php?token=" . $token . "\">link</a> to reset your password on our site";
    $msg = wordwrap($msg,70);
    $headers = "From: info@examplesite.com";
    mail($to, $subject, $msg, $headers);
    header('location: pending.php?email=' . $email);
  }*/
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<!-- Nhúng file CSS -->
	<link rel="stylesheet" href="Style.css" />
	<title>Reset password page</title>
</head>
<body>
	<form action="reset-password.php" method="POST" class="submit-form2">
	<input type="email" placeholder="Email" name="email" value ="" 
	required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Invalid email!" />
	<input class="submit-form" type='submit' name="reset-password" value='SEND CODE TO MAIL' />
	</form>
</body>
</html>