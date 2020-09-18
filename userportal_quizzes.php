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
    <li style="background:#72aeeb40; border:1px solid #72aeeb30; color:black;"><i class="far fa-file-alt"></i>Quizzes</li>
    <li onclick="window.location.replace('userportal_results.php')"><i class="fas fa-chart-line"></i>Results</li>
    <li onclick="window.location.replace('userportal_account.php')"><i class="fas fa-cog"></i>Account</li>
    </ul>
    </nav>
    <section>
    <?php 
    include "dbcon.php";
    $query="select * from quiz where status='enabled' ";
    $res=mysqli_query($con,$query);
    echo "<table>";
    echo "<tr><th>Quiz name</th> <th>No. of questions</th><th>Marks per correct Answer</th><th>Marks per wrong answer</th><th>Attempt Quiz</th></tr>";
    while($row = mysqli_fetch_array($res)){
        echo "<tr><td>" . $row['quizname'] . "</td><td>" . $row['totalques'] . "</td><td>" . $row['correctno'] . "</td><td>" . $row['wrongno'] . "</td><td>"; ?>  <a href="instructions.php?n=<?php echo $row['quizid'] ?>&total=<?php echo $row['totalques'] ?>&dur=<?php echo $row['testtime'] ?>" id="attempt">Attempt quiz</a> <?php echo "</td></tr>";
    }
    echo "<table>";
    ?>
    </section>
</body>
</html>