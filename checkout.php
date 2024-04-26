<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:customer_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Congratulations! Soon you are going to own your desire.';
   }else{
      $message[] = 'You have no cars added!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'customer_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Your Orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '$'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">Payable Amount:  <span>BDT<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>Own your Desire Quickly</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Name</span>
            <input type="text" name="name" placeholder="Name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Number</span>
            <input type="number" name="number" placeholder="Number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Email Address</span>
            <input type="email" name="email" placeholder="Email Address" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Payment Method</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">bKash</option>
               <option value="credit card">Nagad</option>
               <option value="paytm">Cash on Delivery</option>
               <option value="paypal">Credit/Debit Card</option>
            </select>
         </div>
         <div class="inputBox">
            <span>House Number</span>
            <input type="text" name="flat" placeholder="House Number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Street Address</span>
            <input type="text" name="street" placeholder="Street Address" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>City</span>
            <input type="text" name="city" placeholder="City" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Upazila/Thana</span>
            <input type="text" name="state" placeholder="Upazila/Thana" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Division</span>
            <input type="text" name="country" placeholder="Division" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Postal Code</span>
            <input type="number" min="0" name="pin_code" placeholder="Postal Code" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>













<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>