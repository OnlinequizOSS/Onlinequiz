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
    <title>Admin Dashboard | Add Quiz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="adminportal.css">
    <script src="https://kit.fontawesome.com/d717612254.js" crossorigin="anonymous"></script>

  </head>

  <body>
    <?php require "adminportal.php";
		echo '<div class="row">
		<span class="title1" style="margin-left: 40%;font-size: 35px; margin-top: 15px;"><b>Enter Question Details</b></span>
		<div class="col-md-6" style="  margin: auto;  margin-top: 40px;"><form class="form-horizontal " style=" margin: auto; margin-top: 40px;" name="form" action="update.php?q=addqns&n=' . @$_GET['n'] . '&eid=' . @$_GET['eid'] . '&ch=4 "  method="POST">
		<fieldset>';

		for ($i = 1; $i <= $_GET['n']; $i++) {
						echo '<b>Question number&nbsp;' . $i . '&nbsp;:</><br />
			<div class="form-group">
				<label class="col-md-12 control-label" for="qns' . $i . ' "></label>
				<div class="col-md-12 ">
					<textarea rows="3" cols="5" name="qns' . $i . '" class="form-control" placeholder="Write question number ' . $i . ' here..."></textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12 control-label" for="' . $i . '1"></label>
				<div class="col-md-12">
					<input id="' . $i . '1" name="' . $i . '1" placeholder="Enter option a" class="form-control input-md" type="text">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12 control-label" for="' . $i . '2"></label>
				<div class="col-md-12">
					<input id="' . $i . '2" name="' . $i . '2" placeholder="Enter option b" class="form-control input-md" type="text">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12 control-label" for="' . $i . '3"></label>
				<div class="col-md-12">
					<input id="' . $i . '3" name="' . $i . '3" placeholder="Enter option c" class="form-control input-md" type="text">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12 control-label" for="' . $i . '4"></label>
				<div class="col-md-12">
					<input id="' . $i . '4" name="' . $i . '4" placeholder="Enter option d" class="form-control input-md" type="text">
				</div>
			</div>

			<br />

			<b>Correct answer</b>:<br />
			<div class="form-group">

			<select id="ans' . $i . '" name="ans' . $i . '" placeholder="Choose correct answer " class="form-control input-md" >
			 	<option value="a">Select answer for question ' . $i . '</option>
				<option value="a">option a</option>
				<option value="b">option b</option>
				<option value="c">option c</option>
				<option value="d">option d</option>
			</select>
			</div>
			<br /><br />';
		}

		echo '<div class="form-group">
		<label class="col-md-12 control-label" for=""></label>
		<div class="col-md-12">
			<input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
		</div>
	</div>

	</fieldset>
	</form></div>';
		?>
		</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
