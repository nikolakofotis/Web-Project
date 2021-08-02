<?php

	session_start();
	$sessionUname = $_SESSION['username'];
	$db=mysqli_connect('localhost','root','','haranalyzer');
	$json = file_get_contents('php://input');
  	$json_decode = json_decode($json,true); 
  	
  	
  	
  	


  	
  	//ip toy user 
  	$externalContent = file_get_contents('http://checkip.dyndns.com/');
	preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
	$externalIp = $m[1];
	var_dump($externalIp);
	
  	class ContentType
  	{
  		public $public;
  		public $private;
  		public $noStore;
  		public $noCache;
  		public $timings;

  		function IncreasePublic()
  		{
  			$this->public=$this->public+1;
  		}

  		function IncreasePrivate()
  		{
  			$this->private=$this->private+1;
  		}

  		function IncreaseNoStore()
  		{
  			$this->noStore=$this->noStore+1;
  		}

  		function IncreaseNoCache()
  		{
  			$this->noCache=$this->noCache+1;
  		}


  		function GetPublic()
  		{
  			return $this->public;
  		}

  		function GetPrivate()
  		{
  			return $this->private;
  		}

  		function GetNoStore()
  		{
  			return $this->noStore;
  		}

  		function GetNoCache()
  		{
  			return $this->noCache;
  		}
  	}


  	
  	

  	

  	

  	// object ContentType με βαση την κλαση που εφτιαξα απο πανω για τα τελευταια ερωτηματα.

  	$contentImage= new ContentType();
  	$contentJavascript= new ContentType();
  	$contentCss= new ContentType();
  	$contentHtml= new ContentType();
  	$contentVideo= new ContentType();
  	$contentApp= new ContentType();
  	$contentPlainTxt= new ContentType();
  	$contentUnknown= new ContentType();



  	//το ct πριν απο την λεξη που ακολουθει σημαινει 'content-type'
  	$ctImage;
  	$ctJavascript;
  	$ctCss;
  	$ctHtml;
  	$ctVideo;
  	$ctApplication;
  	$ctPlainTxt;
  	$unknownType;
  	$ctTotal;

  	//temp timings gia na ta valo mazi me ta content type mesa se ena string me ena delimiter gia pio efkoli apothikefsi mesa sthn vash.
  	$imageTime;
  	$jsTime;
  	$cssTime;
  	$htmlTime;
  	$videoTime;
  	$appTime;
  	$txtTime;
  	$unknownTime;
  	

  	//ora kai mera
  	$timeOccured;
  	$dayOfTheWeek;

  	//http methods kai oi xronoi toys
  	$getTime=0;
  	$postTime;
  	$getObj=0;
  	$postObj=0;
  	$totalTime=0;

  	//ip toy server poy phrame to file
  	$serverIp;

  	//domain toy server 
  	$domain;


	//var_dump(explode("/",$json_decode[0]["content"]));
	foreach ($json_decode as $row) {
		
		findContentType($row['content'],$row['time'],$row['cacheControl']);
		GetHttpMethod($row['method'],$row['time']);
		
		
		
	}

	

	$ctTotal=$ctImage+$ctJavascript+$ctCss+$ctHtml+$ctVideo+$ctApplication+$ctPlainTxt+$unknownType;
	FindDate($json_decode[0]['date']);

	$serverIp=ExtractIPAddress($json_decode[0]['serverIP']);
	$domain=FindDomain($json_decode[0]['url']);
	$ipDetails=FindIpDetails($serverIp);
	//reminder: prota lat meta long allios vgazei oti nanai :)
	$city=$ipDetails['city'];
	$latitude=$ipDetails['latitude'];
	$longitude=$ipDetails['longitude'];
	var_dump(gethostbyaddr($externalIp));
	var_dump($contentJavascript->GetPublic());
	var_dump(TransformForDatabaseQ3($ctImage,$imageTime,$contentImage));
	var_dump($totalTime);

	$dbImage=TransformForDatabaseQ3($ctImage,$imageTime,$contentImage);
	$dbJS=TransformForDatabaseQ3($ctJavascript,$jsTime,$contentJavascript);
	$dbCss=TransformForDatabaseQ3($ctCss,$cssTime,$contentCss);
	$dbHtml=TransformForDatabaseQ3($ctHtml,$htmlTime,$contentHtml);
	$dbVideo=TransformForDatabaseQ3($ctVideo,$videoTime,$contentVideo);
	$dbApp=TransformForDatabaseQ3($ctApplication,$appTime,$contentApp);
	$dbTxt=TransformForDatabaseQ3($ctPlainTxt,$txtTime,$contentPlainTxt);
	$dbGet=TransformForDatabase($getObj,$getTime);
	$dbPost=TransformForDatabase($postObj,$postTime);
	$host=gethostbyaddr($externalIp);
	$ipUserD=FindIpDetails($externalIp);
	$userLat=$ipUserD['latitude'];
	$userLong=$ipUserD['longitude'];





	$uploadFileQuerry =" INSERT INTO files(username,dateProcessed,ctImage,ctJavascript,ctCss,ctHtml,ctVideo,ctApplication,ctPlainTxt,methodGet,methodPost,serverIp,domain,latitude,longitude,city,userIp,userHost,userLat,userLong,timeCaptured) 
		VALUES('$sessionUname',NOW(),'$dbImage','$dbJS','$dbCss','$dbHtml','$dbVideo','$dbApp','$dbTxt','$dbGet','$dbPost','$serverIp','$domain','$latitude','$longitude','$city','
	$externalIp','$host','$userLat','$userLong',$timeOccured) ";

  	$result= mysqli_query($db,$uploadFileQuerry);

  	

function findContentType($ctString,$timings,$cacheControl)
{

	global $ctImage,
  	$ctJavascript,
  	$ctCss,
  	$ctHtml,
  	$ctVideo,
  	$ctApplication,
  	$unknownType,
  	$ctPlainTxt,
	//
  	$imageTime,
  	$jsTime,
  	$cssTime,
  	$htmlTime,
  	$videoTime,
  	$appTime,
  	$txtTime,
  	$unknownTime,
  	//
  	$contentImage,
  	$contentJavascript,
  	$contentCss,
  	$contentHtml,
  	$contentVideo,
  	$contentApp,
  	$contentPlainTxt,
  	$contentUnknown;



	$newS=explode("/", $ctString);
if($ctString!="x-unknown")
{
	if($newS[0]==="image")
	{
		$imageTime+=$timings;
		$ctImage++;
		CacheabilityDirs($cacheControl,$contentImage);
	}
	else if($newS[1]==="javascript")
	{
		$jsTime+=$timings;
		$ctJavascript++;
		CacheabilityDirs($cacheControl,$contentJavascript);
	}
	else if($newS[1]==="css")
	{
		$cssTime+=$timings;
		$ctCss++;
		CacheabilityDirs($cacheControl,$contentCss);
	}
	else if($newS[1]==="html")
	{
		$htmlTime+=$timings;
		$ctHtml++;
		CacheabilityDirs($cacheControl,$contentHtml);
	}
	else if($newS[0]==="video")
	{
		$videoTime+=$timings;
		$ctVideo++;
		CacheabilityDirs($cacheControl,$contentVideo);
	}
	else if($newS[0]==="application")
	{
		$appTime+=$timings;
		$ctApplication++;
		CacheabilityDirs($cacheControl,$contentApp);
	}
	else if($newS[1]==="plain")
	{
		$txtTime+=$timings;
		$ctPlainTxt++;
		CacheabilityDirs($cacheControl,$contentPlainTxt);
	}
	else 
	{
		$unknownTime+=$timings;
		$unknownType++;
		CacheabilityDirs($cacheControl,$contentUnknown);
	}
}

}


function FindDate($dateString)
{
	global $timeOccured,$dayOfTheWeek;

	$newT=explode("T",$dateString);
	$temp=explode(":",$newT[1]);
	$timeOccured=$temp[0];
	$dayOfTheWeek=date('l',strtotime($newT[0]));

}

function GetHttpMethod($methodString,$time)
{
	global $getTime,$postTime,$getObj,$postObj,$totalTime;

	if($methodString==="GET")
	{
		$getObj++;
		$getTime=$time+$getTime;
	}
	else if($methodString==="POST")
	{
		$postObj++;
		$postTime=$postTime+$time;

	}


	$totalTime=$totalTime+$time;

}

function TransformForDatabase($int2String,$timings)
{
	$tempString=strval($int2String);
	$tempTimings=round($timings);
	$tempTimings=strval($tempTimings);

	$finalString=implode("/", array($tempString,$tempTimings));
	return $finalString;
}


function TransformForDatabaseQ3($int2String,$timings,$contentTypeCache) 
{


	$tempPublic=$contentTypeCache->GetPublic();
	$tempPrivate=$contentTypeCache->GetPrivate();
	$tempNoStore=$contentTypeCache->GetNoStore();
	$tempNoCache=$contentTypeCache->GetNoCache();
	if(is_null($tempPublic))
	{
		$tempPublic="0";
	}
	if(is_null($tempPrivate))
	{
		$tempPrivate="0";
	}
	if(is_null($tempNoStore))
	{
		$tempNoStore="0";
	}
	if(is_null($tempNoCache))
	{
		$tempNoCache="0";
	}
	if(is_null($int2String))
	{
		$int2String=0;
	}
	if(is_null($timings))
	{
		$timings=0;
	}


	$tempString=strval($int2String);
	$tempTimings=round($timings);
	$tempTimings=strval($tempTimings);

	$finalString=implode("/", array($tempString,$tempTimings,$tempPublic,$tempPrivate,$tempNoStore,$tempNoCache));

	return $finalString;




}


function ExtractIPAddress($unmodifiedIPAdr)
{
	if($unmodifiedIPAdr[0]==="[")
	{
		$tempAddress=explode("[", $unmodifiedIPAdr);
		$finalAdress=explode("]", $tempAddress[1]);

		return $finalAdress[0];
	}
	else 
	{
		return $unmodifiedIPAdr;
	}
}


function FindDomain($domainString)
{
	$tempD=explode("/", $domainString);
	return $tempD[2];
}


function FindIpDetails($ip)
{
	$accessKey='c5c8e8fbbebd9ae253654f52f9c55a9e';
	$ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$accessKey.'');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$json = curl_exec($ch);
	curl_close($ch);
	$api_result = json_decode($json, true);
	return $api_result;
}


function CacheabilityDirs($cacheControlString,$contentTypeClassOBJ  )
{
	

	if(!is_null($cacheControlString))
	{
		$temp=explode(",", $cacheControlString);
	foreach ($temp as $tempString)
	 {

	 	$string=ltrim($tempString);
	 	

		if($string==="private")
		{
			$contentTypeClassOBJ->IncreasePrivate();
		}
		else if($string==="no-cache")
		{
			$contentTypeClassOBJ->IncreaseNoCache();
		}
		else if($string==="no-store")
		{
			$contentTypeClassOBJ->IncreaseNoStore();
		}
		else if($string==="public")
		{
			$contentTypeClassOBJ->IncreasePublic();
		}

		

	}
}
}



	


	





	


?>