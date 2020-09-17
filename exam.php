<?php
session_start();
if(!isset($_SESSION['name']))
{
    header("location:user_login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="exampage.css">
    <title>Exam Page</title>
</head>
<body>
    <div class="quizarea">

    </div>
</body>
</html>