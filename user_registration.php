 <?php
 

    header('location:redirect.php');


$gendererr= $lasterr=$numerr=$firsterr=$emailerr=$passerr=$cpasserr="";
if(isset($_POST['submit']))
{    
   $flag=true;
      $_POST['flag']=0;
        $confirmed=true;
        $first = filter_input(INPUT_POST, 'first');
        $last=filter_input(INPUT_POST, 'last');
        $phone= filter_input(INPUT_POST, 'phone');
        $email= filter_input(INPUT_POST, 'email');
        $password= filter_input(INPUT_POST, 'password');
        $cpassword= filter_input(INPUT_POST, 'cpassword');
        $gender=filter_input(INPUT_POST, 'gender');
        $hashed_password=password_hash($password, PASSWORD_DEFAULT);
        


        if(empty($first))
        {
            $firsterr="This is a required field.";
            $confirmed=false;
        }
         if(empty($last))
        {
            $lasterr="This is a required field.";
            $confirmed=false;
        }
        if(empty($phone))
        {
            $numerr="This is a required field.";
            $confirmed=false;
        }
         if(empty($email))
        {
            $emailerr="This is a required field.";
            $confirmed=false;
            if(!$confirmed)
            echo "1";
        }
         if(empty($password))
        {
            $passerr="This is a required field.";
            $confirmed=false;
            if(!$confirmed)
            echo "2";
        }
        if(empty($cpassword) && empty($passerr))
        {
            $cpasserr="This is a required field.";
            $confirmed=false;
            if(!$confirmed)
            echo "3";
        }
         if(empty($gender))
        {
            $gendererr="This is a required field.";
            $confirmed=false;
            if(!$confirmed)
            echo "4";
        }
    
		
		if (!preg_match("/^[A-Za-z]{5,255}$/",($first))&& !empty($first) ) {     // regex for string validation
            $firsterr = "Only alphabets are allowed.";
         //    echo $stringerr;      
            $confirmed=false;
            if(!$confirmed)
            echo "5";
        }

        if (!preg_match("/^[A-Za-z]{5,255}$/",($last)) && !empty($last)) {     // regex for string validation
            $lasterr = "Only alphabets and whitespace are allowed.";
            // echo $stringerr; 
            $confirmed=false;     
            if(!$confirmed)
            echo "6";
        }
       

        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  // regex for email validation
         if (!preg_match ($pattern, $email) &&!empty($email) ){  
             $emailerr = "Email is not valid.";
             
             $confirmed=false;
              // echo $emailerr;
              if(!$confirmed)
            echo "7";
            } 
            if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/",$password) && !empty($password)) //regex for password validation
            { 
              $passerr="Invalid Password";
        // echo $passerr;
             $confirmed=false;
             if(!$confirmed)
            echo "8";
            }



        if(!preg_match("/^[0-9]{10}$/",$phone) && !empty($phone))   //regex forr phone validation 
        {
            $numerr="Invalid phone!";
            $confirmed=false;
            if(!$confirmed)
            echo "9";
        }

        if (!($password==$cpassword) && empty($passerr)) {
            $cpasserr="Passwords do not match";
            // echo $cpasserr;
            $confirmed=false;
            if(!$confirmed)
            echo "10";
        }

        if(empty($gender)) 
        {
            $gendererr= "You forgot to select your Gender!";
           $confirmed=false;
           if(!$confirmed)
            echo "11";
        }

        $conn=mysqli_connect("localhost","root","","quizickle");

        $sql_p = "SELECT * FROM user_registration WHERE phone='$phone'";
        $sql_em="SELECT * FROM user_registration WHERE email='$email'";

        $res_p = mysqli_query($conn, $sql_p);
        $res_em = mysqli_query($conn, $sql_em);

        if(mysqli_num_rows($res_p)>0)
        {
            $numerr="Number already registered";
            $confirmed=false;
            if(!$confirmed)
            echo "11";
        }
        if(mysqli_num_rows($res_em)>0)
        {
            $emailerr="Email already registered";
            $confirmed=false;
            if(!$confirmed)
            echo "12";
        }
    
		if($confirmed)
        {    
            
            $sql = "INSERT INTO user_registration (firstname,lastname,phone,email,gender,password)
            values ('$first','$last','$phone','$email','$gender','$hashed_password')";

			mysqli_query($conn,$sql);
			header("Location: welcome.html");
		
		}
    }
    
?>
 

<!DOCTYPE HTML>
<html>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" >
    <title>
        User Registration
    </title>
</head>

<body >
    <div class="container">

     <div class="boxes">
        
         <div class="top">
            <img src="user.png" class="user">
             <h3>User Registration</h3>
         </div>
         <form action="?"class="form" method="POST">
             <input class="input" name="first" type="text" placeholder="First name" value="<?php echo isset($_POST['first']) ? $_POST['first'] : ''; ?>">
             <span class="error"><?php echo $firsterr; $firsterr="";?></span>
             <input class="input" name="last" type="text" placeholder="Last name" value="<?php echo isset($_POST['last']) ? $_POST['last'] : ''; ?>">
             <span class="error"><?php echo $lasterr;?></span>
             <input class="input" name="email" placeholder="Email-id" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '';  ?>" >
             <span class="error"><?php echo $emailerr;?></span>
             <input class="input" name="phone" type="text" placeholder="phone number" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '';  ?>">
             <span class="error"><?php echo $numerr;?></span>
             <select class="input" name="gender" placeholder="Gender">
             <option value="">Gender</option>
              <option value="m">Male</option>
            <option value="f">Female</option>
             </select>
             <span class="error"><?php echo $gendererr;?></span>
             <input class="input" name="password" type="password" placeholder="password">
             <span class="error"><?php echo $passerr;?></span>
             <input class="input" name="cpassword" type="password" placeholder="confirm password" >
             <span class="error"><?php echo $cpasserr;?></span>
             <input name="flag" type="hidden" value="1">
             <input class ="input button" name="submit" type="submit" placeholder="SUBMIT" > 
         </form>
         <div>
           <a  class="already" href="#">Already have an account?</a>
         </div>
     </div>
    </div>

</body>


<script>


</script>







</html>
