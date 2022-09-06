<?php
	require_once("../lib/nusoap.php");
	header ("Content-Type: text/html; charset=utf-8");

	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_staffData.php?wsdl",true);
	$params = array(
		'staffid' => "54"
	);
	$data = $client->call("getStaffData",$params); 
	//echo 'data : ' . $data . '<br>';
	
	$staff = json_decode($data,true);
	foreach ($staff as $result) {
		echo 'status : ' . $result["status"] . '<br>';
		echo 'datetime : ' . $result["datetime"] . '<br>';
		echo 'staffcode : ' . $result["staffcode"] . '<br>';
		echo 'staffname : ' . $result["staffname"] . '<br>';
		echo 'staffsurname : ' .  $result["staffsurname"] . '<br>';
		echo 'prefixname : ' . $result["prefixname"] . '<br>';
		echo 'staffnameeng : ' . $result["staffnameeng"] . '<br>';
		echo 'staffsurnameeng : ' . $result["staffsurnameeng"] . '<br>';
		echo 'staffsexname : ' . $result["staffsexname"] . '<br>';
		echo 'stafftypename : ' . $result["stafftypename"] . '<br>';
		echo 'staffstatus : ' . $result["staffstatusname"] . '<br>';
		echo 'positionlevel : ' . $result["positionlevel"] . '<br>';
		echo 'admintdate : ' . $result["admitdate"] . '<br>';
		echo 'positionname : ' . $result["positionname"] . '<br>';
		echo 'departmentname : ' . $result["departmentname"] . '<br>';
		echo 'workdepartmentname : ' . $result["workdepartmentname"] . '<br>';
		echo 'citizenid : ' . $result["citizenid"] . '<br>';
		
		echo '<br>positionpresent : ' . $result["positionpresent"] . '<br>';
		foreach ($result["positionpresent"] as $res) {
			echo 'admitdate : ' . $res["admitdate"] . '<br>';
			echo 'positionname : ' . $res["positionname"] . '<br>';
			echo 'transferdate : ' . $res["transferdate"] . '<br>';
			echo 'acadpositionname : ' . $res["acadpositionname"] . '<br>';
			echo 'retireyear : ' . $res["retireyear"] . '<br>';
			echo 'positionlevel : ' . $res["positionlevel"] . '<br>';
			echo 'salarygroupname : ' . $res["salarygroupname"] . '<br>';
			echo 'sumyear : ' . $res["sumyear"] . '<br>';
			echo 'summonth : ' . $res["summonth"] . '<br>';
			echo 'salaryamount : ' . $res["salaryamount"] . '<br>';
		}

		echo '<br>general : ' . $result["general"] . '<br>';
		foreach ($result["general"] as $res) {
			echo 'citizenid : ' . $res["citizenid"] . '<br>';
			echo 'birthyear : ' . $res["birthyear"] . '<br>';
			echo 'provincename : ' . $res["provincename"] . '<br>';
			echo 'birthdate : ' . $res["birthdate"] . '<br>';
			echo 'countryname : ' . $res["countryname"] . '<br>';
			echo 'nationid : ' . $res["nationid"] . '<br>';
			echo 'religionid : ' . $res["religionid"] . '<br>';
			echo 'blood : ' . $res["blood"] . '<br>';
			echo 'maritalstatus : ' . $res["maritalstatus"] . '<br>';
			echo 'militaryservice : ' . $res["militaryservice"] . '<br>';
			echo 'taxcode : ' . $res["taxcode"] . '<br>';
			echo 'insurance : ' . $res["insurance"] . '<br>';
			echo 'welfaretype : ' . $res["welfaretype"] . '<br>';
		}

		echo '<br>personal : ' . $result["personal"] . '<br>';
		foreach ($result["personal"] as $res) {
			echo 'applicantid : ' . $res["applicantid"] . '<br>';
			echo 'contractno : ' . $res["contractno"] . '<br>';
			echo 'contractdatefrom : ' . $res["contractdatefrom"] . '<br>';
			echo 'contractdateto : ' . $res["contractdateto"] . '<br>';
			echo 'militarydepartment : ' . $res["militarydepartment"] . '<br>';
			echo 'militaryservicedatetime : ' . $res["militaryservicedatetime"] . '<br>';
			echo 'militaryoffservicedatetime : ' . $res["militaryoffservicedatetime"] . '<br>';
			echo 'ordaintemple : ' . $res["ordaintemple"] . '<br>';
			echo 'ordaindatetime : ' . $res["ordaindatetime"] . '<br>';
			echo 'ordainleavedatetime : ' . $res["ordainleavedatetime"] . '<br>';
			echo 'prof_affiliations : ' . $res["prof_affiliations"] . '<br>';
			echo 'acad_pub_service : ' . $res["acad_pub_service"] . '<br>';
			echo 'activities : ' . $res["activities"] . '<br>';
			echo 'sport : ' . $res["sport"] . '<br>';
			echo 'hobbies : ' . $res["hobbies"] . '<br>';
		}

		echo '<br>address : ' . $result["address"] . '<br>';
		foreach ($result["address"] as $res) {
			echo 'presentpobox : ' . $res["presentpobox"] . '<br>';
			echo 'presentpoboxextend : ' . $res["presentpoboxextend"] . '<br>';
			echo 'presentmoo : ' . $res["presentmoo"] . '<br>';
			echo 'presentstreet : ' . $res["presentstreet"] . '<br>';
			echo 'presentdistrictid : ' . $res["presentdistrictid"] . '<br>';
			echo 'presentcityid : ' . $res["presentcityid"] . '<br>';
			echo 'presentprovinceid : ' . $res["presentprovinceid"] . '<br>';
			echo 'presentzipcode : ' . $res["presentzipcode"] . '<br>';
			echo 'presentphoneno : ' . $res["presentphoneno"] . '<br>';
			echo 'censuspobox : ' . $res["censuspobox"] . '<br>';
			echo 'censuspoboxextend : ' . $res["censuspoboxextend"] . '<br>';
			echo 'censusmoo : ' . $res["censusmoo"] . '<br>';
			echo 'censusstreet : ' . $res["censusstreet"] . '<br>';
			echo 'censusdistrictid : ' . $res["censusdistrictid"] . '<br>';
			echo 'censuscityid : ' . $res["censuscityid"] . '<br>';
			echo 'censusprovinceid : ' . $res["censusprovinceid"] . '<br>';
			echo 'censuszipcode : ' . $res["censuszipcode"] . '<br>';
			echo 'censusphoneno : ' . $res["censusphoneno"] . '<br>';
		}
		
		echo '<br>position : ' . $result["position"] . '<br>';
		foreach ($result["position"] as $res) {
			echo 'positionname : ' . $res["positionname"] . '<br>';
			echo 'departmentname : ' . $res["departmentname"] . '<br>';
			echo 'expositiondate : ' . $res["expositiondate"] . '<br>';
		}

		echo '<br>other : ' . $result["other"] . '<br>';
		foreach ($result["other"] as $res) {
			echo 'degreelevel : ' . $res["degreelevel"] . '<br>';
			echo 'graduatedatetime : ' . $res["graduatedatetime"] . '<br>';
			echo 'degreename : ' . $res["degreename"] . '<br>';
			echo 'majorname : ' . $res["majorname"] . '<br>';
			echo 'universityname : ' . $res["universityname"] . '<br>';
			echo 'countryname : ' . $res["countryname"] . '<br>';
			echo 'eduiscedprogramid : ' . $res["eduiscedprogramid"] . '<br>';
			echo 'expertisefield : ' . $res["expertisefield"] . '<br>';
			echo 'teachiscedprogramid : ' . $res["teachiscedprogramid"] . '<br>';
		}
	}
?>