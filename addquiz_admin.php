<?php  include 'db.php';


if(isset($_POST['addq'])){
	$quizname = mysqli_real_escape_string($connection, $_POST['quizname']);
	$totalques = mysqli_real_escape_string($connection,$_POST['totalques']);
	$correctno = mysqli_real_escape_string($connection,$_POST['correctno']);
  $wrongno =  mysqli_real_escape_string($connection,$_POST['wrongno']);
  $testtime =  mysqli_real_escape_string($connection,$_POST['testtime']);


  $query = "INSERT INTO quiz (quizname, totalques, correctno, wrongno, testtime)
        VALUES('$quizname', '$totalques', '$correctno', '$wrongno', '$testtime')";


  $result = mysqli_query($connection,$query);
	if ($result) {
  // $last_id = mysqli_insert_id($connection);
		session_start();
		$_SESSION['quizn'] = $quizname;
		$_SESSION['totalq']= $totalques;
    header("location: addques_admin.php");
  }else{
    die("Query for quiz could not be executed" . $query);
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard | Add Quiz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="adminportal.css">
    <script src="https://kit.fontawesome.com/d717612254.js" crossorigin="anonymous"></script>

  </head>

  <body>
    <?php require "adminportal.php" ?>
    <span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Quiz Details</b></span><br /><br />

        <form class="form-horizontal addquiz" name="form" action="addquiz_admin.php"  method="POST">
          <fieldset>
            <div class="form-group">

              <label class="col-md-12 control-label" for="quizname"></label>
              <div class="col-md-12">
                <input id="quizname" name="quizname" placeholder="Enter Quiz title" class="form-control input-md" type="text">
              </div>

            </div>

            <div class="form-group">

              <label class="col-md-12 control-label" for="totalques"> </label>
              <div class="col-md-12">
                <input id="totalques" name="totalques" placeholder="Enter total number of questions" class="form-control input-md" type="number">
              </div>

            </div>

            <div class="form-group">
              <label class="col-md-12 control-label" for="correctno"></label>
              <div class="col-md-12">
                <input id="correctno" name="correctno" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-12 control-label" for="wrongno"></label>
              <div class="col-md-12">
                <input id="wrongno" name="wrongno" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-12 control-label" for="testtime"></label>
              <div class="col-md-12">
                <input id="testtime" name="testtime" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-12 control-label" for=""></label>
              <div class="col-md-12">
                <input name="addq" type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit">
              </div>
            </div>

          </fieldset>
        </form>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
