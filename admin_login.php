<?php
require "admincheck.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Login Page</title>
    <link rel="stylesheet" href="admin_login.css">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Patua+One&family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">
  </head>
  <body>
  <div id="error"></div>
    <div class="mainmenu">
      <a href="index.php">Go Back To Main Menu</a>
    </div>
    <div class="loginbox">
      <div class="avatarbox">
        <img src="images/boss.png" alt="">
      </div>
          <h1>Admin Login</h1>
          <div class="formbox">

            <form class="" action="" method="Post">
              <p>Username</p>
              <input type="text" name="username" placeholder="Enter Username">
              <p>Password</p>
              <input type="password" name="password" placeholder="Enter Password"> <br><br>
              <!-- <input type="submit" name="" value="Login"><br> -->
              <button type="submit" class="btn" name="submit">Login</button>
            </form>

          </div>
    </div>
    <script>
    var userright= <?php echo $userright ?>;
    var passright= <?php echo $passright ?>;
    if(userright==0||passright==0)
    {
      document.getElementById('error').innerHTML="You are not an admin";
    }
    else
    {
      window.location.replace("adminportal.php");
    }
    setTimeout(clear,5000);
    function clear()
    {
      document.getElementById('error').innerHTML="";
    }

    </script>

  </body>
</html>
