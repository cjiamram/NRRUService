<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;
  $date=date("Y-m-d");
  $sDate=isset($_GET["sDate"])?$_GET["sDate"]:date('Y-m-d', strtotime($date. ' - 30 days'));
  $fDate=isset($_GET["fDate"])?$_GET["fDate"]:date("Y-m-d");

?>

<script>
var datasets=[];
function displayBar() {
 var url="<?=$rootPath?>/data/getMonthCountIssue.php?sDate=<?=$sDate?>&fDate=<?=$fDate?>";
 console.log(url);
 var data=queryData(url);

 if(data!==undefined){

        for(i=0;i<data.length;i++){
            datasets.push({label: data[i].yrmn, y: parseInt(data[i].No)});
        }

        var chart = new CanvasJS.Chart("barCount", {
          exportEnabled: true,
          animationEnabled: true,
          theme: "light2", // "light1", "light2", "dark1", "dark2"
          title:{
            text: "การขอรับบริการรายเดือน",
            fontFamily:"tahoma",
            fontSize:15,
            fontWeight: "bold"
          },

           axisY: {
              title: "จำนวนการขอรับบริการ"
        },
         
          data: [{
                   click: function(e){
                    setPieCountStatus(e.dataPoint.label);
                    setPieCountIssue(e.dataPoint.label);
                },
                type: "column",  
                showInLegend: true, 
                legendMarkerColor: "grey",
                legendText: "จำนวนการขอรับบริการ",
                dataPoints:datasets
          }]
        });
        chart.render();
    }
}

$( document ).ready(function() {
    displayBar();
});

</script>

<div id="barCount" style="height: 600px;width:100%; margin: 0px auto;"></div>
