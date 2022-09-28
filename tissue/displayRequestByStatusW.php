<?php
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/tissue.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$obj=new tissue($db);
$objLbl = new ClassLabel($db);
$status=isset($_GET["status"])?$_GET["status"]:"01";
$data=array();
if(isset($_GET["isSearch"])){

	$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
	$issueType=isset($_GET["issueType"])?$_GET["issueType"]:"";
	$requestDate=isset($_GET["requestDate"])?$_GET["requestDate"]:"";

	$stmt = $obj->getRequestByAdvanceStatus($status,$keyWord,$issueType,$requestDate);
	$num = $stmt->rowCount();
	if($um>0){
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"location"=>$Location,
					"contact"=>"Tel:".$telNo." Line:".$lineNo,
					"issueType"=>$issueType,
					"issueDetail"=>$issueDetail,
					"notifyBy"=>$notifyBy,
					"status"=>$status,
					"createDate"=>Format::getTextDate($createDate)
				);
				array_push($data, $objItem);
			}
	}


}else{
	$stmt = $obj->getRequestByStatus($status);
	$num = $stmt->rowCount();
	if($num>0){
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"location"=>$Location,
					"contact"=>"Tel:".$telNo." Line:".$lineNo,
					"issueType"=>$issueType,
					"issueDetail"=>$issueDetail,
					"notifyBy"=>$notifyBy,
					"status"=>$status,
					"createDate"=>Format::getTextDate($createDate)
				);
				array_push($data, $objItem);
			}
	}
}




echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th width='20%'>".$objLbl->getLabel("t_issue","createDate","TH")."-".$objLbl->getLabel("t_issue","notifyBy","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","location","TH")."-".$objLbl->getLabel("t_issue","status","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","issueType","TH")."/".$objLbl->getLabel("t_issue","issueDetail","TH")."</th>";
			//echo "<th width='300px'>".$objLbl->getLabel("t_issue","issueDetail","TH")."</th>";
		echo "</tr>";
echo "</thead>";
if(count($data)>0){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			$strProcess='<div class=\'col-sm-12\'>'.$row["createDate"].'</div>';
			$strProcess.='<div class=\'col-sm-12\'>'.$row["notifyBy"].'</div>';

			$strProcess.='<div class=\'col-sm-12\'>
			<button type=\'button\' class=\'btn btn-info pull-left\'
				 onclick=\'receiveJob('.$row["id"].')\' >
				<span class=\'fa fa-handshake-o\'></span>&nbsp;มอบหมายงาน
			</button></div>';

			echo '<td width=\'20%\' >'.$strProcess.'</td>';
			$strContact='<div class=\'col-sm-12\'>';
			$strContact.='<div>'.$row["location"].'</div>';
			$strContact.='</div>';
			$strContact.='<div class=\'col-sm-12\'>';
			$strContact.='<div>'.$row["contact"].'</div>';
			$strContact.='</div>';
			$strContact.="<div class='col-sm-12'>\n";
			$strContact.="<div><label style='color:red'>สถานะ :".$row["status"]."</label></div>\n";
			$strContact.="</div>\n";

			echo '<td>'.$strContact.'</td>';
			$strT="<table width='100%'>\n";
			$strT.="<tr><td>".$row["issueType"]."</td></tr>\n";
			$strT.="<tr><td><div style='width:100%;min-height:100px;max-height:300px;overflow:scroll;'>".$row["issueDetail"]."</div></td></tr>\n";
			$strT.="</table>\n";
			echo "<td>".$strT."</td>\n";
			echo "</tr>";
}
echo "</tbody>";
}
?>

<script>
	$(document).ready(function(){
		tablePage("#tbJobRequest");
	})
</script>
