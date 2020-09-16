<?php
	session_start();
include 'db.php';
 if (!isset($_SESSION["adminlogin"])) {
   ?>
   <script type="text/javascript">
     window.location="index.php";
   </script>
<?php
 }
 $email = $_SESSION['email'];

     if (@$_GET['q'] == 'addqu') {
         $name    = $_POST['quizname'];
         $name    = ucwords(strtolower($name));  //capitalizes first word
         $total   = $_POST['totalques'];
         $correct = $_POST['correctno'];
         $wrong   = $_POST['wrongno'];
         $time    = $_POST['testtime'];
         $status  = "disabled";
         $id      = uniqid();
         $q3      = mysqli_query($connection, "INSERT INTO quiz VALUES(NULL,'$id','$name','$total','$correct','$wrong','$time', 'NOW()','$status')");
         header("location:addques_admin.php?eid=$id&n=$total");
     }

     if ($_GET['q'] == 'addqns') {
         $n   = @$_GET['n'];
         $eid = @$_GET['eid'];
         $ch  = @$_GET['ch'];
         for ($i = 1; $i <= $n; $i++) {
             $qid  = uniqid();
             $qns  = addslashes($_POST['qns' . $i]);
             $q3   = mysqli_query($connection, "INSERT INTO questable VALUES  (NULL,'$eid','$qid','$qns', '$ch','$i')") or die();
             $oaid = uniqid();
             $obid = uniqid();
             $ocid = uniqid();
             $odid = uniqid();
             $a    = addslashes($_POST[$i . '1']);
             $b    = addslashes($_POST[$i . '2']);
             $c    = addslashes($_POST[$i . '3']);
             $d    = addslashes($_POST[$i . '4']);
             $qa = mysqli_query($connection, "INSERT INTO options VALUES  (NULL,'$qid','$a','$oaid')") or die('Error61');
             $qb = mysqli_query($connection, "INSERT INTO options VALUES  (NULL,'$qid','$b','$obid')") or die('Error62');
             $qb = mysqli_query($connection, "INSERT INTO options VALUES  (NULL,'$qid','$c','$ocid')") or die('Error63'.mysqli_error($connection));
             $qd = mysqli_query($connection, "INSERT INTO options VALUES  (NULL,'$qid','$d','$odid')") or die('Error64');
             $e = $_POST['ans' . $i];
             switch ($e) {
                 case 'a':
                     $ansid = $oaid;
                     break;

                 case 'b':
                     $ansid = $obid;
                     break;

                 case 'c':
                     $ansid = $ocid;
                     break;

                 case 'd':
                     $ansid = $odid;
                     break;

                 default:
                     $ansid = $oaid;
             }

             $qans = mysqli_query($connection, "INSERT INTO answer VALUES  (NULL,'$qid','$ansid')");
         }

         header("location:home_admin.php");
     }

     if (@$_GET['q'] == 'rmquiz') {
         $eid = @$_GET['eid'];
         $result = mysqli_query($connection, "SELECT * FROM questable WHERE eid='$eid' ") or die('Error');
         while ($row = mysqli_fetch_array($result)) {
             $qid = $row['qid'];
             $r1 = mysqli_query($connection, "DELETE FROM options WHERE qid='$qid'") or die('Error');
             $r2 = mysqli_query($connection, "DELETE FROM answer WHERE qid='$qid' ") or die('Error');
         }

         $r3 = mysqli_query($connection, "DELETE FROM questable WHERE eid='$eid' ") or die('Error');
         $r4 = mysqli_query($connection, "DELETE FROM quiz WHERE quizid='$eid' ") or die('Error');
         // $r4 = mysqli_query($connection, "DELETE FROM history WHERE eid='$eid' ") or die('Error');
         header("location:removequiz_admin.php");
     }

		     if (@$_GET['deidquiz'] ) {
		         $eid = @$_GET['deidquiz'];
		         $r1 = mysqli_query($connection, "UPDATE quiz SET status='disabled' WHERE quizid='$eid' ") or die('Error');
		         $q = mysqli_query($connection, "SELECT * FROM history WHERE eid='$eid' AND status='ongoing' AND score_updated='false'");
		         while($row = mysqli_fetch_array($q)){
		             $user = $row['email'];
		             $s = $row['score'];
		             $r1 = mysqli_query($connection, "UPDATE history SET status='finished',score_updated='true' WHERE eid='$eid' AND email='$user' ") or die('Error');
		             $q1 = mysqli_query($connection, "SELECT * FROM rank WHERE email='$user'") or die('Error161');
		             $rowcount = mysqli_num_rows($q1);
		             if ($rowcount == 0) {
		                 $q2 = mysqli_query($connection, "INSERT INTO rank VALUES(NULL,'$user','$s',NOW())") or die('Error165');
		             } else {
		                 while ($row = mysqli_fetch_array($q1)) {
		                     $sun = $row['score'];
		                 }

		                 $sun = $s + $sun;
		                 $q3 = mysqli_query($connection, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error174');
		             }
		         }
		         header("location:home_admin.php");
		     }

		     if (@$_GET['eeidquiz'] ) {
		         $eid = @$_GET['eeidquiz'];
		         $r1 = mysqli_query($connection, "UPDATE quiz SET status='enabled' WHERE quizid='$eid' ") or die('Error');
		         header("location:home_admin.php");
		     }

		 if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2 && isset($_SESSION['sessionstart']) && $_SESSION['sessionstart'] == "sessionstart" && isset($_POST['ans']) && (!isset($_GET['delanswer']))) {
	 	    $eid   = @$_GET['eid'];
	 	    $sn    = @$_GET['n'];
	 	    $total = @$_GET['t'];
	 	    $ans   = $_POST['ans'];
	 	    $qid   = @$_GET['qid'];
	 	    $q = mysqli_query($connection, "SELECT * FROM history WHERE email='$email' AND eid={$_GET[eid]} ") or die('Error197');
	 	    if (mysqli_num_rows($q) > 0) {
	 	        $q = mysqli_query($connection, "SELECT * FROM history WHERE email={$_session[email]} AND eid={$_GET[eid]} ") or die('Error197');
	 	        while ($row = mysqli_fetch_array($q)) {
	 	            $time   = $row['timestamp'];
	 	            $status = $row['status'];
	 	        }

	 	        $q = mysqli_query($connection, "SELECT * FROM quiz WHERE quizid={$_GET[eid]} ") or die('Error197');
	 	        while ($row = mysqli_fetch_array($q)) {
	 	            $ttime   = $row['testtime'];
	 	            $qstatus = $row['status'];
	 	        }

	 	        $remaining = (($ttime * 60) - ((time() - $time)));
	 	        if ($status == "ongoing" && $remaining > 0 && $qstatus == "enabled") {
	 	            $q = mysqli_query($connection, "SELECT * FROM user_answer WHERE eid={$_GET[eid]} AND email={$_session[email]} AND qid='$qid' ") or die('Error115');
	 	            while ($row = mysqli_fetch_array($q)) {
	 	                $prevans = $row['ans'];
	 	            }
	 	            $q = mysqli_query($connection, "SELECT * FROM answer WHERE qid='$qid' ");
	 	            while ($row = mysqli_fetch_array($q)) {
	 	                $ansid = $row['ansid'];
	 	            }
	 	            $q = mysqli_query($connection, "SELECT * FROM user_answer WHERE email={$_session[email]} AND eid={$_GET[eid]} AND qid='$qid' ") or die('Error1977');
	 	            if (mysqli_num_rows($q) != 0) {
	 	                $q = mysqli_query($connection, "UPDATE user_answer SET ans='$ans' WHERE email={$_session[email]} AND eid={$_GET[eid]} AND qid='$qid' ") or die('Error197');
	 	            } else {
	 	                $q = mysqli_query($connection, "INSERT INTO user_answer VALUES(NULL,'$qid','$ans','$ansid',{$_GET[eid]},{$_session[email]})");
	 	            }

	 	            $q = mysqli_query($connection, "SELECT * FROM options WHERE qid='$qid' AND optionid='$ans'");
	 	            while ($row = mysqli_fetch_array($q)) {
	 	                $option = $row['option'];
	 	            }


	 	            if ($ans == $ansid) {
	 	                $q = mysqli_query($connection, "SELECT * FROM quiz WHERE quizid='$eid' ");
	 	                while ($row = mysqli_fetch_array($q)) {
	 	                    $correct = $row['correctno'];
	 	                    $wrong   = $row['wrongno'];
	 	                }

	 	                $q = mysqli_query($connection, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error115');
	 	                while ($row = mysqli_fetch_array($q)) {
	 	                    $s = $row['score'];
	 	                    $r = $row['correct'];
	 	                    $w = $row['wrong'];
	 	                }

	 	                if (isset($prevans) && $prevans == $ansid) {
	 	                } else if (isset($prevans) && $prevans != $ansid) {
	 	                    $r++;
	 	                    $w--;
	 	                    $s = $s + $correct + $wrong;
	 	                    $q = mysqli_query($connection, "UPDATE `history` SET `score`=$s,`level`=$sn,`correct`=$r,`wrong`=$w, date= NOW()  WHERE  email = '$email' AND eid = '$eid'") or die('Error13');
	 	                } else {
	 	                    $r++;
	 	                    $s = $s + $correct;
	 	                    $q = mysqli_query($connection, "UPDATE `history` SET `score`=$s,`level`=$sn,`correct`=$r, date= NOW()  WHERE  email = '$email' AND eid = '$eid'") or die('Error14');
	 	                }
	 	            } else {
	 	                $q = mysqli_query($connection, "SELECT * FROM quiz WHERE quizid='$eid' ") or die('Error129');
	 	                while ($row = mysqli_fetch_array($q)) {
	 	                    $wrong   = $row['wrongno'];
	 	                    $correct = $row['correctno'];
	 	                }

	 	                $q = mysqli_query($connection, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error139');
	 	                while ($row = mysqli_fetch_array($q)) {
	 	                    $s = $row['score'];
	 	                    $w = $row['wrong'];
	 	                    $r = $row['correct'];
	 	                }
	 	                if (isset($prevans) && $prevans != $ansid) {
	 	                } else if (isset($prevans) && $prevans == $ansid) {
	 	                    $r--;
	 	                    $w++;
	 	                    $s = $s - $correct - $wrong;
	 	                    $q = mysqli_query($connection, "UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w,`correct`=$r, date= NOW()  WHERE  email = '$email' AND eid = '$eid'") or die('Error11');
	 	                } else {
	 	                    $w++;
	 	                    $s = $s - $wrong;
	 	                    $q = mysqli_query($connection, "UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w,date= NOW()  WHERE  email = '$email' AND eid = '$eid'") or die('Error12');
	 	                }
	 	            }
	 	            header("location:quiz.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total") or die('Error152');

	 	        } else {
	 	            unset($_SESSION['sessionstart']);
	 	            $q = mysqli_query($connection, "UPDATE history SET status='finished' WHERE email={$_session[email]} AND eid={$_GET[eid]} ") or die('Error197');
	 	        $q = mysqli_query($connection, "SELECT * FROM history WHERE eid={$_GET[eid]} AND email={$_session[email]}") or die('Error156');
	 	                while ($row = mysqli_fetch_array($q)) {
	 	                    $s = $row['score'];
	 	                    $scorestatus = $row['score_updated'];
	 	                }
	 	                if($scorestatus=="false"){
	 	                    $q = mysqli_query($connection, "UPDATE history SET score_updated='true' WHERE email={$_session[email]} AND eid={$_GET[eid]} ") or die('Error197');
	 	                    $q = mysqli_query($connection, "SELECT * FROM rank WHERE email='$email'") or die('Error161');
	 	                    $rowcount = mysqli_num_rows($q);
	 	                    if ($rowcount == 0) {
	 	                        $q2 = mysqli_query($connection, "INSERT INTO rank VALUES(NULL,'$email','$s',NOW())") or die('Error165');
	 	                    } else {
	 	                        while ($row = mysqli_fetch_array($q)) {
	 	                            $sun = $row['score'];
	 	                        }

	 	                        $sun = $s + $sun;
	 	                        $q = mysqli_query($connection, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error174');
	 	                    }
	 	                }
	 	            header('location:userportal_results.php?eid=' . $_GET[eid]);
	 	        }
	 	    } else {
	 	        unset($_SESSION['sessionstart']);
	 	        $q = mysqli_query($connection, "UPDATE history SET status='finished' WHERE email={$_session[email]} AND eid={$_GET[eid]} ") or die('Error197');
	 	        $q = mysqli_query($connection, "SELECT * FROM history WHERE eid={$_GET[eid]} AND email={$_session[email]}") or die('Error156');
	 	                while ($row = mysqli_fetch_array($q)) {
	 	                    $s = $row['score'];
	 	                    $scorestatus = $row['score_updated'];
	 	                }
	 	                if($scorestatus=="false"){
	 	                    $q = mysqli_query($connection, "UPDATE history SET score_updated='true' WHERE email={$_session[email]} AND eid={$_GET[eid]} ") or die('Error197');
	 	                    $q = mysqli_query($connection, "SELECT * FROM rank WHERE email='$email'") or die('Error161');
	 	                    $rowcount = mysqli_num_rows($q);
	 	                    if ($rowcount == 0) {
	 	                        $q2 = mysqli_query($connection, "INSERT INTO rank VALUES(NULL,'$email','$s',NOW())") or die('Error165');
	 	                    } else {
	 	                        while ($row = mysqli_fetch_array($q)) {
	 	                            $sun = $row['score'];
	 	                        }

	 	                        $sun = $s + $sun;
	 	                        $q = mysqli_query($connection, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error174');
	 	                    }
	 	                }
	 	            header('location:userportal_results.php?eid=' . $_GET[eid]);
	 	    }
	 		}

		if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2 && isset($_SESSION['sessionstart']) && $_SESSION['sessionstart'] == "sessionstart" && (!isset($_POST['ans'])) && (isset($_GET['delanswer'])) && $_GET['delanswer'] == "delanswer") {
			    $eid   = @$_GET['eid'];
			    $sn    = @$_GET['n'];
			    $total = @$_GET['t'];
			    $qid   = @$_GET['qid'];
			    $q = mysqli_query($connection, "SELECT * FROM history WHERE email='$email' AND eid={$_GET[eid]} ") or die('Error197');
			    if (mysqli_num_rows($q) > 0) {
			        $q = mysqli_query($connection, "SELECT * FROM history WHERE email={$_session[email]} AND eid={$_GET[eid]} ") or die('Error197');
			        while ($row = mysqli_fetch_array($q)) {
			            $time   = $row['timestamp'];
			            $status = $row['status'];
			        }

			        $q = mysqli_query($connection, "SELECT * FROM quiz WHERE quizid={$_GET[eid]} ") or die('Error197');
			        while ($row = mysqli_fetch_array($q)) {
			            $ttime   = $row['testtime'];
			            $qstatus = $row['status'];
			        }

			        $remaining = (($ttime * 60) - ((time() - $time)));
			        if ($status == "ongoing" && $remaining > 0 && $qstatus == "enabled") {
			            $q = mysqli_query($connection, "SELECT * FROM answer WHERE qid='$qid' ");
			            while ($row = mysqli_fetch_array($q)) {
			                $ansid = $row['ansid'];
			            }
			            $q = mysqli_query($connection, "SELECT * FROM user_answer WHERE eid={$_GET[eid]} AND email={$_session[email]} AND qid='$qid' ") or die('Error115');
			            $row = mysqli_fetch_array($q);
			            $ans = $row['ans'];
			            $q = mysqli_query($connection, "DELETE FROM user_answer WHERE qid='$qid' AND email={$_session[email]} AND eid={$_GET[eid]} ") or die("Error2222");
			            if ($ans == $ansid) {
			                $q = mysqli_query($connection, "SELECT * FROM quiz WHERE quizid='$eid' ") or die('Error129');
			                while ($row = mysqli_fetch_array($q)) {
			                    $wrong   = $row['wrongno'];
			                    $correct = $row['correctno'];
			                }

			                $q = mysqli_query($connection, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error139');
			                while ($row = mysqli_fetch_array($q)) {
			                    $s = $row['score'];
			                    $w = $row['wrong'];
			                    $r = $row['correct'];
			                }
			                $r--;
			                $s = $s - $correct;
			                $q = mysqli_query($connection, "UPDATE `history` SET `score`=$s,`level`=$sn,`correct`=$r, date= NOW()  WHERE  email = '$email' AND eid = '$eid'") or die('Error11');
			            } else {
			                $q = mysqli_query($connection, "SELECT * FROM quiz WHERE quizid='$eid' ") or die('Error129');
			                while ($row = mysqli_fetch_array($q)) {
			                    $wrong   = $row['wrongno'];
			                    $correct = $row['correctno'];
			                }

			                $q = mysqli_query($connection, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error139');
			                while ($row = mysqli_fetch_array($q)) {
			                    $s = $row['score'];
			                    $w = $row['wrong'];
			                    $r = $row['correct'];
			                }
			                $w--;
			                $s = $s + $wrong;
			                $q = mysqli_query($connection, "UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w, date= NOW()  WHERE  email = '$email' AND eid = '$eid'") or die('Error11');
			            }
			            header('location:quiz.php?q=quiz&step=2&eid=' . $_GET[eid] . '&n=' . $_GET[n] . '&t=' . $total);

			        } else {
			            unset($_SESSION['sessionstart']);
			            $q = mysqli_query($connection, "UPDATE history SET status='finished' WHERE email={$_session[email]} AND eid={$_GET[eid]} ") or die('Error197');
			        $q = mysqli_query($connection, "SELECT * FROM history WHERE eid={$_GET[eid]} AND email={$_session[email]}") or die('Error156');
			                while ($row = mysqli_fetch_array($q)) {
			                    $s = $row['score'];
			                    $scorestatus = $row['score_updated'];
			                }
			                if($scorestatus=="false"){
			                    $q = mysqli_query($connection, "UPDATE history SET score_updated='true' WHERE email={$_session[email]} AND eid={$_GET[eid]} ") or die('Error197');
			                    $q = mysqli_query($connection, "SELECT * FROM rank WHERE email='$email'") or die('Error161');
			                    $rowcount = mysqli_num_rows($q);
			                    if ($rowcount == 0) {
			                        $q2 = mysqli_query($connection, "INSERT INTO rank VALUES(NULL,'$email','$s',NOW())") or die('Error165');
			                    } else {
			                        while ($row = mysqli_fetch_array($q)) {
			                            $sun = $row['score'];
			                        }

			                        $sun = $s + $sun;
			                        $q = mysqli_query($connection, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error174');
			                    }
			                }
			            header('location:userportal_results.php?eid=' . $_GET[eid]);
			        }
			    } else {
			        unset($_SESSION['sessionstart']);
			        $q = mysqli_query($connection, "UPDATE history SET status='finished' WHERE email={$_session[email]} AND eid={$_GET[eid]} ") or die('Error197');
			        $q = mysqli_query($connection, "SELECT * FROM history WHERE eid={$_GET[eid]} AND email={$_session[email]}") or die('Error156');
			                while ($row = mysqli_fetch_array($q)) {
			                    $s = $row['score'];
			                    $scorestatus = $row['score_updated'];
			                }
			                if($scorestatus=="false"){
			                    $q = mysqli_query($connection, "UPDATE history SET score_updated='true' WHERE email={$_session[email]} AND eid={$_GET[eid]} ") or die('Error197');
			                    $q = mysqli_query($connection, "SELECT * FROM rank WHERE email='$email'") or die('Error161');
			                    $rowcount = mysqli_num_rows($q);
			                    if ($rowcount == 0) {
			                        $q2 = mysqli_query($connection, "INSERT INTO rank VALUES(NULL,'$email','$s',NOW())") or die('Error165');
			                    } else {
			                        while ($row = mysqli_fetch_array($q)) {
			                            $sun = $row['score'];
			                        }

			                        $sun = $s + $sun;
			                        $q = mysqli_query($connection, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'") or die('Error174');
			                    }
			                }
			            header('location:userportal_results.php?eid=' . $_GET[eid]);
			    }
			}

 ?>
