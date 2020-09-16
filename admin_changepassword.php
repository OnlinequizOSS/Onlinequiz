<?php
session_start();
$passerr="";
$cpasserr="";
$opasserr="";
$confirmed=true;
echo $_SESSION["adminlogin"];
//echo $_GET["id"];
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))&& isset($_POST["submit"])){   
  //  echo "hello";
    $id=$_GET['id'];
    $conn=mysqli_connect("localhost","root","","quizickle");
    $opassword=$_POST["opassword"];
    $sqli="SELECT * from admin where id='$id'";
    //$res_p = mysqli_query($conn, $sqli);
    $result = mysqli_query($conn,$sqli);
    if(mysqli_num_rows($result))
    {  
        $row = mysqli_fetch_assoc($result);
        // echo $row["password"];
        // if(!password_verify($opassword,$row["password"]))
        // {  echo "here";
        //    $oppasserr="Old password does not match!";
        //    $confirmed=false;
        // }
         
    }
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
        echo $cpasserr;
         $confirmed=false;
    }
    if($password==$cpassword && $confirmed)
    {
      
        
        $sql = "UPDATE admin SET password=? WHERE id=?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $hashed_password,$id);
            if(mysqli_stmt_execute($stmt)){
                header("location: home_admin.php");
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
    <input type="password" name="opassword" class="input" placeholder="Old Password" >
    <span class="input error"><?php echo $opasserr;?></span>
    <input type="password" name="password" class="input" placeholder="New Password" >
    <span class="input error"><?php echo $passerr;?></span>
    <input type="password" name="cpassword" class="input" placeholder="Confirm Password">
    <span class="input error"><?php echo $cpasserr;?></span>
    <input id="button" type ="submit" name="submit" class="input">
    </form>
</body>
</html>
