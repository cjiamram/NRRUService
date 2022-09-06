<?php
include_once '../config/configParam.php';
include_once 'classCallRest.php';

// คำนวน สมรรถนะ จากหัวหน้างาน
//sum_ass_boss
function sumAssistBoss($assisid,$staffid,$roundid){
    $cnf=new Config();
	$api=new CallAPI();
	$url=$cnf->restURL."kpi_detail/getSumAssistBoss.php?staffid=".$staffid."&roundid=".$roundid."&staffass=".$assisid;
	$data=$api->CallAPIGet($url);
	return $data["assistKPI"];
}

//sum_ass
function sumAssist($assid,$staffid,$roundid){
    $cnf=new Config();
	$api=new CallAPI();
	/*
	$staffid=isset($_GET["staffid"]) ? $_GET["staffid"] : "0";
	$roundid=isset($_GET["roundid"]) ? $_GET["roundid"] : "0";
	$assid=isset($_GET["assid"]) ? $_GET["assid"] : "0";
	*/
	$url=$cnf->restURL."kpi_detail/getSumAssist.php?staffid=".$staffid."&roundid=".$roundid."&assid=".$assid;
	$data=$api->CallAPIGet($url);
	return $data["sumAssist"];
}


//count_chief_competency
//kpi_detail/getCountChiefCompetency.php?boss=0&staffid=14861&staffass=14861&roundid=2
function countChiefCompetency($assid,$empid,$roundid,$boss){
	$cnf=new Config();
	$api=new CallAPI();
	$url=$cnf->restURL."kpi_detail/getCountChiefCompetency.php?boss=".$boss."&staffid=".$empid."&staffass=".$assid."&roundid=".$roundid;
	$data=$api->CallAPIGet($url);
	return $data["competency"];
}


//count_chief_competency_boss
function countChiefCompetencyBoss($staffid,$staffass,$roundid,$boss){
	$cnf=new Config();
	$api=new CallAPI();
	/*
		$boss=isset($_GET["boss"]) ? $_GET["boss"] : "0";
		$staffid=isset($_GET["staffid"]) ? $_GET["staffid"] : "0";
		$roundid=isset($_GET["roundid"]) ? $_GET["roundid"] : "0";
		$staffass=isset($_GET["staffass"]) ? $_GET["staffass"] : "0";
	*/
	$url=$cnf->restURL."kpi_detail/getCountChiefCompetency.php?boss=".$boss."&staffid=".$staffid."&roundid=".$roundid."&staffass=".$staffass;
	$data=$api->CallAPIGet($url);
	return $data["competency"];
}

//function count_kpi_new($staff_id, $round_id)//OK Migrate-2
function countKpiNew($staffid, $roundid){
	$cnf=new Config();
	$api=new CallAPI();
	$url=$cnf->restURL."kpi_detail/getCountKPINew.php?staffid=".$staffid."&roundid=".$roundid;
	$data=$api->CallAPIGet($url);
	return $data["countKPINew"];
}

////count_competency
function countCompetency($staffid, $roundid){
	$cnf=new Config();
	$api=new CallAPI();
	/*
	$staffid=isset($_GET["staffid"]) ? $_GET["staffid"] : "0";
	$roundid=isset($_GET["roundid"]) ? $_GET["roundid"] : "0";
	*/
	$url=$cnf->restURL."kpi_detail/getCompetency.php?staffid=".$staffid."&roundid=".$roundid;
	$data=$api->CallAPIGet($url);
	return $data["competency"];

}






?>