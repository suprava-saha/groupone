<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:customer_login.php');
};

if(isset($_POST['TestDrive'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $test_date = $_POST['test_date'];
   $test_date = filter_var($test_date, FILTER_SANITIZE_STRING);

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `test_drive`(user_id, name, test_date) VALUES(?,?,?)");
      $insert_order->execute([$user_id, $name, $test_date]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Test Drive Requested successfully!';
   }else{
      $message[] = 'No Car Selected for Test Drive';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'customer_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Place your Test Drive Request</h3>

   <div class="flex">
      <div class="inputBox">
         <span>Name </span>
         <input type="text" name="name" placeholder="Name" class="box" maxlength="20" required>
      </div>
      <div class="inputBox">
         <span>Test Drive Date</span>
         <input type="date" name="test_date" placeholder="Test Drive Date" class="box" maxlength="20" required>
      </div>
   </div> 

      <button type="submit" name="TestDrive" class="btn">
      Request for Test Drive
</button>
   </form>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>