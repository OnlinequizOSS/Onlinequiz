<?php
session_start();
if(!isset($_SESSION['name']))
{
	header("location:user_login.php");
}
$quizid=$_GET['n'];
$total=$_GET['total'];
$dur=$_GET['dur'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2f57eae505.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="userportal.css">
    <title>Student Portal</title>
    <style>
    .goback{
      width:150px;
      border-radius:7px;
      color:white;
      background:green;
      text-decoration:none;
      line-height:45px;
      margin:auto;
      text-align:center;
    }
    .goback:hover{
      background:#8aa779;
    }
    </style>
</head>
<body>
    <header>
    <div id="quizickle">Quizickle</div>
    <div id="logout"><a href="user_logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></div>
    </header>
    <nav>
    <ul>
      <li onclick="window.location.replace('userportal.php')"><i class="fas fa-home"></i>Home</li>
      <li style="background:#72aeeb40; border:1px solid #72aeeb30; color:black;"><i class="far fa-file-alt"></i>Quizzes</li>
      <li onclick="window.location.replace('userportal_results.php')"><i class="fas fa-chart-line"></i>Results</li>
      <li onclick="window.location.replace('userportal_account.php')"><i class="fas fa-cog"></i>Account</li>
    </ul>
    </nav>
    <?php
    echo '</table></div><div class="panel" ><h3 class="instruct">:: General Instructions ::</h3><br />';
    $file = fopen("instructions.txt", "r");
    while(!feof($file)){
      $line = fgets($file);
      echo $line. "<br >";
    }
    fclose($file);
    echo '</div>';

    ?>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <a href="startquiz.php?n=<?php echo $quizid ?>&total=<?php echo $total ?>&dur=<?php echo $dur ?>" class="goback">Go to Quiz</a>
</body>
</html>
