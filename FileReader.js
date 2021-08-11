var file = document.getElementById("inputBtn");
var downloadBtn=document.getElementById("downloadLocalBtn");
document.getElementById('inputBtn').addEventListener('change', read);//otan epileksoyme ena arxeio apo ton ypologisth tote ekteleitai h function read()
document.getElementById('serverUploadbtn').addEventListener('click',UploadToServer);//an ginei click sto koympi 'anevasma arxeioy ston server ' tote energopoieitai h methodos UploadToServer()

var reader=new FileReader();
var jsonFile;
function read()
{
	//afto to function diavazei to arxeio har

	reader.onload= function()
	{
		var fileContent = JSON.parse(reader.result);//diavazei to arxeio poy exoyme epileksei na anevasoyme prin pathsoyme tis epiloges gia topikh apothikefsi h anevasma ston server
		var log=fileContent.log;//diavazei to log toy arxeioy
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
			 	 //afoy diavasei oles tis aparaithtes plhrofories tote ftiaxnei ena neo arxeio json kratontas mesa oles aftes tis plhrofories poy epeksergastike
			 	
			 	console.log(exportedObj);
			 	console.log(file.files[0]);
			 	
			 	
				

		}
		

	reader.readAsText(file.files[0]);
}


function UploadToServer()
{
	//an epileksoyme na anevasoyme to arxeio ston server, ftiaxnoyme ena request gia na perasoyme ena arxeio json apo thn javascript(frontend) sthn php(backend)
	request= new XMLHttpRequest();
	request.open("POST", "uploadFile.php", true);
 	request.setRequestHeader("Content-type", "application/json");//vazoyme mesa sto header ths php to arxeio json kai sthn epomenh grammh to stelnoyme ston server
	request.send(jsonFile);

}





function FindElement(nameOfElement,arrayToSearch)//function gia na psaxnei sygkekrimenes plhrofories mesa sto har arxeio kai na tis filtrarei
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
	//mallon den eixa vrei pos na to kano download

}



	













