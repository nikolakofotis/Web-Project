








var mymap = L.map('mapid').setView([51.505, -0.09], 3);
var weightsArray= new Map;

var greenIcon = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

for (var i =mapData.length - 1; i >= 0; i--) {
   
    
    var marker = new L.Marker([mapData[i]['userLongitude'],mapData[i]['userLatitude']])
    marker.addTo(mymap);
    for (var j = mapData[i]['longitude'].length - 1; j >= 0; j--) {
        var marker2 = new L.Marker([mapData[i]['longitude'][j],mapData[i]['latitude'][j]],{icon:greenIcon});
        marker2.addTo(mymap);
        CalculateWeight(mapData[i]['longitude'][j],mapData[i]['latitude'][j]);
    }

}

for (var i =mapData.length - 1; i >= 0; i--) {
   
    
    
    for (var j = mapData[i]['longitude'].length - 1; j >= 0; j--) {

        var latLng = 
        [
            [mapData[i]['userLongitude'],mapData[i]['userLatitude']],
            [mapData[i]['longitude'][j],mapData[i]['latitude'][j]]

        ];
        var polyline = L.polyline(latLng, {weight: weightsArray.get(MergeStrings(mapData[i]['longitude'][j],mapData[i]['latitude'][j]))}).addTo(mymap);
        
    }

}



//var marker = new L.Marker([17.385044, 78.486671]);





L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiZm90aXNuaWsiLCJhIjoiY2tqdHZwdHAyMDB1NzJ4bXM5d2N2Z215eSJ9.NfroQUqI80kXrH6oyXU72A'
}).addTo(mymap);






function CalculateWeight(long,lat)
{
    let x = String(long);
    let y = String(lat);
    let s = MergeStrings(x,y);
    let value = weightsArray.get(s);
    if(value==null)
    {
        weightsArray.set(s,1);
    }
    else
    {
        weightsArray.set(s,value+1);
    }
}



function StringSplit(a)
{
    let x = a.split('/');
    return x;
}

function MergeStrings(a,b)
{
    let s = a.concat('/');
    s=s.concat(b);
    return s;

}










