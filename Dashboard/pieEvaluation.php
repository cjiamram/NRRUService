<!DOCTYPE HTML>

<?php
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;
?>
<html>
<head>
<meta charset="UTF-8">
<script>
var datasets=[];
function displayPie() {

 var url="<?=$rootPath?>/tissue/getEvaluation.php";
 var data=queryData(url);
 //console.log(data);

 for(i=0;i<data.length;i++){
 	  datasets.push({"name":"ประเภทงาน :"+ data[i].IssueType, y: data[i].avgEva});
 }

var chart = new CanvasJS.Chart("dvPieEva", {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "สัดส่วนความพึงพอใจการให้บริการ",
		fontFamily: "tahoma",
		fontSize:20,
		fontWeight:"bold"
	},
	legend:{
		cursor: "pointer",
		itemclick: explodePie
	},
	data: [{
		type: "pie",
		showInLegend: false,
        indexLabel: "#percent%",
        percentFormatString: "#0.##",
        toolTipContent: "{name}: <strong>{y}(#percent%) .</strong>",
        dataPoints:datasets
	}]
});
chart.render();
}

$( document ).ready(function() {
    displayPie();
});

function explodePie (e) {
	if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
	} else {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
	}
	e.chart.render();

}
</script>
</head>
<body>
<div id="dvPieEva" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
</body>
</html>