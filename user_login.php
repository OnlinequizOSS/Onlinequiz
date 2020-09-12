<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>User Login Page</title>
    <link rel="stylesheet" href="user_login.css">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Patua+One&family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="mainmenu">
      <a href="index.php">Go Back To Main Menu</a>
    </div>
    <div class="loginbox">
      <div class="avatarbox">
        <img src="images/interview.png" alt="">
      </div>
          <h1>Student Login</h1>
          <div class="formbox">
            <form class="" action="user_login.php" method="post">
              <p>Username</p>
              <input type="text" name="" placeholder="Enter Username">
              <p>Password</p>
              <input type="password" name="" placeholder="Enter Password"> <br><br>
              <button type="submit" class="btn" name="">Login</button>
            </form>
          </div>
          <br><p>Haven't registered yet? <a href="user_registration.php">Sign up here</a></p>
    </div>

  </body>
</html>
