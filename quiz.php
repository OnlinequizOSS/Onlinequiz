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
      <div class="container" style="font-size: 30px;">
			<div class="row">
			<div class="col-md-12">

        <?php
        include "dbcon.php";
        $email = $_SESSION['email'];

        if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2 && isset($_SESSION['sessionstart']) && $_SESSION['sessionstart'] == "sessionstart" && $_GET['endquiz'] == 'end') {
            unset($_SESSION['sessionstart']);

            		$q = mysqli_query($con, " UPDATE history SET status='finished' WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error1');
                $q = mysqli_query($con,"SELECT * FROM history WHERE eid={$_GET['eid']} AND email={$_SESSION['email']}") or die('Error2');
                        while ($row = mysqli_fetch_array($q)) {
                            $s = $row['score'];
                            $scorestatus = $row['score_updated'];
                        }
                         if($scorestatus=="false"){
                            $q = mysqli_query($con, "UPDATE history SET score_updated='true' WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error3');
                            $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error4');
                            $rowcount = mysqli_num_rows($q);
                            if ($rowcount == 0) {
                                $q2 = mysqli_query($con, "INSERT INTO rank VALUES(NULL,'$email','$s',NOW())") or die('Error5');
                            } else {
                                while ($row = mysqli_fetch_array($q)) {
                                    $sun = $row['score'];
                                }

                                $sun = $s + $sun;
                                $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error6');
                            }
                        }
                    header('location:userportal_results.php?&eid=' . $_GET['eid']);
        }

        if ($_GET['q'] == 'quiz' && $_GET['step'] == 2 && isset($_GET['start']) && $_GET['start'] == "start" && (!isset($_SESSION['sessionstart']))) {
            $q = mysqli_query($con, "SELECT * FROM history WHERE email='$email' AND eid={$_GET['eid']} ") ;
						$rowcount = mysqli_num_rows($q);

            if ($rowcount == 0){        //when test is clicked start
                $time = time();
                $q = mysqli_query($con, "INSERT INTO history VALUES(NULL,'$email',{$_GET['eid']} ,'0','0','0','0',NOW(),'$time','ongoing','false')") or die('Error16');
                $_SESSION['sessionstart'] = "sessionstart";
                header('location:quiz.php?q=quiz&step=2&eid=' . $_GET['eid'] . '&n=' . $_GET['n'] . '&t=' . $_GET['t']);
            }else {
                $q = mysqli_query($con, "SELECT * FROM history WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error8');
                while ($row = mysqli_fetch_array($q)) {
                    $timel  = $row['timestamp'];
                    $status = $row['status'];
                }
                $q = mysqli_query($con, "SELECT * FROM quiz WHERE quizid={$_GET['eid']} ") or die('Error9');
                while ($row = mysqli_fetch_array($q)) {
                    $ttimel  = $row['testtime'];
                    $qstatus = $row['status'];
                }
                $remaining = (($ttimel * 60) - ((time() - $timel)));
                if ($status == "ongoing" && $remaining > 0 && $qstatus == "enabled") {
                    $_SESSION['sessionstart'] = "sessionstart";
                    header('location:quiz.php?q=quiz&step=2&eid=' . $_GET['eid'] . '&n=' . $_GET['n'] . '&t=' . $_GET['t']);

                } else {
                        $q = mysqli_query($con, "UPDATE history SET status='finished' WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error10');
                $q = mysqli_query($con, "SELECT * FROM history WHERE eid={$_GET['eid']} AND email={$_SESSION['email']}") or die('Error11');
                        while ($row = mysqli_fetch_array($q)) {
                            $s = $row['score'];
                            $scorestatus = $row['score_updated'];
                        }
                         if($scorestatus=="false"){
                            $q = mysqli_query($con, "UPDATE history SET score_updated='true' WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error12');
                            $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error13');
                            $rowcount = mysqli_num_rows($q);
                            if ($rowcount == 0) {
                                $q2 = mysqli_query($con, "INSERT INTO rank VALUES(NULL,'$email','$s',NOW())") or die('Error14');
                            } else {
                                while ($row = mysqli_fetch_array($q)) {
                                    $sun = $row['score'];
                                }

                                $sun = $s + $sun;
                                $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error15');
                            }
                        }
                    header('location:userportal_results.php?&eid=' . $_GET['eid']);
                }

            }
        }


        if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2 && isset($_SESSION['sessionstart']) && $_SESSION['sessionstart'] == "sessionstart") {
            $q = mysqli_query($con, "SELECT * FROM history WHERE email='$email' AND eid={$_GET['eid']} ") or die('Error17');

            if (mysqli_num_rows($q) > 0) {
                $q = mysqli_query($con, "SELECT * FROM history WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error18');
                while ($row = mysqli_fetch_array($q)) {
                    $time   = $row['timestamp'];
                    $status = $row['status'];
                }
                $q = mysqli_query($con, "SELECT * FROM quiz WHERE quizid={$_GET['eid']} ") or die('Error19');
                while ($row = mysqli_fetch_array($q)) {
                    $ttime   = $row['testtime'];
                    $qstatus = $row['status'];
                }
                $remaining = (($ttime * 60) - ((time() - $time)));
                if ($status == "ongoing" && $remaining > 0 && $qstatus == "enabled") {
                    $q = mysqli_query($con, "SELECT * FROM history WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error20');
                    while ($row = mysqli_fetch_array($q)) {
                        $time = $row['timestamp'];
                    }
                    $q = mysqli_query($con, "SELECT * FROM quiz WHERE quizid={$_GET['eid']} ") or die('Error21');
                    while ($row = mysqli_fetch_array($q)) {
                        $ttime = $row['testtime'];
                    }
                    $remaining = (($ttime * 60) - ((time() - $time)));
        echo '<script>
        var seconds = ' . $remaining . ' ;
        function end(){
          data = prompt("Are you sure to end this Quiz? Remember, once finished, you wont be able to continue anymore and final results will be displayed. If you want to continue then enter \\"yes\\" in the textbox below and press enter");
          if(data=="yes"){
            window.location ="quiz.php?q=quiz&step=2&eid=' . $_GET['eid'] . '&n=' . $_GET['n'] . '&t=' . $_GET['total'] . '&endquiz=end";
          }
        }
        function enable(){
          document.getElementById("sbutton").removeAttribute("disabled");

        }
        function frmreset(){
          document.getElementById("sbutton").setAttribute("disabled","true");
          document.getElementById("qform").reset();
        }
            function secondPassed() {
            var minutes = Math.round((seconds - 30)/60);
            var remainingSeconds = seconds % 60;
            if (remainingSeconds < 10) {
                remainingSeconds = "0" + remainingSeconds;
            }
            document.getElementById(\'countdown\').innerHTML = minutes + ":" +    remainingSeconds;
            if (seconds <= 0) {
                clearInterval(countdownTimer);
                document.getElementById(\'countdown\').innerHTML = "Buzz Buzz...";
                window.location ="quiz.php?q=quiz&step=2&eid=' . $_GET['eid'] . '&n=' . $_GET['n'] . '&t=' . $_GET['total'] . '&endquiz=end";
            } else {
                seconds--;
            }
            }
        var countdownTimer = setInterval(\'secondPassed()\', 1000);
        </script>';
                    echo '<font size="3" style="margin-left:100px;font-family:\'typo\' font-size:20px; font-weight:bold;color:darkred">Time Left : </font><span class="timer btn btn-default" style="margin-left:20px;"><font style="font-family:\'typo\';font-size:20px;font-weight:bold;color:darkblue" id="countdown"></font></span><span class="timer btn btn-primary" style="margin-left:50px" onclick="end()"><span class=" glyphicon glyphicon-off"></span>&nbsp;&nbsp;<font style="font-size:12px;font-weight:bold">Finish Quiz</font></span>';   //can call fuction end() and that countdown
                    $eid   = @$_GET['eid'];
                    $sn    = @$_GET['n'];
                    $total = @$_GET['t'];
                    $q     = mysqli_query($con, "SELECT * FROM questable WHERE eid='$eid' AND sn='$sn' ");
                    echo '<div class="panel" style="margin-right:5%;margin-left:5%;margin-top:10px;border-radius:10px">';
                    while ($row = mysqli_fetch_array($q)) {
                        $qns = stripslashes($row['qns']);     //removes backslashes added by addslashes() in addques_admin.php
                        $qid = $row['qid'];
                        echo '<b><pre style="background-color:white"><div style="font-size:20px;font-weight:bold;font-family:calibri;margin:10px">' . $sn . ' : ' . $qns . '</div></pre></b>';
                    }

                    echo '<form id="qform" action="update.php?q=quiz&step=2&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '&qid=' . $qid . '" method="POST"  class="form-horizontal">
        <br />';
                    $q = mysqli_query($con, "SELECT * FROM user_answer WHERE qid='$qid' AND email={$_SESSION['email']} AND eid={$_GET['eid']}") or die("Error22");
                    if (mysqli_num_rows($q) > 0) {
                        $row = mysqli_fetch_array($q);
                        $ans = $row['ans'];
                        $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' AND optionid='$ans'") or die("Error23");
                        $row = mysqli_fetch_array($q);
                        $ans = $row['option'];
                    } else {
                        $ans = "";
                    }
                    if (strlen($ans) > 0) {
                        echo "<font style=\"color:green;font-size:12px;font-weight:bold\">Selected answer: </font><font style=\"color:#565252;font-size:12px;\">" . $ans . "</font>&nbsp;&nbsp;<a href=update.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total&qid=$qid&delanswer=delanswer><span class=\"glyphicon glyphicon-remove\" style=\"font-size:12px;color:darkred\"></span></a><br /><br />";
                    }
                    echo '<div class="funkyradio">';
                    $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' ");   //display the options per question
                    while ($row = mysqli_fetch_array($q)) {
                        $option   = stripslashes($row['option']);
                        $optionid = $row['optionid'];
                        echo '<div class="funkyradio-success"><input type="radio" id="' . $optionid . '" name="ans" value="' . $optionid . '" onclick="enable()"> <label for="' . $optionid . '" style="width:50%"><div style="color:black;font-size:12px;word-wrap:break-word">&nbsp;&nbsp;' . $option . '</div></label></div>';
                    }
                    echo '</div>';
                    if ($_GET['t'] > $_GET['n'] && $_GET['n'] != 1) {
                        echo '<br /><a href="quiz.php?q=quiz&step=2&eid=' . $eid . '&n=' . ($sn - 1) . '&t=' . $total . '" class="btn btn-primary" style="height:30px"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"  style="font-size:12px"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-default" disabled="true" id="sbutton" style="height:30px"><span class="glyphicon glyphicon-lock" style="font-size:12px" aria-hidden="true"></span><font style="font-size:12px;font-weight:bold"> Lock</font></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="frmreset()" style="height:30px"></span><font style="font-size:12px;font-weight:bold">Reset</font></button>&nbsp;&nbsp;&nbsp;&nbsp;<a href="quiz.php?q=quiz&step=2&eid=' . $eid . '&n=' . ($sn + 1) . '&t=' . $total . '" class="btn btn-primary" style="height:30px"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"  style="font-size:12px"></span></a></form><br><br>';
                    } else if ($_GET['t'] == $_GET['n']) {
                        echo '<br /><a href="quiz.php?q=quiz&step=2&eid=' . $eid . '&n=' . ($sn - 1) . '&t=' . $total . '" class="btn btn-primary" style="height:30px"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"  style="font-size:12px"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-default" disabled="true" id="sbutton" style="height:30px"><span class="glyphicon glyphicon-lock" style="font-size:12px" aria-hidden="true"></span><font style="font-size:12px;font-weight:bold"> Lock</font></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="frmreset()" style="height:30px"></span><font style="font-size:12px;font-weight:bold">Reset</font></button>&nbsp;&nbsp;&nbsp;&nbsp;</form><br><br>';
                    } else if ($_GET['t'] > $_GET['n'] && $_GET['n'] == 1) {
                        echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-default" disabled="true" id="sbutton" style="height:30px"><span class="glyphicon glyphicon-lock" style="font-size:12px" aria-hidden="true"></span><font style="font-size:12px;font-weight:bold"> Lock<font></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="frmreset()" style="height:30px"></span><font style="font-size:12px;font-weight:bold">Reset</font></button>&nbsp;&nbsp;&nbsp;&nbsp;<a href="quiz.php?q=quiz&step=2&eid=' . $eid . '&n=' . ($sn + 1) . '&t=' . $total . '" class="btn btn-primary" style="height:30px"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"  style="font-size:12px"></span></a></form><br><br>';
                    } else {
                    }
                    echo '</div>';
                    echo '<div class="panel" style="text-align:center">';
                    $q = mysqli_query($con, "SELECT * FROM questable WHERE eid={$_GET['eid']}") or die("Error24");
                    $i = 1;
                    while ($row = mysqli_fetch_array($q)) {
                        $ques[$row['qid']] = $i;
                        $i++;
                    }
                    $q = mysqli_query($con, "SELECT * FROM user_answer WHERE eid={$_GET['eid']} AND email={$_SESSION['email']}") or die("Error25");
                    $i = 1;
                    while ($row = mysqli_fetch_array($q)) {
                        if (isset($ques[$row['qid']])) {
                            $quesans[$ques[$row['qid']]] = true;
                        }
                    }
                    for ($i = 1; $i <= $total; $i++) {
                        echo '<a href="quiz.php?q=quiz&step=2&eid=' . $eid . '&n=' . $i . '&t=' . $total . '"  style="margin:5px;padding:5px;background-color:';
                        if ($quesans[$i]) {
                            echo "darkgreen";
                        } else {
                            echo "darkred";
                        }
                        echo ';color:white;font-size:16px;font-family:calibri;border-radius:4px">&nbsp;' . $i . '&nbsp;</a>';
                    }
                } else {
                    unset($_SESSION['sessionstart']);
                    $q = mysqli_query($con, "UPDATE history SET status='finished' WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error26');
                $q = mysqli_query($con, "SELECT * FROM history WHERE eid={$_GET['eid']} AND email={$_SESSION['email']}") or die('Error27');
                        while ($row = mysqli_fetch_array($q)) {
                            $s = $row['score'];
                            $scorestatus = $row['score_updated'];
                        }
                         if($scorestatus=="false"){
                            $q = mysqli_query($con, "UPDATE history SET score_updated='true' WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error28');
                            $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error29');
                            $rowcount = mysqli_num_rows($q);
                            if ($rowcount == 0) {
                                $q2 = mysqli_query($con, "INSERT INTO rank VALUES(NULL,'$email','$s',NOW())") or die('Error30');
                            } else {
                                while ($row = mysqli_fetch_array($q)) {
                                    $sun = $row['score'];
                                }

                                $sun = $s + $sun;
                                $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error31');
                            }
                        }
                    header('location:userportal_results.php?&eid=' . $_GET['eid']);
                }
            } else {
                unset($_SESSION['sessionstart']);
                $q = mysqli_query($con, "UPDATE history SET status='finished' WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error32');
                $q = mysqli_query($con, "SELECT * FROM history WHERE eid={$_GET['eid']} AND email={$_SESSION['email']}") or die('Error33');
                        while ($row = mysqli_fetch_array($q)) {
                            $s = $row['score'];
                            $scorestatus = $row['score_updated'];
                        }
                        if($scorestatus=="false"){
                            $q = mysqli_query($con, "UPDATE history SET score_updated='true' WHERE email={$_SESSION['email']} AND eid={$_GET['eid']} ") or die('Error34');
                            $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'") or die('Error35');
                            $rowcount = mysqli_num_rows($q);
                            if ($rowcount == 0) {
                                $q2 = mysqli_query($con, "INSERT INTO rank VALUES(NULL,'$email','$s',NOW())") or die('Error36');
                            } else {
                                while ($row = mysqli_fetch_array($q)) {
                                    $sun = $row['score'];
                                }

                                $sun = $s + $sun;
                                $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error37');
                            }
                        }
                    header('location:userportal_results.php?&eid=' . $_GET['eid']);
            }
        }



?>
      </div></div></div>
    </section>
</body>
</html>
