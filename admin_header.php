<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Admin</a>

      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="inventory.php">Inventory</a>
         <a href="placed_orders.php">Orders</a>
         <a href="testdrive_request.php">Test Drive</a>
         <a href="admin_accounts.php">Admins</a>
         <a href="customer_accounts.php">Customers</a>
         <a href="queries.php">Queries</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">Update Profile</a>
         <div class="flex-btn">
            <a href="register_admin.php" class="option-btn">Register Admin</a>
         </div>
         <a href="admin_logout.php" class="delete-btn" onclick="return confirm('Are you sure to logout?');">LOGOUT</a> 
      </div>

   </section>

</header>