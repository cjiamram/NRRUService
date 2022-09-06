<style>
  #box{
    border-radius: 1em;
    width: 80%;
    height: 100%;
}
</style>
<?php
	session_start();

	header("content-type:html/text;charset=UTF-8");
	include_once "../objects/tissue.php";
	include_once "../config/database.php";
	include_once "../config/config.php";
	include_once "../objects/manage.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tissue($db);
	$cnf=new Config();
	$restURL=$cnf->restURL;

	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"chatchai.j";


	$sDate=$_GET["sDate"];
	$fDate=$_GET["fDate"];
	$stmt=$obj->getIssueReport($userCode,$sDate,$fDate);
	if($stmt->rowCount()>0){
		echo "<div id=\"box\">\n";
		echo "<table border='1' width=\"100%\"><tr><td>\n";
		echo "<table  class=\"table table-bordered\">\n";
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
		
			$issueDetail=str_replace("uploads/",$restURL."uploads/",$issueDetail);

			echo "<tr><td><u>ประเภท :</u>".$issueType."</td></tr>\n";
			echo "<tr><td><u>รายละเอียด :</u>".$issueDetail."</td></tr>\n";
			echo "<tr><td><u>แจ้งโดย :</u>".$notifyBy."</td></tr>\n";
			echo "<tr><td><u>วันที่ :</u>".Format::getTextDate($createDate)."</td></tr>\n";
			
			

			$stmt1=$obj->getIssueTracking($id);
			if($stmt1->rowCount()>0){
				echo "<tr><td><hr></td></tr>\n";
				echo "<tr></td>\n";
				echo "<table border=\"1\" width='100%'>\n";
				echo "<tr>\n";
					echo "<th>ดำเนินการ</th>\n"; 
					echo "<th width='100px'>วันที่</th>\n"; 
					echo "<th width='100px'>สถานะ</th>\n"; 
					echo "<th width='150px'>ความสำเร็จของงาน</th>\n"; 
				echo "</tr>\n";
				while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
					extract($row1);
					$detail=str_replace("uploads/",$restURL."uploads/",$detail);
					echo "<tr>\n";
						echo "<td>".$detail."</td>\n";
						echo "<td>".Format::getTextDate($operatingDate)."</td>\n";
						echo "<td>".$status."</td>\n";
						echo "<td>".$progress." %</td>\n";
					echo "</tr>\n";

				}
				echo "</table>\n";
				echo "</td></tr>\n";
			}

			

		}
		echo "</table>\n";
		echo "</table>\n";
		echo "</div>\n";
	}



?>