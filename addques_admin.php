
<?php  include 'db.php';
session_start();
$quizn= $_SESSION['quizn'];
$quesno= "";
$quesno++;

// $res=mysqli_query($connection,"SELECT * FROM quiz WHERE id=$id");
//
//   $quizname=$res["quizname"];

// $q=mysqli_query($connection,"SELECT * FROM quiz WHERE quizname=$exam_title");
// while ($row=mysqli_fetch_array($q)) {
//   $exam_title=$row["quizname"];
// }
if(isset($_POST['ques'])){
	$question_text = $_POST['question_text'];
	$correct_choice = $_POST['correct_choice'];
	// Choice Array
	$choice1 = $_POST['choice1'];
	$choice2 = $_POST['choice2'];
	$choice3 = $_POST['choice3'];
	$choice4 = $_POST['choice4'];
 // // First Query for Questions Table
 //
	// $query = "INSERT INTO questions (";
	// $query .= "question_number, question_text )";
	// $query .= "VALUES (";
	// $query .= " '{$question_number}','{$question_text}' ";
	// $query .= ")";

  $query = "INSERT INTO question (quizname, question_text, choice1, choice2, choice3, choice4, correct_choice, quesno)
        VALUES('$quizn', '$question_text', '$choice1', '$choice2', '$choice3', '$choice4', '$correct_choice', '$quesno')";

	$insert_row = mysqli_query($connection,$query);

	//Validate First Query
  if($insert_row){
		$message = "Question has been added successfully";
	}
}
	if($quesno>=	$_SESSION['totalq']){
		session_destroy();
		unset($_SESSION['quizn']);
		unset($_SESSION['totalq']);
		header("location: addques_admin.php");
	}
		// $q = "SELECT * FROM question WHERE quizname=$quizn";
    //   $result = mysqli_query($connection,$q);
    //   if($result){
    //     $total = mysqli_num_rows($result);
  	// 	   $next = $total+1;
    //      $quesno=$total;
    //   }

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

    <div class="container addques">

      <h2>Enter Question Details to Quiz </h2>
      <?php if(isset($message)){
        echo "<h4>" . $message . "</h4>";
      } ?>

      <form method="POST" action="addques_admin.php">
          <p>
            <label>Question Number:</label>
            <input type="number" name="question_number" value="<?php echo $quesno;  ?>">
          </p>
          <p>
            <label>Question Text:</label>
            <input type="text" name="question_text">
          </p>
          <p>
            <label>Choice 1:</label>
            <input type="text" name="choice1">
          </p>
          <p>
            <label>Choice 2:</label>
            <input type="text" name="choice2">
          </p>
          <p>
            <label>Choice 3:</label>
            <input type="text" name="choice3">
          </p>
          <p>
            <label>Choice 4:</label>
            <input type="text" name="choice4">
          </p>
          <p>
            <label>Correct Option Number</label>
            <input type="number" name="correct_choice">
          </p>
          <input type="submit" name="ques" value ="submit">


      </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
