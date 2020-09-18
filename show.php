<?php
$server="localhost";
$user="root";
$password="";
$db="quizickle";
$que=$_GET["qid"];
echo $que;
$conn=mysqli_connect($server,$user,$password,$db);
$sqla = "SELECT optionid,option
    FROM 
    options
    WHERE qid ='$que'";
$sql="SELECT * FROM questable where qid='$que'";
$res=mysqli_query($conn,$sql);
$result=mysqli_fetch_assoc($res);
$resa=mysqli_query($conn,$sqla);
if(!$resa)
{
    echo mysqli_error($resa);
}
$option=array("What is C?","a letter","a language","NO idea","NUll"); 
$i=1;
$option[0]=$result["qns"];
while ($row = mysqli_fetch_array($resa))
{
    $options[] = array($row['optionid'],$row['option']);
}
foreach($options as $a)
{
  $option[$i++ ]=$a[1];
  //echo $a[2];
}
echo "<p>".$option[0]."</p>";
for($v=1;$v<$i;$v++)
{   echo "<ol>";
    echo "<input class='flex' type='radio' value=".$v." name='op'>".$option[$v]."</p>";
    echo "</ol>";
}

?>