<?php session_start();
include 'db.php';

 if (!isset($_SESSION["adminlogin"])) {
   ?>
   <script type="text/javascript">
     window.location="index.php";
   </script>
<?php
 }

$query = "SELECT * FROM quiz"; //You don't need a ; like you do in SQL
$result = mysqli_query($connection,$query);
// if(isset($_POST['delete_id'])){
// $id = $_POST['delete_id'];
// $query = "delete from classes where ID = $id";
// mysqli_query($conn, $query);
//  echo '<script>window.location.href="courses.php";</script>';;
// }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="adminportal.css">
    <script src="https://kit.fontawesome.com/d717612254.js" crossorigin="anonymous"></script>

  </head>

  <body>
    <?php require "adminportal.php" ?>
    <div class="content-main">
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12">
    <h3 style="color:#007bff;font-size: 3rem; text-align: center; margin: 1.5rem;">Exam Details</h3>
        <div class="row q-data">
            <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="portlet-body">
                      <div class="new-link">
                      <!-- <a class="btn btn-success" href="new_course.php"><i class="fa fa-plus add" data-toggle="tooltip"></i>New Course</a></div> -->
                      <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="portlet-body">
                      <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                            <div class="col-md-12">
                              <div class="table-responsive">
                                  <table class='table table-hover hometable' id='selected-user-list' >
                              				<thead><tr><th>ID</th><th>Exam Name</th><th>Total Questions</th><th>Action</th></tr></thead>
                              				<tbody>
                              				<?php
                                          $r=1;
                              					while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results

                                          	echo "<tr><td>" . $r . "</td><td>" . $row['quizname'] . "</td><td>" . $row['totalques'] . "</td></tr>";  //$row['index'] the index here is a field name
                                            $r++;
                                          }
                              				?>

                                    </tbody>
                                  </table>
                              </div>
                              <div class="text-right"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                  </div>
            </div>
        </div>
      </div>
    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
