<?php
 session_start();
 if(isset($_SESSION["name"]))
{
     $username=$_SESSION["name"];
     $userlogin="logout";

}
else
{
  $username="login";
  $userlogin="signup";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>king chef</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  
  <style>
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
    .image-box {
  max-height: 250px;
  overflow: hidden;
}
.food-img {
  max-height: 250px;
  width: 100%;
  object-fit: cover;
}
.col-sm-9 {
  height: 250px; 
}

.well {
  height: 100%;
  display: flex;
  align-items: center; 
}

.well p {
  margin: 0;
}



  </style>
</head>
<nav class="navbar navbar-inverse " >
    <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">King chef</a>
      </div>
     <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li class="active1" ><a href="index.php" >Home</a></li>
        <li class="active2"><a href="menu.php">Menu</a></li>
        <li class="active3"><a href="orderpage.php">Billing & Order</a></li>
        <li class="active4"><a href="#">Servant</a></li>
        <?php
        if($username=="login")
        {
          echo '<li><a href="userlogin.php"><span class="glyphicon glyphicon-user"></span> '.$username.' </a></li>';
        }
        else
      {        
        echo '<li><a href=""><span class="glyphicon glyphicon-user"></span> '.$username.' </a></li>';
      }
        echo'<li><a href="userlogin.php">
        <form action="userlogin.php" method="post" style="margin:0px;">
                <span class="glyphicon glyphicon-log-out"></span>
          <input type="submit" class="active" name="logout" value="' . htmlspecialchars($userlogin) . '" style="background-color:inherit; border: none; border-radius: 4px;">
        </form></a>
    </li>';
      ?>
      </ul>
    </div>
  </div>
</nav> 
<br>
<div class="jumbotron" style=" text-align:center; background-image: url('img/img1.jpg'); background-size: cover; background-position: center; color: white; margin:15px;">
  <div class="container" >
    <h1 >King chef</h1>   
    <p style="color: white;">“Elevating your taste buds, one bite at a time.”</p>
  </div>
</div>
</div>
<div class="container-fluid bg-3 text-center img " style="border: 1px solid black;">    
  <h3>Our Special Items</h3><br>
  <div class="row align-items-center">
      <div class="col-sm-3">
        <img src="img/biriyani.jpg" class="img-fluid food-img" alt="Image" style="border-radius: 20%;">
      </div>
      <div class="col-sm-9 d-flex align-items-center">
        <div class="well">
          <p>Biriyani is a delicious rice dish cooked with spices and meat or vegetables.
          Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.
                Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
        </div>
      </div>
  </div>
    <br>
  <br>
  <div class="row align-items-center">
  
  <div class="col-sm-9 d-flex align-items-center">
    <div class="well">
      <p>Biriyani is a delicious rice dish cooked with spices and meat or vegetables.
       Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.
            Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
    </div>
  </div>
  <div class="col-sm-3">
    <img src="img/Dosa.jpg" class="img-fluid food-img" alt="Image" style="border-radius: 20%;">
  </div>
</div>
  <br>
  <br>
  <div class="row align-items-center">
  <div class="col-sm-3">
    <img src="img/parot.jpg" class="img-fluid food-img" alt="Image" style="border-radius: 20%;">
  </div>
  <div class="col-sm-9 d-flex align-items-center">
    <div class="well">
      <p>Biriyani is a delicious rice dish cooked with spices and meat or vegetables.
       Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.
         Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
    </div>
  </div>
</div>

<br><br>

<div class="row align-items-center">
  
  <div class="col-sm-9 d-flex align-items-center">
    <div class="well">
      <p>Biriyani is a delicious rice dish cooked with spices and meat or vegetables.
       Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.
            Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
    </div>
  </div>
  <div class="col-sm-3">
    <img src="img/pizza.jpg" class="img-fluid food-img" alt="Image" style="border-radius: 20%;">
  </div>
</div>
</div>
<br>


              <!-- footer start -->
<!-- <link rel="stylesheet" type="text/css" href="foodcss.css" >
    <div class="footer" style="width:100%">
    <div class="footer-content" style="width:100%">
        <p>@copy: 2025 King chef. All rights reserved.</p>
        <div class="footer-links">
            <a href="#">About Us</a>
            <a href="#">Terms of Service</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Contact</a>
        </div>
    </div>
</div> -->



 