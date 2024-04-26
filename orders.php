<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'customer_header.php'; ?>

<section class="orders">

   <h1 class="heading">Placed Orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Login to see your current orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Order ID : <span><?= $fetch_orders['id']; ?></span></p>
      <p>Placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Payment Method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>Customer ID : <span><?= $fetch_orders['user_id']; ?></span></p>
      <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>Total price : <span>BDT<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p> Payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">You have not yet ordered any car. Hurry Up!</p>';
      }
      }
   ?>

   </div>

</section>

<section class="orders">

   <h1 class="heading">Test drive requests</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Login to see your current orders</p>';
      }else{
         $select_testdrives = $conn->prepare("SELECT * FROM `test_drive` WHERE user_id = ?");
         $select_testdrives->execute([$user_id]);
         if($select_testdrives->rowCount() > 0){
            while($fetch_testdrives = $select_testdrives->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>test id : <span><?= $fetch_testdrives['test_id']; ?></span></p>
      <p>Placed on : <span><?= $fetch_testdrives['test_date']; ?></span></p>
      <p>Customer ID : <span><?= $fetch_testdrives['user_id']; ?></span></p>

      <p>Customer Name : <span><?= $fetch_testdrives['name']; ?></span></p>

      <p> Request Status : <span style="color:<?php if($fetch_testdrives['Request_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_testdrives['Request_status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">You have not yet requested any car for a test drive. Hurry Up!</p>';
      }
      }
   ?>

   </div>

</section>













<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>