<?php
$passerr="";
$cpasserr="";
$confirmed=true;
//echo $_GET["id"];
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))&& isset($_POST["submit"])){   
  //  echo "hello";
    $id=$_GET['id'];
    $password=$_POST["password"];
    $cpassword=$_POST["cpassword"];
    $hashed_password=password_hash($password,PASSWORD_DEFAULT);
    if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/",$password)) //regex for password validation
    { 
      $passerr="Invalid Password";
      $confirmed=false;
    }
    else if($password!=$cpassword)
    {
        $cpasserr="Passwords do not match";
        //echo $cpasserr;
         $confirmed=false;
    }
    if($password==$cpassword && $confirmed)
    {
      
        $conn=mysqli_connect("localhost","root","","quizickle");
        $sql = "UPDATE user_registration SET password=? WHERE id=?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $password,$id);
            if(mysqli_stmt_execute($stmt)){
                header("location: userportal_account.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="change_password.css" rel="stylesheet" type="text/css">    <title>Change Password</title>
</head>
<body>
    <input type="button" class="backbutton" value="Go Back!" onclick="history.back(-1)" />
    <span class="main"><p>Change Password</p></span>
    
    
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST" class="boxes">
    <input type="password" name="password" class="input" placeholder="New Password" >
    <span class="input error"><?php echo $passerr;?></span>
    <input type="password" name="cpassword" class="input" placeholder="Confirm Password">
    <span class="input error"><?php echo $cpasserr;?></span>
    <input id="button" type ="submit" name="submit" class="input">
    </form>
</body>
</html>
