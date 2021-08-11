





var elements = document.querySelectorAll('input[type=radio][name="ct"]');


elements.forEach(element=>element.addEventListener('change',()=> ChangeData(element.value)));

var userInfo= document.getElementById("userInfo");










var mymap = L.map('mapid').setView([51.505, -0.09], 3);



let maxCount=FindMax(dataJson.total);
let data=dataJson.total;

console.log(dataJson);

let testData = {max:maxCount, data};




let cfg = {"radius": 15,
"maxOpacity": 0.8,
"scaleRadius": false,
"useLocalExtrema": false,
latField: 'lat',
lngField: 'lng',
valueField: 'count'};

var heatmapLayer = new HeatmapOverlay(cfg);
mymap.addLayer(heatmapLayer);
heatmapLayer.setData(testData);



L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiZm90aXNuaWsiLCJhIjoiY2tqdHZwdHAyMDB1NzJ4bXM5d2N2Z215eSJ9.NfroQUqI80kXrH6oyXU72A'
}).addTo(mymap);


function FindMax(dataset)
{
	let tempArray=[];
	for(i=0;i<dataset.length;i++)
	{
		tempArray.push(dataset[i].count);
		
		
	}
	let max = Math.max.apply(Math, tempArray);
	console.log(max);
	return max;
}





function ChangeData(value)
{
	switch(value)
	{
		case "image":
		maxCount=FindMax(dataJson.image);
		data=dataJson.image;
		testData = {max:maxCount, data};
		heatmapLayer.setData(testData);
		break;


		case "javascript":
		maxCount=FindMax(dataJson.javascript);
		data=dataJson.javascript;
		testData = {max:maxCount, data};
		heatmapLayer.setData(testData);
		break;


		case "CSS":
		maxCount=FindMax(dataJson.css);
		data=dataJson.css;
		testData = {max:maxCount, data};
		heatmapLayer.setData(testData);
		break;


		case "html":
		maxCount=FindMax(dataJson.html);
		data=dataJson.html;
		testData = {max:maxCount, data};
		heatmapLayer.setData(testData);
		break;

		case "video":
		maxCount=FindMax(dataJson.video);
		data=dataJson.video;
		testData = {max:maxCount, data};
		heatmapLayer.setData(testData);
		break;

		case "application":
		maxCount=FindMax(dataJson.app);
		data=dataJson.app;
		testData = {max:maxCount, data};
		heatmapLayer.setData(testData);
		break;

		case "plainTxt":
		maxCount=FindMax(dataJson.txt);
		data=dataJson.txt;
		testData = {max:maxCount, data};
		heatmapLayer.setData(testData);
		break;

		case "total":
		maxCount=FindMax(dataJson.total);
		data=dataJson.total;
		testData = {max:maxCount, data};
		heatmapLayer.setData(testData);
		break;
	}
}

