
<?php

//kwdikas gia allagh username kai password.
session_start();
if($_SESSION['username']===null)
{
  header("Location: main.php");
  exit;
}
else
{

  $allowEcho=false;
  $output;

$db=mysqli_connect('localhost','root','','haranalyzer');
$sessionUname = $_SESSION['username'];


if(isset($_POST['confReg']))
{

$q= "SELECT * FROM user WHERE username='$sessionUname' LIMIT 1";//vriskei ta stoixeia toy xrhsth sthn vash
$result= mysqli_query($db,$q);
$check=mysqli_fetch_assoc($result); 

$oldPass=$_POST['oldPass'];
$newPass=$_POST['newPass'];

$oldPass=md5($oldPass);
if($oldPass==$check['password'])//checkarei an o xrhsths plhktrologhse swsta ton palio kwdiko
{
  //an nai tote kanei update thn vash kai allazei ton kwdiko
  $allowEcho=true;
  $q="UPDATE user SET password='md5($newPass)' WHERE username=$sessionUname";
  $output=" <p id='successText'>Επιτυχής αλλαγή κωδικού πρόσβασης</p>";


}
else 
{
  //allios vgazei mhnyma oti den einai swstos o palios kwdikos
  $allowEcho=true;
  $output=" <p id='successText'>Πληκτρολογήσατε τον τρέχων κωδικό λάθος.</p>";
}

}




}

if(isset($_POST['changeUname']))
{
  $newUsername=$_POST['changeUname'];
  
  $q="UPDATE user SET username='$newUsername' where username='$sessionUname'";
  $result= mysqli_query($db,$q);
  $_SESSION['username']=$newUsername;
  $allowEcho=true;
  $output="<p id='successUsername'>Επιτυχής αλλαγή ονόματος χρήστη.</p>";

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
      background-image: url(Images/earth.png) ;

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

      input
      {
        text-align: center;
        height: 25px;
        width:200px;
        border: none;
        border-radius: 25px;
      }

    ul {
      position: absolute;
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 250px;
    height:333px;
    background-color: #e6e6ff;
    border:1px solid #cccccc;
    top:8%;
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

  

  
 

  #info
  {
    padding: 40px 30px;
    background-color:#e6e6ff;
    border-radius: 15px;
    border: 3px solid #ccccff;
    box-shadow: 5px 5px 5px gray;
    position: absolute;
    left:75%;
    top:25%;
    width: 15%;

  }

  


 

  #optionsModalMain
  {
    border-radius: 15px;
    box-shadow: 5px 5px 5px gray;
    text-align: center;
    font-size: 35px;
    position:absolute;
     border: 3px solid #ccccff;
    background-color:#e6e6ff;
    width:20%;
    height:33%;
    top:10%;
    left:20%;

  }

#changePassButton
{
  width:55%;

}

#backButton
{
  position: absolute;
  width:35%;
  top:90%;
  left:10%;
}

#logOut
{
  position: absolute;
  width:35%;
  top:90%;
  left:55%;
}

#changeUsername
{
  border-radius: 15px;
    box-shadow: 5px 5px 5px gray;
    text-align: center;
    font-size: 35px;
    position:absolute;
     border: 3px solid #ccccff;
    background-color:#e6e6ff;
    width:20%;
    height:25%;
    top:50%;
    left:20%;

}
  .passCheck
      {
        box-shadow: 5px 5px 5px gray;

        opacity: 0%;
        border-radius: 25px;
        padding:10px;
        position: absolute;
        background-color: #d9d9d9;
        left:42%;
        top:18%;
        transition: opacity 1s;
      }
      #upperCheck
      {
        color: #ff6666;
        transition: color:1s;
      }
      #numberCheck
      {
        color: #ff6666;
        transition: color 1s;
      }
      #symbolCheck
      {
        color: #ff6666;
        transition: color 1s;
      }
      #lengthCheck
      {
        color: #ff6666;
        transition: color 1s;
      }

      #passText
      {
        opacity: 0%;
        color: #ff0000;
        position: absolute;
        text-align: center;
        left: 7%;
        font-size: 15px;
        transition: opacity 1s;
      }

      #successText
      {
        opacity: 100%;
        color: black;
        position: absolute;
        text-align: center;
        left: 23%;
        top:33%;
        font-size: 15px;
        
      }
      #successUsername
      {
        opacity: 100%;
        color: black;
        position: absolute;
        text-align: center;
        left: 24%;
        top:64%;
        font-size: 15px;
      }

      #logout
      {
        position: absolute;
        top:45%;
        left: 3%;
      }


 



</style>




<ul>
<li><a href="page1.php">Αρχική Σελίδα</a></li>
<li><a id="optionsBtn" href="UserProfile.php" >Προφίλ Χρήστη</a></li>

</ul>







<div id="info">
  Τα HAR ή αλλιως HTTP Archive είναι αρχεία τύπου JSON τα οποία περιέχουν πληροφορίες που αανταλλάσσονται ανάμεσα στον φυλλομετριτή και την ιστοσελίδα.<br>
  Στην εφαρμογή αυτή μπορείτε να ανεβάσετε τα αρχεία τέτοιου είδους που έχετε συλλέξει και να δείτε καποια βασικα στατιστικά στοιχεία γι'αυτα.<br>
  
</div>




<a id="logout" href="main.php">Αποσύνδεση</a>








 




  
<div id="optionsModalMain">
  
Αλλαγή κωδικόυ πρόσβασης.

<form action="OptionsPage.php" method="POST">

  <input type="password" class="inputF" id="oldPass" name="oldPass" placeholder="Τρέχον κωδικός πρόσβασης"><br>
  <input type="password" class="inputF" id="pass" name="newPass" placeholder="Νέος κωδικός πρόσβασης"><br>
 <input type="password" class="inputF" id="confpass" name="" placeholder="Επιβεβαίωση κωδικού "><br>

 <p id="passText">Οι κωδικοι πρόσβασης θα πρέπει να ταιριαζουν</p>
 <br>
<button type="submit" id="confReg" name="confReg" >Επιβεβαίωση</button><br><br>

</form>

</div>

<div id="changeUsername">
  
  Αλλαγή ονόματος χρήστη.

<form action="OptionsPage.php" method="POST">
  <input type="text" class="inputF" id="oldPass" name="changeUname" placeholder="Νέο όνομα χρήστη"><br><br>
<button type="submit" id="" name="">Αλλαγή</button><br><br>
</form>

</div>

  
    <div id="passCheck" class="passCheck">
      <p id="upperCheck">Ο κωδικός θα πρεπει να περιέχει τουλαχιστον ενα κεφαλαιο γραμμα</p>
      <p id=numberCheck>Ο κωδικός θα πρεπει να περιέχει τουλαχιστον εναν αριθμό</p>
      <p id="symbolCheck">Ο κωδικός θα πρεπει να περιέχει τουλαχιστον ενα συμβολο (!@#$%..)</p>
      <p id="lengthCheck">Ο κωδικός θα πρεπει να περιέχει τουλαχιστον 8 χαρακτηρες</p>

    </div>

  

<?php 

if($allowEcho)
{
  echo "$output";
}

?>











<script type="text/javascript" src="registerScript.js"></script>

  </body>

</html>
