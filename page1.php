
<?php
session_start();
if($_SESSION['username']===null)
{
  header("Location: main.php");
  exit;
}
else
{
$db=mysqli_connect('localhost','root','','haranalyzer');
$sessionUname = $_SESSION['username'];
echo "<p class='welcomeUser'>   Welcome $sessionUname</p>";


if(isset($_POST['changePassBtn']))
{
  
  $currentPass= mysqli_escape_string($db,$_POST['curPass']);
  $currentPass=md5($currentPass);
  $newPass=mysqli_escape_string($db,$_POST['newPass']);
  $newPass2=mysqli_escape_string($db,$_POST['newPass2']);
  $querry ="SELECT password FROM user WHERE  password='$currentPass' AND username='$sessionUname' ";
  $result= mysqli_query($db,$querry);
  $check=mysqli_fetch_assoc($result); 

  if($check['password']===$currentPass && $newPass===$newPass2)
  {
    $newPass=md5($newPass);
    $changePassQuerry="UPDATE user SET password='$newPass' WHERE username='$sessionUname' ";
  }
  else
  {
    echo('<style type="text/css">
        #errorMSG {
            opacity: 100%;
        }
        </style>');

  }

}



if(isset($_POST['Uploadbutton']))
{

  
  $json = file_get_contents('php://input');
  $json_decode = json_decode($json); 
  $uploadFileQuerry =" INSERT INTO files(username,dateProcessed,file) VALUES('$sessionUname',NOW(),'$json_decode') ";
  $result= mysqli_query($db,$uploadFileQuerry);
 
 
  
  
   

}



}











?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>HAR File Editor</title>
  </head>


  <body style="background-color:#cccccc;">


    <style media="screen">

    body
    {
      font-family:sans-serif;
      background-image: url(Images/earth.png);
    }
      h1 {
        text-align: center;
         font-family: "Lucida Console", "Courier New", monospace;
      }




      button
      {

        background-color: #b3b3ff;
        border: none;
        height: 25px;
        width:100px;
        border-radius: 25px;
        cursor: pointer;
        transition: box-shadow 1s;
      }

      button:hover
      {
        box-shadow: 5px 5px 5px gray;
      }

      button:focus
      {
        border:none;
      }

      input
      {
        text-align: center;
        height: 25px;
        width:200px;
        border: none;
        border-radius: 25px;
      }

    ul {
    position:absolute;
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 250px;
    height:333px;
    background-color: #e6e6ff;
    border:1px solid #cccccc;
    top:20%

    }

  li a {

    display: block;
    color: #000;
    padding: 72.45px 50px;
    text-decoration: none;
    transition: background-color 1s ,color 0.25s, box-shadow 0.50s;
    border-bottom:1px solid #cccccc;
    }


  li a:hover {
    background-color: #ccccff;
    color: black;
    box-shadow: 8px 8px 8px gray;
  }

.inputBtn
{
  opacity: 0;
}

.submitButton {

  top:24%;
  left:25%;
  width: 250px;
  height: 150px;
  position: absolute;


}
.harNameDiv
{
  border-radius: 25px;
  border:1px solid #b3b3ff ;
  box-shadow: 5px 5px 5px gray;
  padding: 100px;
  background-color:#e6e6ff;
  left:40%;
  top:18%;
  position: absolute;
}

.bt1
{
  width: 250px;
  height: 65px;
  left:40%;
  top:50%;
  position: absolute;
}
.bt1:hover ~ .info1
{
  visibility: visible;
  box-shadow: 5px 5px 5px gray;
  opacity: 100%;

}
.bt2:hover ~ .info2
{
  box-shadow: 5px 5px 5px gray;
  visibility: visible;
  opacity: 100%;
}
.bt2
{
  width: 250px;
  height: 65px;
  top:58%;
  left:40%;
  position: absolute;
}
.info1
{
  opacity: 0%;
  visibility: hidden;
  padding: 10px;
  border-radius: 25px;
  background-color: #e6e6ff;
  position: absolute;
  top: 51%;
  left: 54%;
  transition: visibility 1s, box-shadow 1s ,opacity 1s ;

}
.info2
{
  opacity: 0%;
  visibility: hidden;
  padding: 10px;
  border-radius: 25px;
  background-color: #e6e6ff;
  position: absolute;
  top: 60%;
  left: 54%;
  transition: visibility 1s, box-shadow 1s, opacity 1s ;
}

