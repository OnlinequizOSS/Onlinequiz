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

			<div class="container " style="font-size:25px;">
			<div class="row">
			<div class="col-md-12">

<?php
			include "dbcon.php";
			$email = $_SESSION['email'];

		    $result = mysqli_query($con, "SELECT * FROM quiz WHERE status = 'enabled' ORDER BY id DESC") or die('Error');
		    echo '<div class="panel"><table class="table table-striped title1"  style="vertical-align:middle">
		<tr><td style="vertical-align:middle"><b>S.N.</b></td><td style="vertical-align:middle"><b>Name</b></td><td style="vertical-align:middle"><b>Total question</b></td><td style="vertical-align:middle"><b>Marks per correct Answer</b></td><td style="vertical-align:middle"><b>Marks per wrong answer</b></td><td style="vertical-align:middle"><b>Total Marks</b></td><td style="vertical-align:middle"><b>Time limit</b></td><td style="vertical-align:middle"><b>Action</b></td></tr>';
		    $c = 1;
		    while ($row = mysqli_fetch_array($result)) {
		        $title   = $row['quizname'];
		        $total   = $row['totalques'];
		        $correct = $row['correctno'];
		        $wrong   = $row['wrongno'];
		        $time    = $row['testtime'];
		        $eid     = $row['quizid'];
		        $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'")or die('Error98') ;
		        $rowcount = mysqli_num_rows($q12);
		        if ($rowcount == 0) {  //start test
		            echo '<tr><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle">' . $title . '</td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">+' . $correct . '</td><td style="vertical-align:middle">-' . $wrong . '</td><td style="vertical-align:middle">' . $correct * $total . '</td><td style="vertical-align:middle">' . $time . '&nbsp;min</td>
		  <td style="vertical-align:middle"><b><a href="quiz.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '&start=start" class="btn" style="color:#FFFFFF;background:darkgreen;font-size:12px;padding:7px;padding-left:10px;padding-right:10px"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span><b>Start</b></span></a></b></td></tr>';
		        } else {
		            $q = mysqli_query($con, "SELECT * FROM history WHERE email='$_SESSION[email]' AND eid='$eid' ") or die('Error197');
		            while ($row = mysqli_fetch_array($q)) {
		                $timec  = $row['timestamp'];
		                $status = $row['status'];
		            }
		            $q = mysqli_query($con, "SELECT * FROM quiz WHERE quizid='$eid' ") or die('Error197');
		            while ($row = mysqli_fetch_array($q)) {
		                $ttimec  = $row['testtime'];
		                $qstatus = $row['status'];
		            }
		            $remaining = (($ttimec * 60) - ((time() - $timec)));
		            if ($remaining > 0 && $qstatus == "enabled" && $status == "ongoing") {   //continue test
		                echo '<tr style="color:darkgreen"><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle">' . $title . '&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">+' . $correct . '</td><td style="vertical-align:middle">-' . $wrong . '</td><td style="vertical-align:middle">' . $correct * $total . '</td><td style="vertical-align:middle">' . $time . '&nbsp;min</td>
		  <td style="vertical-align:middle"><b><a href="quiz.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '&start=start" class="btn" style="margin:0px;background:darkorange;color:white">&nbsp;<span class="title1"><b>Continue</b></span></a></b></td></tr>';
		}
		else {	//finished test view result
		                echo '<tr style="color:darkgreen"><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle">' . $title . '&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">+' . $correct . '</td><td style="vertical-align:middle">-' . $wrong . '</td><td style="vertical-align:middle">' . $correct * $total . '</td><td style="vertical-align:middle">' . $time . '&nbsp;min</td>
		  <td style="vertical-align:middle"><b><a href="userportal_results.php?eid=' . $eid . '" class="btn" style="margin:0px;background:darkred;color:white">&nbsp;<span class="title1"><b>View Result</b></span></a></b></td></tr>';
		            }
		        }
		    }
		    $c = 0;
		    echo '</table></div><div class="panel" style="padding-top:1px;padding-left:15%;padding-right:15%;word-wrap:break-word"><h3 align="center" style="font-family:calibri">:: General Instructions ::</h3><br />';
		    $file = fopen("instructions.txt", "r");
		    // while (!feof($file)) {    //until the end of file is reached
		    //     echo '<li>';
		    //     $string = fgets($file);
		    //     $num    = strlen($string) - 1;
		    //     $c      = str_split($string);
		    //     for ($i = 1; $i <= $num; $i++) {
		    //         $last = $c[$i - 1];
		    //         if ($c[$i] == ' ' && $last == ' ') {
		    //             echo '&nbsp;'; //non breaking space
		    //         } else {
		    //             echo $c[$i];
		    //         }
		    //     }
		    //     echo "</li><br />";
		    // }
				while(!feof($file)){
					$line = fgets($file);
					echo $line. "<br >";
				}
		    fclose($file);
		    echo '</div>';

		  ?>
			</div></div></div>
    </section>
</body>
</html>
