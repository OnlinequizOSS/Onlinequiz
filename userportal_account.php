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
    <link rel="stylesheet" href="useraccount.css">
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
    <li onclick="window.location.replace('userportal_results.php')"><i class="fas fa-chart-line"></i>Results</li>
    <li style="background:#72aeeb40; border:1px solid #72aeeb30; color:black;"><i class="fas fa-cog"></i>Account</li>
    </ul>
    </nav>
    <section>
    <?php 
    
    include "dbcon.php";
    $email=$_SESSION['email'];
    $emailquery="select * from user_registration where email='$email'";
    $query=mysqli_query($con,$emailquery);
    $detailsrow= mysqli_fetch_assoc($query);
    echo "your details:";
    echo "<table>";
    echo "<tr>";
    echo "<td>"; echo "First name "; echo "</td>"; echo "<td>";  echo $detailsrow['firstname']; echo "</td>"; echo "</tr>"; 
    echo "<td>"; echo "Last name "; echo "</td>"; echo "<td>";  echo $detailsrow['lastname']; echo "</td>"; echo "</tr>";
    echo "<td>"; echo "Email "; echo "</td>"; echo "<td id='mail'>";  echo $detailsrow['email']; echo "</td>"; echo "</tr>";
    echo "<td>"; echo "Phone "; echo "</td>"; echo "<td>";  echo $detailsrow['phone']; echo "</td>"; echo "</tr>";
    echo "<td>"; echo "Gender "; echo "</td>"; echo "<td>";  echo $detailsrow['gender']; echo "</td>"; echo "</tr>";
    echo "</table>";
    ?>

    <div id="button"><a class="link" href="<?php echo "user_changepassword.php?id=".$detailsrow['id'];?>">Change Password</a></div>
    </section>
</body>
</html>
