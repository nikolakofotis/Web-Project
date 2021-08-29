








var mymap = L.map('mapid').setView([51.505, -0.09], 3);


console.log(mapData[0]);
console.log(mapData[1]);
console.log(mapData[2]);
console.log(mapData[3]);
console.log(mapData[4]);
console.log(mapData[5]);


console.log(mapData);







var marker = new L.Marker([17.385044, 78.486671]);
marker.addTo(mymap);





L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiZm90aXNuaWsiLCJhIjoiY2tqdHZwdHAyMDB1NzJ4bXM5d2N2Z215eSJ9.NfroQUqI80kXrH6oyXU72A'
}).addTo(mymap);










