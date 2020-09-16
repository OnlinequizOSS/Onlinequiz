<?php
session_start();
if(!isset($_SESSION['name']))
{
	header("location:user_login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2f57eae505.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="userportal.css">
    <title>Student Portal</title>
</head>
<body>
    <header>
    <div id="quizickle">Quizickle</div>
    <div id="logout"><a href="user_logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></div>
    </header>
    <nav>
    <ul>
    <li onclick="window.location.replace('userportal.php')"><i class="fas fa-home"></i>Home</li>
    <li onclick="window.location.replace('userportal_quizzes.php')"><i class="far fa-file-alt"></i>Quizzes</li>
    <li style="background:#72aeeb40; border:1px solid #72aeeb30; color:black;"><i class="fas fa-chart-line"></i>Results</li>
    <li onclick="window.location.replace('userportal_account.php')"><i class="fas fa-cog"></i>Account</li>
    </ul>
    </nav>
    <section>
    <?php 
    echo "Hello!<br>";
    echo $_SESSION['name']; 
    
    ?>
    </section>
</body>
</html>