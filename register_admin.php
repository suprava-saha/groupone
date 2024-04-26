<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $nid = $_POST['nid'];
   $nid = filter_var($nid, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $phone = $_POST['phone'];
   $phone = filter_var($phone, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $pass = filter_var($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = filter_var($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   
   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE nid = ?");
   $select_admin->execute([$nid]);

   if($select_admin->rowCount() > 0){
      $message[] = 'Sorry, this NID is already registered!';
   }else{
      if($pass != $cpass){
         $message[] = 'Passwords do not match!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admins`(name, nid, email, phone, address, password) VALUES(?,?,?,?,?,?)");
         $insert_admin->execute([$name, $nid, $email, $phone, $address, $cpass]);
         $message[] = 'Admin Successfully Registered.';
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
   <title>Register Admin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Register Admin</h3>
      <input type="text" name="name" required placeholder="Name" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="nid" required placeholder="NID Number" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">      
      <input type="text" name="email" required placeholder="Email Address" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="phone" required placeholder="Phone Number" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="address" required placeholder="Address" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Retype password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="REGISTER NOW" class="btn" name="submit">
   </form>

</section>












<script src="js/admin_script.js"></script>
   
</body>
</html>