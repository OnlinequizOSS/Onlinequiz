<?php
if(isset($_POST['submit']))
{

    $admin_username=$_POST['username'];
    $admin_pass=$_POST['password'];

    $corrname="admin1582";
    $corrpass="Admin@2580";
    if($admin_username==$corrname)
    {
        $userright=1;
    }
    else
    {
        $userright=0;
    }
    if($admin_pass==$corrpass)
    {
        $passright=1;
    }
    else{
        $passright=0;
    }

/*  if($userright==0)
    {
        echo "<script>alert('wrong username');</script>";
    }
    else if($passright==0)
    {
        echo"<script>alert('wrong password');</script>";
    }
    else
    {
        echo "<script>alert('welcome!');</script>";
    }

    */
}


?>
