<?php
session_start();
include "dbcon.php";
if(!isset($_SESSION['name']))
{
    header("location:user_login.php");
}
$quizid=$_GET['n'];
$email=$_SESSION['email'];
$endtime="";
$duration=$_GET['dur'];
$query="select * from quiztime where quizid='$quizid' and email='$email'";
$res= mysqli_query($con,$query);
if(!$res||mysqli_num_rows($res)==0)
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
    <link rel="stylesheet" href="exampage.css">
    <title>Exam Page</title>
</head>
<body>
<script>
var countDownDate= new Date("<?php echo $countdowntime; ?>");
var timer= setInterval(function(){
    var now = new Date().getTime();
var distance = countDownDate - now;
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);

document.getElementById("demo").innerHTML = days + "d " + hours + "h "
+ minutes + "m " + seconds + "s ";

if (distance < 0) {
  clearInterval(timer);
  document.getElementById("demo").innerHTML = "EXPIRED";
}
},1000);
</script>
<div id="demo"></div>
    <div class="quizarea">

    </div>
</body>
</html>