
console.log(hourJson);

var returnArray=[];
window.onload=function()
{
	Selector("contentType","image");
};
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['01', '02', '03', '04', '05', '06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'],
        datasets: [{
            label: ' Μέσος Χρόνος Απόκρισης ',
            data: returnArray,
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

//Selector("contentType","image");
function Selector(selection1,selection2)
{
	
	for(var i=0;i<24;i++)
	{
		if(typeof hourJson[i]!=="undefined" && typeof hourJson[i][selection1][selection2] !=="undefined")
		{
			

			if(hourJson[i][selection1][selection2]["count"]!=0)
			{
			returnArray[i]=hourJson[i][selection1][selection2]["time"]/hourJson[i][selection1][selection2]["count"];
			}
			else
			{
				returnArray[i]=0;
			}
			
		}
		else
		{
			returnArray[i]=0
		}

		
		
	}
	
	myChart.update();
	

}

