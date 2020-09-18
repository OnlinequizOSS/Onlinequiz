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
         // $wrong   = $_POST['wrongno'];
         $time    = $_POST['testtime'];
         $status  = "disabled";
         $id      = uniqid();
         $q3      = mysqli_query($connection, "INSERT INTO quiz VALUES(NULL,'$id','$name','$total','$correct','$time', 'NOW()','$status')");
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


 ?>
