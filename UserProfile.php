
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


$dbQuery="SELECT * from files WHERE username='$sessionUname'";

$result=mysqli_query($db,$dbQuery);
$rows= mysqli_fetch_all($result,MYSQLI_ASSOC);

$ctImage=0;
$ctJavascript=0;
$ctCss=0;
$ctHtml=0;
$ctVideo=0;
$ctApplication=0;
$ctPlainText=0;

//datasets gia na peraso tis times ston xarth.

$imageData=array();
$jsData=array();
$cssData=array();
$htmlData=array();
$VideoData=array();
$AppData=array();
$txtData=array();
$totalData=array();


$dateArray=array();


foreach($rows as $row)
{
  array_push($dateArray,$row['dateProcessed']);
  $ctImage= BreakStrings($row['ctImage']);
  $ctJavascript= BreakStrings($row['ctJavascript']);
  $ctCss= BreakStrings($row['ctCss']);
  $ctHtml= BreakStrings($row['ctHtml']);
  $ctVideo= BreakStrings($row['ctVideo']);
  $ctApplication= BreakStrings($row['ctApplication']);
  $ctPlainText= BreakStrings($row['ctPlainTxt']);
  $total=$ctImage+$ctJavascript+$ctCss+$ctHtml+$ctVideo+$ctApplication+$ctPlainText;
  array_push($imageData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctImage'])));
  array_push($jsData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctJavascript'])));
  array_push($cssData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctCss'])));
  array_push($htmlData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctHtml'])));
  array_push($VideoData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctVideo'])));
  array_push($AppData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctApplication'])));
  array_push($txtData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctPlainTxt'])));
  array_push($totalData, MakeDataSet($row['longitude'],$row['latitude'],$total));
 

}

  

$finalJSON=array('image'=>$imageData,'javascript'=>$jsData,'css'=>$cssData,'html'=>$htmlData,'video'=>$VideoData,'app'=>$AppData,'txt'=>$txtData,'total'=>$totalData);

//var_dump($finalJSON);
$finalJSON=json_encode($finalJSON);

usort($dateArray,'date_compare');
$fileCount=count($rows);
if(count($dateArray)!=0 && $fileCount!=0)
{
$lastDate= strval( $dateArray[count($dateArray)-1]);
$output="-Ημερομηνία τελευταίου upload: $lastDate <br> <br> -Πλήθος αρχείων: $fileCount";
}
else
{
  $output="Δεν έχετε άνεβασει ακόμα κάποιο αρχείο";
}












//var_dump($finalJSON);

}


function date_compare($element1, $element2) { 
    $datetime1 = strtotime($element1); 
    $datetime2 = strtotime($element2); 
    return $datetime1 - $datetime2; 
}  


class Data
{
  public $lat;
  public $lng;
  public $count;


  function SetLong($value)
  {
    $this->lng=$value;
  }

  function SetLat($value)
  {
    $this->lat=$value;
  }

  function SetCount($value)
  {
    $this->count=$value;
  }
}




function BreakStrings($string2Break)
{
  $tempString=explode("/", $string2Break);
  return $tempString[0];//στην περιπτωση του χρηστη θελουμε μονο την πρωτη θεση του πινακα γιατι αυτην δειχνει το ποσα αντικειμενα υπαρχουν σε ενα αρχειο.
}


function MakeDataSet($long,$lat,$count)
{
 $tempObj= new Data();
 $tempObj->SetLong($long);
 $tempObj->SetLat($lat);
 $tempObj->SetCount($count);
 return $tempObj;
 
 


}











?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>


    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

   <script
src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"> </script>


<script
src="heatmaps.js">
</script>





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

  #mapid
  {
    box-shadow: 8px 8px 8px gray;
    border-radius: 15px;
     border: 5px solid #b3b3ff;
    position: absolute;
    width:50%;
    height:500px;
    left:18%;
    top:20%;

  }

  #contentSelect
  {
   position: absolute;
   left:66%;
   top:23%;
   width:50%;
  }

  #labels
  {
    position: relative;
    right:9%;

  }

  #info
  {
    padding: 40px 30px;
    background-color:#e6e6ff;
    border-radius: 15px;
    border: 3px solid #ccccff;
    box-shadow: 5px 5px 5px gray;
    position: absolute;
    left:80%;
    top:25%;
    width: 15%;

  }

  #userInfo
  {
    
    font-size: 15px;
    padding: 10px 10px;
    position: absolute;
    box-shadow: 5px 5px 5px gray;
    background-color:#e6e6ff;
    border: 3px solid #ccccff;
    width:300px;
    height:65px;
    top:50%;
    border-radius: 15px;



    
  }


  #optionsModalBG
  {
    visibility: hidden;
    opacity:0%;
    position: absolute;
    background-color: #7575a3;
    left: 0%;
    top:0%;
    width:100%;
    height:100%;
    transition: visibility 1s , opacity 1s;
  }

  #optionsModalMain
  {
    border-radius: 15px;
    box-shadow: 5px 5px 5px gray;
    text-align: center;
    font-size: 50px;
    position:absolute;
    background-color:#cccccc;
    width:20%;
    height:40%;
    top:25%;
    left:40%;

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

 



</style>




<ul>
<li><a href="page1.php">Αρχική Σελίδα</a></li>
<li><a id="optionsBtn" href="OptionsPage.php" >Ρυθμίσεις</a></li>

</ul>



<div id="contentSelect">
 <input type="radio" class="ct" id="ct" name="ct" value="image">
  <label for="image" id="labels">Images</label><br><br>
  <input type="radio" class="ct" id="ct" name="ct" value="javascript">
  <label for="javascript" id="labels">Javascript</label><br><br>
  <input type="radio" class="ct" id="ct" name="ct" value="CSS">
  <label for="css" id="labels">CSS</label><br><br>
  <input type="radio" class="ct" id="ct" name="ct" value="html">
  <label for="html" id="labels">HTML</label><br><br>
  <input type="radio" class="ct" id="ct" name="ct" value="video">
  <label for="video" id="labels">Video</label><br><br>
  <input type="radio" class="ct" id="ct" name="ct" value="application">
  <label for="application" id="labels">Application</label><br><br>
  <input type="radio" class="ct" id="ct" name="ct" value="plainTxt">
  <label for="plainText" id="labels">Plain Text</label><br><br>
   <input type="radio" class="ct" id="ct" name="ct" value="total" checked="checked">
  <label for="total" id="labels">Total</label>

</div>



<div id="info">Στον διπλανό χάρτη βλέπετε τις τοποθέσιες τις οποίες έχετε στείλει αιτήσεις HTTP.<br>
Ο διαμοιρασμός της θερμότητας σε κάποιες περιοχές γίνεται με βάση το πλήθος των αιτήσεων που έχετε κάνει προς αυτές.<br>
Επιλέγοντας κάποιο απο τα δίπλα κουμπιά (Image, Javascript, etc..) βλέπετε φιλτραρισμένα το πλήθος των αιτήσεων που έχετε κάνει με βάση το είδος του ιστοαντικειμένου.
</div>

<div id="userInfo"> </div>




<div id="mapid" ></div>







<?php 
echo  "<div id='userInfo'>$output</div>"; 
?>



<div id="optionsModalBG">
  
<div id="optionsModalMain">
  
Ρυθμίσεις


  <input type="password" class="inputF" id="oldPass" name="" placeholder="Τρέχον κωδικός πρόσβασης"><br>
  <input type="password" class="inputF" id="oldPass" name="" placeholder="Νέος κωδικός πρόσβασης"><br>
 <input type="password" class="inputF" id="oldPass" name="" placeholder="Επιβεβαίωση κωδικού "><br>
<button type="submit" id="changePassButton">Επιβεβαίωση</button><br>
  <button id="backButton">Κλείσιμο</button>
<button id="logOut">Αποσύνδεση</button>

</form>

</div>

</div>





<script type="text/javascript">


  var dataJson = <?php echo $finalJSON; ?>;
  

</script>
<script type="text/javascript" src="MapScript.js"></script>


  </body>

</html>
