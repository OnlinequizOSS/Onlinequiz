<?php session_start();
include 'db.php';
 if (!isset($_SESSION["adminlogin"])) {
   ?>
   <script type="text/javascript">
     window.location="index.php";
   </script>
<?php
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard | Remove Quiz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="adminportal.css">
    <script src="https://kit.fontawesome.com/d717612254.js" crossorigin="anonymous"></script>

  </head>

  <body>
    <?php require "adminportal.php";
    $result = mysqli_query($connection, "SELECT * FROM quiz ORDER BY id DESC") or die('Error');
    echo '<div class="panel"><table class="table table-striped removetable">
  <tr><td style="vertical-align:middle"><b>S.N.</b></td><td style="vertical-align:middle"><b>Exam Name</b></td><td style="vertical-align:middle"><b>Total Questions</b></td><td style="vertical-align:middle"><b>Marks</b></td><td style="vertical-align:middle"><b>Time limit(in min)</b></td><td style="vertical-align:middle"><b>Action</b></td></tr>';
    $c = 1;
    while ($row = mysqli_fetch_array($result)) {
        $title   = $row['quizname'];
        $total   = $row['totalques'];
        $correct = $row['correctno'];
        $time    = $row['testtime'];
        $eid     = $row['quizid'];
        echo '<tr><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle">' . $title . '</td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">' . $correct * $total . '</td><td style="vertical-align:middle">' . $time . '&nbsp;min</td>
  <td style="vertical-align:middle"><b><a href="update.php?q=rmquiz&eid=' . $eid . '" class="btn removebtn" >&nbsp;<span class=""><b>Remove</b></span></a></b></td></tr>';
    }
    $c = 0;
    echo '</table></div>';
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
