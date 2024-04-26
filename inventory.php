<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   // $details = $_POST['details'];
   // $details = filter_var($details, FILTER_SANITIZE_STRING);

   $Company	 = $_POST['Company'];
   $Company	 = filter_var($Company, FILTER_SANITIZE_STRING);

   $Year = $_POST['Year'];
   $Year = filter_var($Year, FILTER_SANITIZE_STRING);

   $Displacement = $_POST['Displacement'];
   $Displacement = filter_var($Displacement, FILTER_SANITIZE_STRING);

   $Model = $_POST['Model'];
   $Model = filter_var($Model, FILTER_SANITIZE_STRING);

   $Mileage = $_POST['Mileage'];
   $Mileage = filter_var($Mileage, FILTER_SANITIZE_STRING);

   $Status = $_POST['Status'];
   $Status = filter_var($Status, FILTER_SANITIZE_STRING);

   $Transmission = $_POST['Transmission'];
   $Transmission = filter_var($Transmission, FILTER_SANITIZE_STRING);

   $Body_Type = $_POST['Body_Type'];
   $Body_Type = filter_var($Body_Type, FILTER_SANITIZE_STRING);

   $Fuel_Type = $_POST['Fuel_Type'];
   $Fuel_Type = filter_var($Fuel_Type, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = 'uploaded_img/'.$image_01;


   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'Car already exists!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(name, price, Company, Year, Displacement, Model, Mileage, Status, Transmission, Body_Type, Fuel_Type, image_01) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
      $insert_products->execute([$name, $price, $Company, $Year, $Displacement, $Model, $Mileage, $Status, $Transmission, $Body_Type, $Fuel_Type, $image_01]);

      if($insert_products){
         if($image_size_01 > 2000000 ){
            $message[] = 'Please choose an image of smaller size!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            $message[] = 'Congratulations! New car added to your Inventory!';
         }

      }

   }  

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('uploaded_img/'.$fetch_delete_image['image_01']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:inventory.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inventory</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading"></h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Car Name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Car Name" name="name">
         </div>
         <div class="inputBox">
            <span>Price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="Price" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
         <div class="inputBox">
            <span>Company (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Company" name="Company">
         </div>
         <div class="inputBox">
            <span>Manufacturing Year (required)</span>
            <input type="number" min="0" class="box" required max="9999" placeholder="Manufacturing Year" name="Year">
         </div>
         <div class="inputBox">
            <span>Displacement (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Displacement" name="Displacement">
         </div>
         <div class="inputBox">
            <span>Model (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Model" name="Model">
         </div>
         <div class="inputBox">
            <span>Mileage (required)</span>
            <input type="number" min="0" class="box" required max="9999" placeholder="Mileage" name="Mileage">
         </div>
         <div class="inputBox">
            <span>Status (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Status" name="Status">
         </div>
         <div class="inputBox">
            <span>Transmission (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Transmission" name="Transmission">
         </div>
         <div class="inputBox">
            <span>Body Type (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Body Type" name="Body_Type">
         </div>
         <div class="inputBox">
            <span>Fuel Type (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Fuel Type" name="Fuel_Type">
         </div>
        <div class="inputBox">
            <span>Image (required)</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
      </div>
      
      <input type="submit" value="add product" class="btn" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="heading">Stocked Cars</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="price">BDT<span><?= $fetch_products['price']; ?></span>/-</div>
      
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="inventory.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure to remove this car from your stock?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No Car Stocked Yet!</p>';
      }
   ?>
   
   </div>

</section>








<script src="js/admin_script.js"></script>
   
</body>
</html>