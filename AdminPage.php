
<?php
session_start();
if($_SESSION['username']===null ||$_SESSION['username']!=="admin" )
{
  header("Location: main.php");
  exit;
}
else
{

$db=mysqli_connect('localhost','root','','haranalyzer');
$sessionUname = $_SESSION['username'];


$dbQuery="SELECT * from files";

$userQuery="SELECT * from user";
$userResult=mysqli_query($db,$userQuery);
$users=mysqli_fetch_all($userResult,MYSQLI_ASSOC);
$totalUsers=count($users);





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


$totalGet=0;
$totalPost=0;

$domainsArray=array();
$hostArray=array();

$average;

$hours=array();

$mapData=array();
$mapKeys=array();

foreach($rows as $row)
{
  DictionaryAdd($mapKeys,$mapData,$row['userIp'],$row['userLat'],$row['userLong'],$row['latitude'],$row['longitude']);
  $totalGet +=BreakStrings($row['methodGet'],0);
  $totalPost +=BreakStrings($row['methodPost'],0);
  FindUnique($hostArray,$row['userHost']);
  FindUnique($domainsArray,$row['domain']);
  array_push($dateArray,$row['dateProcessed']);
  $ctImage= BreakStrings($row['ctImage'],0);
  $ctJavascript= BreakStrings($row['ctJavascript'],0);
  $ctCss= BreakStrings($row['ctCss'],0);
  $ctHtml= BreakStrings($row['ctHtml'],0);
  $ctVideo= BreakStrings($row['ctVideo'],0);
  $ctApplication= BreakStrings($row['ctApplication'],0);
  $ctPlainText= BreakStrings($row['ctPlainTxt'],0);
  $total=$ctImage+$ctJavascript+$ctCss+$ctHtml+$ctVideo+$ctApplication+$ctPlainText;
  array_push($imageData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctImage'],0)));
  array_push($jsData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctJavascript'],0)));
  array_push($cssData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctCss'],0)));
  array_push($htmlData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctHtml'],0)));
  array_push($VideoData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctVideo'],0)));
  array_push($AppData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctApplication'],0)));
  array_push($txtData, MakeDataSet($row['longitude'],$row['latitude'],BreakStrings($row['ctPlainTxt'],0)));
  array_push($totalData, MakeDataSet($row['longitude'],$row['latitude'],$total));


  MakeTime($hours,$row);
//var_dump(date('l',strtotime($row['dateProcessed'])));
 

}

//var_dump($hours[15]);


$mapData=json_encode($mapData);
$finalJSON=array('image'=>$imageData,'javascript'=>$jsData,'css'=>$cssData,'html'=>$htmlData,'video'=>$VideoData,'app'=>$AppData,'txt'=>$txtData,'total'=>$totalData);

//var_dump($finalJSON);
$finalJSON=json_encode($finalJSON);

$hours=json_encode($hours);

usort($dateArray,'date_compare');
$fileCount=count($rows);

$domainsCount=count($domainsArray);
$hostCount=count($hostArray);


$output=" -Πλήθος χρηστών: $totalUsers <br> -Πλήθος αιτήσεων τύπου GET: $totalGet <br> -Πλήθος αιτήσεων τύπου POST: $totalPost
<br>-Πλήθος μοναδικών domain μεσα στην βάση: $domainsCount <br>-Πλήθος μοναδικών παρόχων στην βάση: $hostCount" ;
//var_dump($mapData);

//$output="Δεν έχετε άνεβασει ακόμα κάποιο αρχείο";

















//var_dump($finalJSON);

}

class Hour
{
  public $day=array('Monday'=>array(),'Tuesday'=>array(),'Wednesday'=>array(),'Thursday'=>array(),'Friday'=>array(),'Saturday'=>array(),'Sunday'=>array());

  
  public $httpMethod=array('get'=>array(),'post'=>array());


  public $contentType=array('image'=>array(),'js'=>array(),'html'=>array(),'css'=>array(),'video'=>array(),'app'=>array(),'text'=>array());

  public $totalT=0;
  public $totalC=0;

}


function MakeTime(&$tempHour,$data)
{
  
  $totalCount=BreakStrings($data['ctImage'],0)+BreakStrings($data['ctJavascript'],0)+BreakStrings($data['ctCss'],0)+BreakStrings($data['ctHtml'],0)+BreakStrings($data['ctVideo'],0)+BreakStrings($data['ctApplication'],0) + BreakStrings($data['ctPlainTxt'],0) ;

  $totalTime=BreakStrings($data['ctImage'],1)+BreakStrings($data['ctJavascript'],1)+BreakStrings($data['ctCss'],1)+BreakStrings($data['ctHtml'],1)+BreakStrings($data['ctVideo'],1)+BreakStrings($data['ctApplication'],1)+ BreakStrings($data['ctPlainTxt'],1);

  

  if(empty($tempHour[$data['timeCaptured']]))
  {

   
    $tempHour[$data['timeCaptured']]->contentType['image']['count']=BreakStrings($data['ctImage'],0);
    $tempHour[$data['timeCaptured']]->contentType['image']['time']=BreakStrings($data['ctImage'],1);
    $tempHour[$data['timeCaptured']]->contentType['js']['count']=BreakStrings($data['ctJavascript'],0);
    $tempHour[$data['timeCaptured']]->contentType['js']['time']=BreakStrings($data['ctJavascript'],1);
    $tempHour[$data['timeCaptured']]->contentType['html']['count']=BreakStrings($data['ctHtml'],0);
    $tempHour[$data['timeCaptured']]->contentType['html']['time']=BreakStrings($data['ctHtml'],1);
    $tempHour[$data['timeCaptured']]->contentType['css']['count']=BreakStrings($data['ctCss'],0);
    $tempHour[$data['timeCaptured']]->contentType['css']['time']=BreakStrings($data['ctCss'],1);
    $tempHour[$data['timeCaptured']]->contentType['video']['count']=BreakStrings($data['ctVideo'],0);
    $tempHour[$data['timeCaptured']]->contentType['video']['time']=BreakStrings($data['ctVideo'],1);
    $tempHour[$data['timeCaptured']]->contentType['app']['count']=BreakStrings($data['ctApplication'],0);
    $tempHour[$data['timeCaptured']]->contentType['app']['time']=BreakStrings($data['ctApplication'],1);
    $tempHour[$data['timeCaptured']]->contentType['text']['count']=BreakStrings($data['ctPlainTxt'],0);
    $tempHour[$data['timeCaptured']]->contentType['text']['time']=BreakStrings($data['ctPlainTxt'],1);
    $tempHour[$data['timeCaptured']]->httpMethod['get']['time']=BreakStrings($data['methodGet'],1);
    $tempHour[$data['timeCaptured']]->httpMethod['get']['count']=BreakStrings($data['methodGet'],0);
    $tempHour[$data['timeCaptured']]->httpMethod['post']['count']=BreakStrings($data['methodPost'],0);
    $tempHour[$data['timeCaptured']]->httpMethod['post']['time']=BreakStrings($data['methodPost'],1);
    $tempHour[$data['timeCaptured']]->day[date('l',strtotime($data['dateProcessed']))]['count']=$totalCount;
    $tempHour[$data['timeCaptured']]->day[date('l',strtotime($data['dateProcessed']))]['time']=$totalTime;
    $tempHour[$data['timeCaptured']]->totalT=$totalTime;
    $tempHour[$data['timeCaptured']]->totalC=$totalCount;
    //var_dump($tempHour[23]->contentType['image']['count']);

  }
  else
  {
    $tempHour[$data['timeCaptured']]->totalT+=$totalTime;
    $tempHour[$data['timeCaptured']]->totalC+=$totalCount;
    $tempHour[$data['timeCaptured']]->contentType['image']['count']+=BreakStrings($data['ctImage'],0);
    $tempHour[$data['timeCaptured']]->contentType['image']['time']+=BreakStrings($data['ctImage'],1);
    $tempHour[$data['timeCaptured']]->contentType['js']['count']+=BreakStrings($data['ctJavascript'],0);
    $tempHour[$data['timeCaptured']]->contentType['js']['time']+=BreakStrings($data['ctJavascript'],1);
    $tempHour[$data['timeCaptured']]->contentType['html']['count']+=BreakStrings($data['ctHtml'],0);
    $tempHour[$data['timeCaptured']]->contentType['html']['time']+=BreakStrings($data['ctHtml'],1);
    $tempHour[$data['timeCaptured']]->contentType['css']['count']+=BreakStrings($data['ctCss'],0);
    $tempHour[$data['timeCaptured']]->contentType['css']['time']+=BreakStrings($data['ctCss'],1);
    $tempHour[$data['timeCaptured']]->contentType['video']['count']+=BreakStrings($data['ctVideo'],0);
    $tempHour[$data['timeCaptured']]->contentType['video']['time']+=BreakStrings($data['ctVideo'],1);
    $tempHour[$data['timeCaptured']]->contentType['app']['count']+=BreakStrings($data['ctApplication'],0);
    $tempHour[$data['timeCaptured']]->contentType['app']['time']+=BreakStrings($data['ctApplication'],1);
    $tempHour[$data['timeCaptured']]->contentType['text']['count']+=BreakStrings($data['ctPlainTxt'],0);
    $tempHour[$data['timeCaptured']]->contentType['text']['time']+=BreakStrings($data['ctPlainTxt'],1);
    $tempHour[$data['timeCaptured']]->httpMethod['get']['time']+=BreakStrings($data['methodGet'],1);
    $tempHour[$data['timeCaptured']]->httpMethod['get']['count']+=BreakStrings($data['methodGet'],0);
    $tempHour[$data['timeCaptured']]->httpMethod['post']['count']+=BreakStrings($data['methodPost'],0);
    $tempHour[$data['timeCaptured']]->httpMethod['post']['time']+=BreakStrings($data['methodPost'],1);
    if(empty($data['timeCaptured']->day[date('l',strtotime($data['dateProcessed']))]))
    {
    $tempHour[$data['timeCaptured']]->day[date('l',strtotime($data['dateProcessed']))]['count']=$totalCount;
    $tempHour[$data['timeCaptured']]->day[date('l',strtotime($data['dateProcessed']))]['time']=$totalTime;
    }
    else
    {
       $tempHour[$data['timeCaptured']]->day[date('l',strtotime($data['dateProcessed']))]['count']+=$totalCount;
      $tempHour[$data['timeCaptured']]->day[date('l',strtotime($data['dateProcessed']))]['time']+=$totalTime;

    }
    
  }
  
}




function DictionaryAdd(&$mapKeys,&$array,$key,$userLong,$userLat,$long,$lat)
{

  $key = preg_replace('/\s+/', '', $key);

  if(!in_array($key,$mapKeys))
  {
    array_push($mapKeys,$key);
    $array[array_search($key, $mapKeys)] = array();
    $array[array_search($key, $mapKeys)]['userLongitude']=$userLong;
    $array[array_search($key, $mapKeys)]['userLatitude']=$userLat;
    $array[array_search($key, $mapKeys)]['longitude'] = array();
    $array[array_search($key, $mapKeys)]['latitude'] = array();
    array_push($array[array_search($key, $mapKeys)]['longitude'], $long);
    array_push($array[array_search($key, $mapKeys)]['latitude'], $lat);
    
  }
  else
  {
    array_push($array[array_search($key, $mapKeys)]['longitude'], $long);
    array_push($array[array_search($key, $mapKeys)]['latitude'], $lat);
  }

  /*if(empty($array))
  {
    array_push($array, $key);
    $array[$key] = array();
    $array[$key]['userLongitude']=$userLong;
    $array[$key]['userLatitude']=$userLat;
    $array[$key]['longitude'] = array();
    $array[$key]['latitude'] = array();
    array_push($array[$key]['longitude'], $long);
    array_push($array[$key]['latitude'], $lat);
  }
  else
  {
    if(!in_array($key,$array))
    {
      array_push($array, $key);
    $array[$key] = array();
    $array[$key]['userLongitude']=$userLong;
    $array[$key]['userLatitude']=$userLat;
    $array[$key]['longitude'] = array();
    $array[$key]['latitude'] = array();
    array_push($array[$key]['longitude'], $long);
    array_push($array[$key]['latitude'], $lat);

    }
    else
    {
      array_push($array[$key]['longitude'], $long);
    array_push($array[$key]['latitude'], $lat);

    }*/
   

  

}

function FindUnique(&$arrayToPush,$value)
{
  if(empty($arrayToPush))
  {
    array_push($arrayToPush, $value);
  }
  else
  {
    if(!in_array($value, $arrayToPush))
    {
      array_push($arrayToPush, $value);
    }

  }
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




function BreakStrings($string2Break,$position)
{
  $tempString=explode("/", $string2Break);
  return $tempString[$position];//στην περιπτωση του χρηστη θελουμε μονο την πρωτη θεση του πινακα γιατι αυτην δειχνει το ποσα αντικειμενα υπαρχουν σε ενα αρχειο.
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



 
  #mapid
  {
    box-shadow: 8px 8px 8px gray;
    border-radius: 15px;
     border: 5px solid #b3b3ff;
    position: absolute;
    width:20%;
    height:200px;
    left:65%;
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

  

  #userInfo
  {
    
    font-size: 15px;
    padding: 10px 10px;
    position: absolute;
    box-shadow: 5px 5px 5px gray;
    background-color:#e6e6ff;
    border: 3px solid #ccccff;
    width:350px;
    height:80px;
    top:55%;
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

#chart
{
  background-color: #e6e6ff;
  opacity: 85%;
  position: absolute;
  width: 35%;
  height:70%;
  left: 25%;
   border-radius: 10px;
    box-shadow: 5px 5px 5px gray;
    
}

#mapid
  {
    box-shadow: 8px 8px 8px gray;
    border-radius: 15px;
     border: 5px solid #b3b3ff;
    position: absolute;
    width:35%;
    height:500px;
    left:62%;
    top:20%;

  }

#contentChart
{
  position: absolute;
  display: inline-block;
  left: 1.5%;
  background-color: #e6e6ff;
  color:black;
  border: 2px solid #ccccff;
  padding: 9px;

}

.contentChild
{
  display: none;
  left:12%;
  position: fixed;
  background-color: #e6e6ff;
  color:black;
  border: 2px solid #ccccff;
  padding: 9px;
  z-index: 1;


}



.methodChild
{

  display: none;
  position: absolute;
  left:8.4%;
  top:5.5%;
  background-color: #e6e6ff;
  color:black;
  border: 2px solid #ccccff;
  padding: 9px;
  z-index: 1;
  
}

.dayChild
{
  position: absolute;
  left:5.6%;
  top:10%;
  display: none;
  background-color: #e6e6ff;
  color:black;
  border: 2px solid #ccccff;
  padding: 9px;
}



#methodChart
{
  position: absolute;
  display: inline-block;
  left: 1.5%;
  top:5.4%;
  background-color: #e6e6ff;
  color:black;
  border: 2px solid #ccccff;
  padding: 9px;

}

#dayChart
{
  top: 10%;
  position: absolute;
  display: inline-block;
  left: 1.5%;
  background-color: #e6e6ff;
  color:black;
  border: 2px solid #ccccff;
  padding: 9px;
}

#contentChart:hover ~.contentChild,.contentChild:hover
{
  display: block;
}

#methodChart:hover ~.methodChild,.methodChild:hover
{
  display: block;
}

#dayChart:hover ~.dayChild,.dayChild:hover
{
  display: block;
}


a{
  color:black;
  text-decoration: none;
  transition: background-color 1s;
  

}

a:hover
{
  background-color: #ccccff;
}



 



</style>










<div id="chart">
<canvas id="myChart" width="100%" height="100%"></canvas>
</div>


<div id="chartSelections">
   <li id="contentChart"><a href="">Είδος Ιστοαντικειμένου </a></li>
        <div  class="contentChild">
         <button onclick="Selector('contentType','image')">Image</button><br><br>
          <button onclick="Selector('contentType','js')">Javascript</button><br><br>
          <button onclick="Selector('contentType','html')">HTML</button><br><br>
          <button onclick="Selector('contentType','css')">CSS</button><br><br>
          <button onclick="Selector('contentType','video')">Video</button><br><br>
          <button onclick="Selector('contentType','app')">Application</button><br><br>
          <button onclick="Selector('contentType','text')">Plain Text</button><br><br>
          </div>

    
    <li id="methodChart"><a href="">Μέθοδος Http</a></li> 
    <div class="methodChild">
      <button onclick="Selector('httpMethod','post')">POST</button><br><br>
      <button onclick="Selector('contentType','get')">GET</button><br><br>
      </div>
    
     <li id="dayChart"><a href="">Ημέρες</a></li>
     <div class="dayChild">
      <button onclick="Selector('day','Monday')">Δευτέρα</button><br><br>
      <button onclick="Selector('day','Tuesday')">Τρίτη</button><br><br>
      <button onclick="Selector('day','Wednesday')">Τετάρτη</button><br><br>
      <button onclick="Selector('day','Thursday')">Πέμπτη</button><br><br>
      <button onclick="Selector('day','Friday')">Παρασκευή</button><br><br>
      <button onclick="Selector('day','Saturday')">Σάββατο</button><br><br>
      <button onclick="Selector('day','Sunday')">Κυριακή</button><br><br>
    </div>

</div>

<div id="userInfo">
 </div>

 <div id="mapid" ></div>












<?php 
echo  "<div id='userInfo'>$output</div>"; 
?>









<script type="text/javascript">


  var dataJson = <?php echo $finalJSON; ?>;

  var hourJson=<?php echo $hours; ?> ;
  var mapData=<?php echo $mapData; ?> ;
  

</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script type="text/javascript" src="chartScript.js"></script>
<script type="text/javascript" src="AdminMap.js"></script>


  </body>

</html>
