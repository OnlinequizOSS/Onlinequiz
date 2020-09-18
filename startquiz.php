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

$server="localhost";
$user="root";
$password="";
$db="quizickle";
$question="";
$next=1;
$prev=1;

$option=array("What is C?","a letter","a language","NO idea","NUll"); 
$conn=mysqli_connect($server,$user,$password,$db);
if(isset($_POST["next"]))
{  @$chosen=$_POST["op"];
  echo @$chosen;
//echo $next;
$sql="SELECT * FROM questable where qid='$next'";
//$sqla="select * from answers where qn='1'";
$sqla = "SELECT optionid,option
    FROM 
    options
    WHERE qid ='$next'";
$res=mysqli_query($conn,$sql);
$resa=mysqli_query($conn,$sqla);
$sqan="SELECT * FROM answer WHERE qid='$next'";
$crct=mysqli_query($conn,$sqan);
$crctop=mysqli_fetch_assoc($crct);
$userquery="SELECT  * FROM user_response WHERE exam_id=1";
 $score=mysqli_query($conn,$userquery);
 $score_res=mysqli_fetch_assoc($score);
 $val=$score_res["score"];
  //echo $score_res["score"];
  if($chosen)
  {
 if($chosen!=$crctop["ansid"])
{
  $update="UPDATE user_response SET score=$val-1 WHERE exam_id=1";
  mysqli_query($conn,$update);
}
else{
  $update="UPDATE user_response SET score=$val+1 WHERE exam_id=1";
  mysqli_query($conn,$update);
 
}
  }
$result=mysqli_fetch_assoc($res);
//$options=mysqli_fetch_row($resa);
$options = array();
while ($row = mysqli_fetch_array($resa))
{
    $options[] = array($row['optionid'],$row['option']);
}
$i=1;
$option[0]=$result["qns"];
foreach($options as $a)
{
  $option[$i++ ]=$a[1];
  //echo $a[2];
}
}
if(isset($_POST["back"]))
{ 
  if($next>1)
  {
    $prev=$next-1;
  }
$sql="SELECT * FROM questions where qn='$prev'";
//$sqla="select * from answers where qn='1'";
$sqla = "SELECT option,text
    FROM 
    answers
    WHERE id =$next";
$res=mysqli_query($conn,$sql);
$resa=mysqli_query($conn,$sqla);
$result=@mysqli_fetch_assoc($res);
//$options=mysqli_fetch_row($resa);
$options = array();
while ($row = @mysqli_fetch_array($resa))
{
    $options[] = array($row['option'],$row['text']);
}
$i=1;
$option[0]=$result["text"];
foreach($options as $a)
{
  $option[$i++ ]=$a[1];
  //echo $option[$i-1];
}
}
//echo $options[0];
//echo $result["text"];

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="insertscore.css" rel="stylesheet">
    <link rel="stylesheet" href="startsquiz.css">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        p,
label {
    font: 1rem 'Fira Sans', sans-serif;
}

input {
    margin: .4rem;
}

    </style>
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
}
},1000);
</script>
<div id="timer"></div>
<div id="quizarea">
            <p><?php echo $option[0]; ?></p>
  <form method="post" id="data" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI']));?>" onsubmit="formsubmit()">    
  <ol>
    <li><input type="radio" name="op" value="1"/><?php echo $option[1];?></td></li>
    <li><input type="radio" name="op" value="2"/><?php echo $option[2];?></td></li>
    <li><input type="radio" name="op" value="3"/><?php echo $option[3];?></td></li>
    <li><input type="radio" name="op" value="4"/><?php echo $option[4];?></td></li>
  </ol>
<button class="btn" name="next" id="next">Next</button>
<button class="btn" name="back"id="prev">Previous</button>
</form>
</div>  
        </body>
        <script>
          function formsubmit()
          {
            $.ajax({
              type:'POST',
              url:'insert.php',
              data:$('#data').serialize(),
              sucess: null
            });
            return false;
          }
      
        </script>
    </html>