.optionsPanel
{
  opacity:0%;
  border: 0.5px solid #b3b3ff;
  border-radius: 25px;
  height:35%;
  top:15%;
  left:83%;
  position: absolute;
  background-color: #e6e6ff;
  padding: 85px;
  width:8%;
  transition: opacity 1s;
}
.changePass
{
  text-align: center;
  position: absolute;
  font-size: 18px;
  left:11%;
}
.optionsText
{
  left:26%;
  text-align: center;
  position: absolute;
  font-size: 25px;
  top:1%;
  background-color: #b3b3ff;
  border-radius: 25px;
  padding:10px;
  box-shadow: 2px 2px 2px gray;
}
#oldPass
{
  position: absolute;
  top:30%;
  left:17%;
}
#newPass
{
  position: absolute;
  top:40%;
  left:17%;
}
#confirmNewPass
{
  position: absolute;
  top:50%;
  left:17%;
}
.exitOptions
{

  width:16px;
  height: 16px;
  top:5%;
  left:5%;
  position: absolute;
  background-image: url(Images/close.png);
}
#confPassBtn
{
  position: absolute;
  top:75%;
  left:35%;
}
#errorMSG
{
  opacity: 0%;
  position: absolute;
  padding: 10px;
  left:10%;
  top:55%;
  transition: opacity 1s;

}

 #info
  {
    padding: 20px 20px;
    background-color:#e6e6ff;
    border-radius: 15px;
    border: 3px solid #ccccff;
    box-shadow: 5px 5px 5px gray;
    position: absolute;
    width:15%;
    left:75%;
    top:20%;
  }

  .welcomeUser
  {
    text-align: center;
    border: 1px solid #ccccff;
    border-radius: 15px;
    box-shadow: 2px 2px 2px gray;
    padding: 10px 5px;
    position: relative;
    background-color: #e6e6ff;
    width:15%;
    height: 5%;
    top:3%;
  }

</style>





<ul>
<li><a href="UserProfile.php">Προφίλ Χρήστη</a></li>
<li><a id="optionsBtn" href="OptionsPage.php" >Ρυθμίσεις</a></li>
</ul>

<form action="/action_page.php">
  <input id="inputBtn" type="file" id="myFile" name="filename" accept=".har" hidden>
</form>


<button id="submitButton" class="submitButton" type="button" name="button">Επιλογή Αρχείου HAR</button>
<div id="harNameDiv" class="harNameDiv">
  <p id="harNameWrite">Επιλέξτε ενα HAR αρχέιο απο το σύστημά σας.</p>
<br>

</div>
<form action="uploadFile.php" method="post">
<button id="downloadLocalBtn" class="bt1" type="button" name="button">Τοπική Αποθήκευση</button>
<button id="serverUploadbtn" class="bt2" type="button" name="Uploadbutton" value="0">Άνεβασμα  αρχείου στον server</button>
<div class="info1">
Για επεξεργάσια και  αποθήκευση στο σύστημα σας.
</div>
<div class="info2">
Για επεξεργάσια δεδομένων και ανέβασμα στον server.
</div>
</form>




</form>
</div>
<div id="info">
  Στην σέλιδα αυτή μπορείτε να επιλέξετε ενα αρχείο απο το σύστημά σας πατώντας πάνω στο "Επιλογή αρχείου HAR".<br>
  Στην συνέχεια υπάρχουν δύο επιλογές, μπορείτε να αποθηκέυσετε το αρχείο  στον υπολογιστή σας ή να το ανεβάσετε στο προφιλ σας.<br>


</div>



<script type="text/javascript" src="FileReader.js"></script>
<script type="text/javascript" src="HARSelector.js"></script>
  </body>

</html>
