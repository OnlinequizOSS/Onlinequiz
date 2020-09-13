 <?php
 
$gendererr= $lasterr=$numerr=$firsterr=$emailerr=$passerr=$cpasserr="";
if(isset($_POST['submit']))
{
    $phonealready =0;
    $emailalready=0;   
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
             echo "";
        }

         if(empty($password))
        {
            $passerr="This is a required field.";
            $confirmed=false;
            if(!$confirmed)
             echo "";
        }

        if(empty($cpassword) && empty($passerr))
        {
            $cpasserr="This is a required field.";
            $confirmed=false;
            if(!$confirmed)
             echo "";
        }

         if(empty($gender))
        {
            $gendererr="This is a required field.";
            $confirmed=false;
            if(!$confirmed)
             echo "";
        }
    
		
		if (!preg_match("/^[A-Za-z]{3,255}$/",($first))&& !empty($first) ) {     // regex for string validation
            $firsterr = "Only alphabets are allowed.";
         //    echo $stringerr;      
            $confirmed=false;
            if(!$confirmed)
            echo "";
        }

        if (!preg_match("/^[A-Za-z]{3,255}$/",($last)) && !empty($last)) {     // regex for string validation
            $lasterr = "Only alphabets and whitespace are allowed.";
            // echo $stringerr; 
            $confirmed=false;     
            if(!$confirmed)
            echo "";
        }
       

        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  // regex for email validation
         if (!preg_match ($pattern, $email) &&!empty($email) ){  
             $emailerr = "Email is not valid.";
             
             $confirmed=false;
              // echo $emailerr;
              if(!$confirmed)
              echo "";
            } 
            if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/",$password) && !empty($password)) //regex for password validation
            { 
              $passerr="Invalid Password";
        // echo $passerr;
             $confirmed=false;
             if(!$confirmed)
             echo "";
            }



        if(!preg_match("/^[0-9]{10}$/",$phone) && !empty($phone))   //regex forr phone validation 
        {
            $numerr="Invalid phone!";
            $confirmed=false;
            if(!$confirmed)
             echo "";
        }

        if (!($password==$cpassword) && empty($passerr)) {
            $cpasserr="Passwords do not match";
            // echo $cpasserr;
            $confirmed=false;
            if(!$confirmed)
            echo "";
        }

        if(empty($gender)) 
        {
            $gendererr= "You forgot to select your Gender!";
           $confirmed=false;
           if(!$confirmed)
             echo "";
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
             $phonealready=1;
        }
        if(mysqli_num_rows($res_em)>0)
        {
            $emailerr="Email already registered";
            $confirmed=false;
            if(!$confirmed)
            $emailalready=1;
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

<body onload="setTimeout(clear,3000)">
    <div class="back" onclick="mainmenu()">Back</div>
    <div class="container">

     <div class="boxes">
        
         <div class="top">
            <img src="user.png" class="user">
             <h3>User Registration</h3>
         </div>
         <form action="?"class="form" method="POST">
             <input class="input" name="first" type="text" placeholder="First name" value="<?php echo isset($_POST['first']) ? $_POST['first'] : ''; ?>" required onchange="checkfirst(this)">
             <p id="firstnameerr"></p>
             <span class="error"><?php echo $firsterr; $firsterr="";?></span>
             <input class="input" name="last" type="text" placeholder="Last name" value="<?php echo isset($_POST['last']) ? $_POST['last'] : ''; ?>" required onchange="checklast(this)">
             <p id="lastnameerr"></p>
             <span class="error"><?php echo $lasterr;?></span>
             <input class="input" name="email" placeholder="Email-id" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '';  ?>"  required onchange="checkmail(this)">
             <p id="emailerr"></p>
             <span class="error"><?php echo $emailerr;?></span>
             <input class="input" name="phone" type="text" placeholder="phone number" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '';  ?>" required onchange="checkphone(this)">
             <p id="phoneerr"></p>
             <span class="error"><?php echo $numerr;?></span>
             <select class="input" name="gender" placeholder="Gender" required>
             <option value="">Gender</option>
              <option value="m">Male</option>
            <option value="f">Female</option>
             </select>
             <span class="error"><?php echo $gendererr;?></span>
             <input class="input" name="password" id="password" type="password" placeholder="password" onchange="checkpass(this)" required>
             <p id="passerror"></p>
             <span class="error"><?php echo $passerr;?></span>
             <input class="input" name="cpassword" type="password" placeholder="confirm password" required onchange="checkmatch(this)">
             <p id="cpasserror"></p>
             <span class="error"><?php echo $cpasserr;?></span>
             <input name="flag" type="hidden" value="1">
             <input class ="input button" name="submit" type="submit" placeholder="SUBMIT" onclick="return checkall()"> 
         </form>
         <div>
           <a  class="already" href="user_login.php">Already have an account?</a>
         </div>
     </div>
    </div>

</body>


<script>

var passcorr=0;
var firstcorr=0;
var lastcorr=0;
var emailcorr=0;
var phonecorr=0;
var passmatch=0;
function checkpass(inputtxt){
var passw=  /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
if(inputtxt.value.match(passw)) 
{ 
    passcorr=1;
    document.getElementById('passerror').innerHTML="";
    document.getElementById('passerror').style.display="none";
}
else
{ 
    passcorr=0;
    document.getElementById('passerror').innerHTML="Password too weak";
    document.getElementById('passerror').style.display="block";
}
}

function checkfirst(inputtxt){
var passw=  /^[A-Za-z]{3,255}$/;
if(inputtxt.value.match(passw)) 
{ 
    firstcorr=1;
    document.getElementById('firstnameerr').innerHTML="";
    document.getElementById('firstnameerr').style.display="none";
}
else
{ 
    firstcorr=0;
    document.getElementById('firstnameerr').innerHTML="Invalid first name";
    document.getElementById('firstnameerr').style.display="block";
}
}

function checklast(inputtxt){
var passw=  /^[A-Za-z]{3,255}$/;
if(inputtxt.value.match(passw)) 
{ 
    lastcorr=1;
    document.getElementById('lastnameerr').innerHTML="";
    document.getElementById('lastnameerr').style.display="none";
}
else
{ 
    lastcorr=0;
    document.getElementById('lastnameerr').innerHTML="Invalid last name";
    document.getElementById('lastnameerr').style.display="block";
}
}

function checkmail(inputtxt){
var mailpattern=  /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
if(inputtxt.value.match(mailpattern)) 
{ 
    emailcorr=1;
    document.getElementById('emailerr').innerHTML="";
    document.getElementById('emailerr').style.display="none";
}
else
{ 
    emailcorr=0;
    document.getElementById('emailerr').innerHTML="Invalid Email";
    document.getElementById('emailerr').style.display="block";
}
}


function checkphone(inputtxt){
var pattern=  /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
if(inputtxt.value.match(pattern)) 
{ 
    phonecorr=1;
    document.getElementById('phoneerr').innerHTML="";
    document.getElementById('phoneerr').style.display="none";
}
else
{ 
    phonecorr=0;
    document.getElementById('phoneerr').innerHTML="Invalid Phone number";
    document.getElementById('phoneerr').style.display="block";
}
}

function checkmatch(element)
{
    var pass=document.getElementById('password');
    if(element.value==pass.value)
    {
        passmatch=1;
        document.getElementById('cpasserror').innerHTML="";
        document.getElementById('cpasserror').style.display="none";
    }
    else
    {
        passmatch=0;
        document.getElementById('cpasserror').innerHTML="Passwords don not match";
        document.getElementById('cpasserror').style.display="block";
    }
}

function checkall()
{
    if(passcorr==0||firstcorr==0||lastcorr==0||emailcorr==0||phonecorr==0||passmatch==0)
    {
        alert("Please enter valid inputs");
        return false;
    }
    else
    {
        return true;
    }
}

function mainmenu()
{
    window.location.replace("index.php");
}



</script>



</html>
