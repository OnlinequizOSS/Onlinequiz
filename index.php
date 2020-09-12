<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylemain.css">
    <link href="https://fonts.googleapis.com/css2?family=Aladin&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/favicon1.png">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <title>Quizickle</title>
</head>
<body>
   <div id="welcome" class="animate__animated animate__bounceInLeft">Welcome</div><div id="to" class="animate__animated animate__bounceInRight">to</div>
    <div id="title" class="animate__animated animate__bounceInUp">Quizickle</div>
    <div id="userportal"><img src="img/usericon.png" id="icon1"> I am a user</div>
    <div id="adminportal"><img src="img/adminicon.png" id="icon2"> I am an administrator</div>

    <script>
      var title = document.getElementById('title');
      setTimeout(startanimation,2000);
      function startanimation()
      {
        title.classList.remove("animate__bounceInUp");
        title.classList.add("animate__pulse");
        title.style.animationIterationCount="infinite";
      }
      var userportal= document.getElementById('userportal');
      userportal.addEventListener("click",change1);
      var adminportal = document.getElementById('adminportal');
      adminportal.addEventListener("click",change2);
      function change1()
      {
        window.location.replace("user_registration.php");
      }

      function change2()
      {
        window.location.replace("admin_login.php");
      }
      </script>
</body>
</html>