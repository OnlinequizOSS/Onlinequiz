<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="startsquiz.css" rel="stylesheet">
    <title>Document</title>
    <script
     src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        p,
label {
    font: 1rem 'Fira Sans', sans-serif;
}

input {
    margin: .4rem;
}

    </style>
    <script>
     let counter=1;
     let count=counter-1;
    
         
      $(document).ready(function()
      {
        $("#next").click(function(){
          $("#show").load("show.php?qid="+counter);
          counter++;
          if(counter>3)
          {
            counter=counter-1;
          }
          

        });
        $("#back").click(function(){
           
          $("#show").load("show.php?qid="+count);

        });

      });
      </script>
        </head>
        <body><center>
            <h2>Welcome</h2>
        
            <p></p>

          <ol>
    <div id="show"></div>
  </ol>
<button  id="next" class="btn" name="next">Next</button>
        </body>
        
    </html>
