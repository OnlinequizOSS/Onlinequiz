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
		include "dbcon.php";
		$email = $_SESSION['email'];

		// if (@$_GET['q'] == 'result' && @$_GET['eid']) {
				$eid = @$_GET['eid'];
				$q = mysqli_query($con, "SELECT * FROM quiz WHERE quizid='$eid' ") or die('Error157');
				while ($row = mysqli_fetch_array($q)) {
						$total = $row['totalques'];
				}
				$q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error157');

				while ($row = mysqli_fetch_array($q)) {
						$s      = $row['score'];
						$w      = $row['wrong'];
						$r      = $row['correct'];
						$status = $row['status'];
				}
				if ($status == "finished") {
						echo '<div class="panel">
						<h1 class="title" style="color:#660033; text-align:center;">Result</h1><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';
						echo '<tr style="color:darkblue"><td style="vertical-align:middle">Total Questions</td><td style="vertical-align:middle">' . $total . '</td></tr>
					<tr style="color:darkgreen"><td style="vertical-align:middle">Correct Answer&nbsp;<span class="glyphicon glyphicon-ok-arrow" aria-hidden="true"></span></td><td style="vertical-align:middle">' . $r . '</td></tr>
				<tr style="color:red"><td style="vertical-align:middle">Wrong Answer&nbsp;<span class="glyphicon glyphicon-remove-arrow" aria-hidden="true"></span></td><td style="vertical-align:middle">' . $w . '</td></tr>
				<tr style="color:orange"><td style="vertical-align:middle">Unattempted&nbsp;<span class="glyphicon glyphicon-ban-arrow" aria-hidden="true"></span></td><td style="vertical-align:middle">' . ($total - $r - $w) . '</td></tr>
				<tr style="color:darkblue"><td style="vertical-align:middle">Score&nbsp;<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td><td style="vertical-align:middle">' . $s . '</td></tr>';
						$q = mysqli_query($con, "SELECT * FROM rank WHERE  email='$email' ") or die('Error157');
						while ($row = mysqli_fetch_array($q)) {
								$s = $row['score'];
								echo '<tr style="color:#990000"><td style="vertical-align:middle">Overall Score&nbsp;<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td style="vertical-align:middle">' . $s . '</td></tr>';
						}
						echo '<tr></tr></table></div>';
				} else {
						die("Thats a 404 Error bro. You are trying to access a wrong page");
				}
		// }
    ?>
    </section>
</body>
</html>
