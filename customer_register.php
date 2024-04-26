<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);   
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $phone = $_POST['phone'];
   $phone = filter_var($phone, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $d_address = $_POST['d_address'];
   $d_address = filter_var($d_address, FILTER_SANITIZE_STRING);
   $pass = filter_var($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = filter_var($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'Sorry, this email address is already registered!';
   }else{
      if($pass != $cpass){
         $message[] = 'Passwords do not match!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, phone, address, d_address, password) VALUES(?,?,?,?,?,?)");
         $insert_user->execute([$name, $email, $phone, $address, $d_address, $cpass]);
         $message[] = 'Welcome to CAR POINT';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'customer_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>REGISTER</h3>
      <input type="text" name="name" required placeholder="Name" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">      
      <input type="text" name="email" required placeholder="Email Address" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="phone" required placeholder="Phone Number" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="address" required placeholder="Address" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="d_address" required placeholder="Delivery Address" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Retype password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" class="btn" name="submit">
      <p>Already Registered?</p>
      <a href="customer_login.php" class="option-btn">LOGIN</a>
   </form>

</section>













<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>