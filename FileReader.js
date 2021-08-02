var file = document.getElementById("inputBtn");
var downloadBtn=document.getElementById("downloadLocalBtn");
document.getElementById('inputBtn').addEventListener('change', read);
document.getElementById('serverUploadbtn').addEventListener('click',UploadToServer);

var reader=new FileReader();
var jsonFile;
function read()
{
	

	reader.onload= function()
	{
		var fileContent = JSON.parse(reader.result);
		var log=fileContent.log;
		console.log(log);
		var contentType=[];
		var domain="";
		var exportedObj=[];
		

				for (var i = log.entries.length - 1; i >= 0; i--) {
			 	contentType.push(log.entries[i].response.content.mimeType);

			 	exportedObj[i]=
			 	{
			 		date:log.entries[i].startedDateTime,
			 		method:log.entries[i].request.method,
			 		content:log.entries[i].response.content.mimeType,
			 		cacheControl: FindElement("cache-control",log.entries[i].response.headers),
			 		expires:FindElement("expires",log.entries[i].response.headers),
			 		pragma:FindElement("pragma",log.entries[i].response.headers),
			 		serverIP:log.entries[i].serverIPAddress,
			 		timings:log.entries[i].timings,
			 		url:log.entries[i].request.url,
			 		time:log.entries[i].time,
			 		status:log.entries[i].response.status
			 	};

			 }

			 	 jsonFile=JSON.stringify(exportedObj);
			 	
			 	console.log(exportedObj);
			 	console.log(file.files[0]);
			 	
			 	
				

		}
		

	reader.readAsText(file.files[0]);
}


function UploadToServer()
{
	request= new XMLHttpRequest();
	request.open("POST", "uploadFile.php", true);
 	request.setRequestHeader("Content-type", "application/json");
	request.send(jsonFile);
}





function FindElement(nameOfElement,arrayToSearch)
{
	for (var i = arrayToSearch.length - 1; i >= 0; i--) {
		
		if(arrayToSearch[i].name.toUpperCase()==nameOfElement.toUpperCase())
		{
			return arrayToSearch[i].value;
		}
		
	}


	return null;
}

function DownloadFile(file)
{
	

}



	













