<?php
session_start();
include "dbcon.php";
date_default_timezone_set('Asia/Kolkata');
if(!isset($_SESSION['name']))
{
    header("location:user_login.php");
}
$quizid=$_GET['n'];
$email=$_SESSION['email'];
$endtime="";
$starttime="";
$duration=$_GET['dur'];
$query="select * from quiztime where quizid='$quizid' and email='$email'";
$res= mysqli_query($con,$query);
if(mysqli_num_rows($res)==0)
{
    $starttime=date('Y-m-d H:i:s');
    $endtime= date('Y-m-d H:i:s',strtotime($starttime . '+' . $duration . 'minutes'));
    $insertquery="insert into quiztime (quizid,email,time) values('$quizid','$email','$endtime')";
    $insert=mysqli_query($con,$insertquery);
    
}
else
{
    $selectendtime="select * from quiztime where quizid='$quizid' and email='$email'";
    $res=mysqli_query($con,$selectendtime);
    $row = mysqli_fetch_array($res);
    $endtime=$row['time'];
    $starttime=date('Y-m-d H:i:s');
}


$countdowntime= date('Y/m/d H:i:s',strtotime($endtime));

/*if(date('Y-m-d H:i:s')>$endtime)
{
    header("location:userportal_quizzes.php");
} */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="startsquiz.css" rel="stylesheet">
    <title>Document</title>
    <script
     src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        p,
label {
    font: 1rem 'Fira Sans', sans-serif;
}

input {
    margin: .4rem;
}

    </style>
    <link rel="stylesheet" href="startsquiz.css">
    <script>
     let counter=1;
     let count=counter-1;
    
         
      $(document).ready(function()
      {
        $("#next").click(function(){
          $("#show").load("show.php?qid="+ counter);
          counter++;
          if(counter>3)
          {
            counter=counter-1;
          }
          

        });
        $("#back").click(function(){
           
          $("#show").load("show.php?qid="+ count);

        });

      });
      </script>
        </head>
        <body>
        <script>
var countDownDate= new Date("<?php echo $countdowntime; ?>");
var timer= setInterval(function(){
    var x = new Date();
var distance = countDownDate - x;
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);

document.getElementById("timer").innerHTML = days + "d " + hours + "h "
+ minutes + "m " + seconds + "s ";

if(distance < 0) {
  clearInterval(timer);
  //document.write(countDownDate," ",x);
  document.getElementById("timer").innerHTML = "EXPIRED";
  window.location.replace("examsubmitted.php");
}
},1000);
</script>
<div id="timer"></div>  
        <center>
          <div id="quizarea">
            <h2>Welcome</h2>
        
            <p></p>

          <ol>
    <div id="show"></div>
  </ol>
<button  id="next" class="btn" name="next" id="next">Next</button>
</div>
        </body>
        
    </html>
