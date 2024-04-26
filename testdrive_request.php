<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}


if(isset($_POST['update_request'])){
   $test_id = $_POST['test_id'];
   $Request_status = $_POST['Request_status'];
   $Request_status = filter_var($Request_status, FILTER_SANITIZE_STRING);
   $update_Request = $conn->prepare("UPDATE `test_drive` SET Request_status = ? WHERE test_id = ?");
   $update_Request->execute([$Request_status, $test_id]);
   $message[] = 'Test Drive Request Status updated!';
}


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `test_drive` WHERE test_id = ?");
   $delete_order->execute([$delete_id]);
   header('location:testdrive_request.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Test Drive Requests</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="orders">

<h1 class="heading">TEST DRIVE REQUESTS</h1>

<div class="box-container">

   <?php
      $select_testdrive = $conn->prepare("SELECT * FROM `test_drive`");
      $select_testdrive->execute();
      if($select_testdrive->rowCount() > 0){
         while($fetch_testdrive = $select_testdrive->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Placed On : <span><?= $fetch_testdrive['test_date']; ?></span> </p>
      <p> Name : <span><?= $fetch_testdrive['name']; ?></span> </p>
      
      <form action="" method="post">
         <input type="hidden" name="test_id" value="<?= $fetch_testdrive['test_id']; ?>">
         <select name="Request_status" class="select">
            <option selected disabled><?= $fetch_testdrive['Request_status']; ?></option>
            <option value="confirmed">Confirmed</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="update" class="option-btn" name="update_request">
         <a href="testdrive_request.php?delete=<?= $fetch_testdrive['test_id']; ?>" class="delete-btn" onclick="return confirm('delete this request?');">delete</a>
        </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No Test Drive Requested Yet!</p>';
      }
   ?>

</div>

</section>

</section>












<script src="js/admin_script.js"></script>
   
</body>
</html>