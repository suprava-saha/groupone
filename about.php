<?php
   
include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   
   $user_id = $_SESSION['user_id'];
}else{

   $user_id = '';

   
};
 



?>
<?php



$checkingifordersplaced=$conn->prepare("SELECT orders.`user_id` FROM  `users`,`orders` WHERE users.id=orders.user_id and users.id=?");
$checkingifordersplaced->execute([$user_id]);


if(isset($_SESSION['user_id'])){


if($checkingifordersplaced->rowcount()>0){
   $AllowReviewmsg="Submit a review";

   if(isset($_POST["submit"])){
      if($checkingifordersplaced->rowcount()>0){
         $comment=$_POST["comment"];
         $number=$_COOKIE['cname'];
   
         $checkingforduplicatereview=$conn->prepare("SELECT * from `reviews` where rating = ? and customer_id = ? and comment = ?");
         $checkingforduplicatereview->execute([$number,$user_id,$comment]);
         if($checkingforduplicatereview->rowcount()>0){
            $message[]="Repetetive review";
         }else{
   
            $insert_review = $conn->prepare("INSERT INTO `reviews`(rating,customer_id,comment) VALUES(?,?,?)");
            $insert_review->execute([$number,$user_id,$comment]);
            $message[]="Review sucessfully submitted" ;
            
            Header( 'Location: about.php' );
            
      
         }
   






      }else{
         $message[]="Repetetive review";
      }   
   
      
   }

}else{
   $AllowReviewmsg="Place an order to submit a review";
   
   
}

}else{

   $AllowReviewmsg="Login To Review";
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/circularbarstyle.css">
   <link rel="stylesheet" href="css/popupcard.css">
   <link rel="stylesheet" href="css/style.css">
   
   <script>importPackage(java.io); </script>
   
    <script defer src="js/circularbar.js"></script>

   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="js/jquery.Rating.js"></script>
		<script>
            $(function(){
                $('.stars').stars();
            });
        </script>
        

</head>
<body onload="gfg(1)">

<?php include 'customer_header.php'; ?>








<section class="about">

      

   <div class="row">

      <div class="image">
         <img src="images/car3.png" alt="">
      </div>

      <div class="content">
         
         <h3>Our Team</h3>
         <p>We are a team of 5 persons collaborating together to enlighten the car dealership industry to its peak. Our team has Suprava, Sayef, Minar, Zafir & Dweep. We hope you like our initiative.</p>

         <div class="container">

           
<form action="" method="POST">
      <div class="card" id="popup">
         <h1 class="">What do you think about the product?</h1>


        <input type="text" class="textbox" name="comment" placeholder="Tell us your opinion">


         <br />
         <span onclick="gfg(1)"
            class="star" value=1>★
         </span>
         <span onclick="gfg(2)"
            class="star">★
         </span>
         <span onclick="gfg(3)"
            class="star">★
         </span>
         <span onclick="gfg(4)"
            class="star">★
         </span>
         <span onclick="gfg(5)"
            class="star">★
         </span>
         <h3 style="transform: scale(0.5); margin-left:-80px;" id="output">
            rating is: 0/5
         </h3>
        <button type="submit" class="reviewsubmit" name="submit">
         Submit
        </button>
        <button type="button" onclick="closepopup()" class="closebutton">&times;</button>
            
      </div>
     </div>
</form>


<?php
if(!isset($_SESSION['user_id'])){
   

?>
<a href="customer_login.php" class="btn"><?php echo $AllowReviewmsg?></a>
<?php

}else{
   
   

   if($checkingifordersplaced->rowcount()>0){
      ?>
            <span class= "btn" onclick="openpopup()"><?php echo $AllowReviewmsg?></span>
      <?php

   }else{
      ?>
         <a href="shop.php" class="btn"><?php echo $AllowReviewmsg?></a>
      <?php
   }
 

   

}

?>





</section>

<section class="reviews">
   
   <h1 class="heading" style="margin-bottom:-5px">Client's Reviews.</h1>


   
   <div class="skill">

<?php 
     $totalrating = 0;
     $countofreviews = 0;
     $averagerate = 0;
   $q = $conn->prepare("SELECT * FROM reviews");
        $q->execute();
        if($q->rowcount()<1){
           $averagerate=0;
        }else{
           while($r = $q->fetch(PDO::FETCH_ASSOC)){
              $countofreviews+=1;
         
              $totalrating=$totalrating+$r['rating'];
           }
        $averagerate= $totalrating/$countofreviews;
        }
?>






     <script>window.addEventListener("load", myInit, true); function myInit(){changeStrokeDashOffset(<?php echo $averagerate?>)}</script>
       <div class="outer">       
           <div class="inner">
    



              
               <div id="number">
                   
               </div>

           </div>
           
       </div>
      
 </div>



        
     </div>

  </div>



   <div class="swiper reviews-slider" style="margin-top: 150px;">

   <div class="swiper-wrapper">


   <?php
      $select_reviews = $conn->prepare("SELECT * FROM `reviews` order by rating desc");
      
      $select_reviews->execute();
      if($select_reviews->rowCount() > 0){
         while($fetch_reviews = $select_reviews->fetch(PDO::FETCH_ASSOC)){   
   ?>
      <div class="swiper-slide slide">
         <img   src="images\default.png" style="width: 70px; height: 50px; object-fit: cover;">
         <p><span><?= $fetch_reviews['comment'];?></span></p>
         <span class="stars" data-rating="<?= $fetch_reviews['rating'];?>" data-num-stars="5" ></span>
         <h3> 
            <a>
               <?php 

                  $customer_id= $fetch_reviews['customer_id'];
                  $select_username = $conn->prepare("SELECT name FROM `users` where id = ?");
      
                  $select_username->execute([$customer_id]);

                  $customer_uname= $select_username->fetch();
                  echo $customer_uname['name'];
                  
         
         
               ?>
            </a>
         </h3>
         </div>
      <?php
         }
      
      }else{
         echo '<p class="empty">no reviews yet!<?p>';
      }
      ?>
   

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="js/review_script.js"></script>


<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>
   
</body>
</html>
