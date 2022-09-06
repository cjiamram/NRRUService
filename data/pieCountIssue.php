<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;
  $yrmn=isset($_GET["yrmn"])?$_GET["yrmn"]:"";
?>

<script>
var datasets=[];
function displayPie() {
 var url="<?=$rootPath?>/data/getCountIssue.php?yrmn=<?=$yrmn?>";
 var data=queryData(url);
 if(data!==undefined){
         for(i=0;i<data.length;i++){
            datasets.push({"name":"ประเภท:"+ data[i].issueType, y: parseInt(data[i].No)});
         }

        var chart = new CanvasJS.Chart("pieCountIssue", {
          exportEnabled: true,
          animationEnabled: true,
          title:{
            text: "ประเภทการแจ้งซ่อม",
            fontFamily:"tahoma",
            fontSize:16,
            fontWeight: "bold"
          },
         axisY:{
          labelFontFamily: "tahoma"
          } ,
          legend:{
            cursor: "pointer",
            itemclick: explodePie
          },
          data: [{

            click: function(e){
                  //setPiePTypeByDepartment(e.dataPoint.departmentCode);
            },
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

$(document).ready(function(){

});
</script>

<div id="pieCountIssue" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
