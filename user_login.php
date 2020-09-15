<?php
session_start();

?>
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
  <body onload="setTimeout(clear,3000)">

<?php

$server="localhost";
$user="root";
$password="";
$db="quizickle";

$con=mysqli_connect($server,$user,$password,$db);


if(isset($_POST['submit'])){
  $email= $_POST['email'];
  $pass=  $_POST['password'];


  $emailcheck= "select * from user_registration where email='$email' ";
  $query=mysqli_query($con,$emailcheck);
  $emcount=mysqli_num_rows($query);
  if($emcount)
  {
      $regpass= mysqli_fetch_assoc($query);
      $checkpass= $regpass['password'];
      $succ= password_verify($pass,$checkpass);
      if($succ){
          $_SESSION['name']=$regpass['firstname'];
          $_SESSION['email']=$email;
          header("location:userportal.php");
      } 
      else{
          $passwrong=1;
          echo "<h3 id='1'>Wrong Password</h3>";
      }
  }
  else{
      $notexist=1;
      echo "<h3 id='2'>Email not registered</h3>";
  }
}



?>
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
              <p>Email</p>
              <input type="text" name="email" placeholder="Enter email" required onchange="checkmail(this)">
              <p id="emailerr"></p>
              <p>Password</p>
              <input type="password" name="password" placeholder="Enter Password" required onchange="checkpass(this)"><br><br>
              <p id="passerror"></p>
              <button type="submit" id="btn" class="btn" name="submit" onclick="return checkboth()">Login</button>
            </form>
          </div>
          <br><p>Haven't registered yet? <a href="user_registration.php">Sign up here</a></p>
    </div>

<script>
var emailcorr=0;
var passcorr=0;

function checkmail(inputtxt){
var mailpattern=  /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
if(inputtxt.value.match(mailpattern)) 
{ 
    emailcorr=1;
    document.getElementById('emailerr').innerHTML="";
    document.getElementById('emailerr').style.display="none";
}
else
{ 
    emailcorr=0;
    document.getElementById('emailerr').innerHTML="Invalid Email";
    document.getElementById('emailerr').style.display="block";
}
}

function checkpass(inputtxt){
var passw=  /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
if(inputtxt.value.match(passw)) 
{ 
    passcorr=1;
    document.getElementById('passerror').innerHTML="";
    document.getElementById('passerror').style.display="block";
}
else
{ 
    passcorr=0;
    document.getElementById('passerror').innerHTML="wrong password format";
    document.getElementById('passerror').style.display="block";
}
}

function checkboth()
{
  if(emailcorr==0||passcorr==0)
  {
    alert("invalid inputs");
    return false;
  }
  else 
  return true;
}

function clear()
{
  document.getElementById('1').innerHTML="";
  document.getElementById('2').innerHTML="";
  document.getElementById('1').style.display="none";
  document.getElementById('2').style.display="none";
}

</script>

  </body>
</html>
