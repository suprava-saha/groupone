<!-- index.html -->
<?php

include 'connect.php';

session_start();
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};



if(isset($_POST["submit"])){
	$comment=$_POST["comment"];
	$number=$_COOKIE['cname'];
	




	$insert_review = $conn->prepare("INSERT INTO `reviews`(rating,customer_id,comment) VALUES(?,?,?)");
    $insert_review->execute([$number,$user_id,$comment]);
}


?>




<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Star Rating</title>
	<meta name="viewport"
		content="width=device-width, 
				initial-scale=1" />
	<link rel="stylesheet"
		href="css\review_styles.css" />

        



		


</head>

<body >


	
      <div class="container">

            <button  style="font-family: monospace;" type="submit" class="btn" onclick="openpopup()">submit</button>
	<form action="" method="POST">
	      <div class="card" id="popup">
		      <h1 class="betterfont">What do you think about the product?</h1>


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
		      <h3 style="font-family: monospace;" id="output">
			      rating is: 0/5
		      </h3>
			  <button type="submit" class="reviewsubmit" name="submit">
				submit 
			  </button>
			  <button onclick="closepopup()" class="closebutton">&times;</button>
	      </div>
     	</div>
	</form>
	<script src="js\review_script.js"></script>
</body>

</html>
