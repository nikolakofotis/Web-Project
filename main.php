
<?php
session_start();

$db=mysqli_connect('localhost','root','','haranalyzer');

if(isset($_POST['regUser']))
{
  //User register
$username= mysqli_escape_string($db,$_POST['username']);
$email= mysqli_escape_string($db,$_POST['email']);
$password= mysqli_escape_string($db,$_POST['password']);
$password=md5($password);//encode password


$q= "SELECT * FROM user WHERE username='$username' LIMIT 1";//elegxei thn vash gia to username poy exei dosei o xrhsths
$result= mysqli_query($db,$q);
$check=mysqli_fetch_assoc($result); 

if($username!="admin")//elegxei an to username einai  "admin"
  {
    if($check['username']===$username)//an to username to exei allos xrhsths pes toy oti den mporei na kanei eggrafh me ayto to onoma
    {
        echo("error user already exist");
    } 
    else 
    {
      //an to username den vrethei sthn vash tote kane eggrafh ston pinaka 'user' 
        $_SESSION['username']=$username;
        $querry= "INSERT INTO user(username,password,email,dateCreated,numberOfFiles) VALUES ('$username','$password','$email', NOW(),0)";
        mysqli_query($db,$querry);
        echo "User Registered !";
    }
  }
  else// an to username einai 'admin' pes ston xrhsth oti den mporei na exei afto to onoma
{
  echo "Cant register with that username.";
}
}


if(isset($_POST['connectButton'])) //user connect.
{
  $username=mysqli_escape_string($db,$_POST['uname']);//pare to username apo thn forma html
  $password=mysqli_escape_string($db,$_POST['pass']);//pare to password apo thn forma html
  $password=md5($password);//encode password
  $querry="SELECT username , password FROM user WHERE username='$username'AND password='$password' " ; //psakse thn vash gia ton user
  $res=mysqli_fetch_assoc(mysqli_query($db,$querry));//fetch results

  if($res['username']===$username && $res['password']===$password)
  {
    //an o user yparxei tote phgaine ton sthn prwth selida
    $_SESSION['username']=$username;
    header('Location: page1.php');
    exit;
  }
  else if($username==="admin" && $password="root")
  {
    //an o user exei valei stoixeia admin tote phgaine ton sthn selida admin
    $_SESSION['username']="admin";
    header('Location: AdminPage.php');
    exit;
  }
  else
  {
    //an the vrethei o user emfanise mhnyma oti o xrhsths den vrethike 
    echo "<p class='errorMsg'>Login failed username or password incorrect</p>";
    
  }
}



//html file 
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>


    <meta charset="utf-8">
    <title>HAR File Editor</title>
  </head>


  <body style="background-color:#cccccc;">

    
    <style media="screen">
      .errorMsg
      {
        position: absolute;
        text-align: center;
        top: 35%;
        left:41%;
        color: #b30000;
      }
      h1 {
        text-align: center;
         font-family: "Lucida Console", "Courier New", monospace;
      }
      .p1 {
        text-align: center;
        font-family: "Lucida Console", "Courier New", monospace;
      }
      .username
      {
        text-align: center;
        height: 25px;
        width:200px;
        border: none;
        border-radius: 25px;
      }

      .password
      {
          text-align: center;
          height: 25px;
          width:200px;
          border: none;
          border-radius: 25px;
      }

      .connectButton
      {
        background-color: #b3b3ff;
        border: none;
        height: 25px;
        width:100px;
        border-radius: 25px;
        position:absolute;
        top: 25%;
        left :47.5%;
        cursor: pointer;
        transition: box-shadow 1s;
      }
      .registerButton
      {
        background-color: #b3b3ff;
        border: none;
        height: 25px;
        width:100px;
        border-radius: 25px;
        position:absolute;
        top: 30%;
        left :47.5%;
        cursor: pointer;
        transition: box-shadow 1s;

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
      .registerButton:hover
      {
        box-shadow: 5px 5px 5px gray;

      }

      .connectButton:hover
      {
        box-shadow: 5px 5px 5px gray;
      }
      .modalBG
      {

        opacity: 0%;
        visibility:hidden;
        top: 0;
        left: 0;
        width: 100%;
        height:100vh;
        position: fixed;
        background-color: rgb(0,0,0,0.5);
        justify-content: center;
        display: flex;
        align-items: flex-start;

      }
      .bgActive
      {

        visibility: visible;
        opacity: 100%;
      }
      .modal
      {
        height:200px;
        opacity: 0%;
        visibility:hidden;
        transition: visibility 2s opacity 1s;
        padding:60px;
        margin: 5%;
        border-radius: 25px;
        background-color: #d9d9d9;
      }
      .confReg
      {
        transition: background-color 1s;
      }
      .confReg:hover
      {
        background-color: #b3ffb3;
      }
      .cancelReg
      {
        transition: background-color 1s;
      }
      .cancelReg:hover
      {
        background-color: #ffb3b3;
      }


      .passCheck
      {
        opacity: 0%;
        border-radius: 25px;
        padding:10px;
        position: absolute;
        background-color: #d9d9d9;
        left:60%;
        top:27%;
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



    </style>

    <div class="mainP">



    <h1>Har File Analyzer</h1>
    <p class="p1" >Σύνδεση Χρήστη</p>

    <form style = "text-align: center;" class="" action="main.php" method="post">

      <input class="username" type="text"  placeholder="Enter Username" name="uname" value="" required><br><br>

      <input class="password" type="password" placeholder="Enter Password" name="pass" value="" required>
    

  <button class="connectButton" type="submit" name="connectButton" >Σύνδεση</button>
  <button id="registerButton" class="registerButton" name="regB" type="button" onclick="f()"  >Εγγραφή</button>
  </form>
  </div>


  

  <div id="modalBG" class="modalBG">
    <div id="modal" class="modal">
      <form class="" action="main.php" method="POST">
      <p style="text-align:center;" >Φόρμα Εγγραφής</p>
      <input type="text" name="username" value="" placeholder="username" required><br><br>
      <input type="text" name="email" value="" placeholder="email" required=""><br><br>
      <input id="pass" type="password" name="password" value="" placeholder="password" required=""><br><br>
      <button disabled id="confReg" class="confReg" type="submit" name="regUser">Confirm</button>
      <button id="cancelReg" class="cancelReg" type="button" name="button">Cancel</button>
      </form>





    </div>
    <div id="passCheck" class="passCheck">
      <p id="upperCheck">Ο κωδικός θα πρεπει να περιέχει τουλαχιστον ενα κεφαλαιο γραμμα</p>
      <p id=numberCheck>Ο κωδικός θα πρεπει να περιέχει τουλαχιστον εναν αριθμό</p>
      <p id="symbolCheck">Ο κωδικός θα πρεπει να περιέχει τουλαχιστον ενα συμβολο (!@#$%..)</p>
      <p id="lengthCheck">Ο κωδικός θα πρεπει να περιέχει τουλαχιστον 8 χαρακτηρες</p>

    </div>

  </div>





  
  <script type="text/javascript" src="registerScript.js"></script>
  </body>
</html>
