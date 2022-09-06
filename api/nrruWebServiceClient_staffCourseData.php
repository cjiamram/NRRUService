<?php
	require_once("../../lib/nusoap.php");
	header ("Content-Type: text/html; charset=utf-8");

	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_staffCourseData.php?wsdl",true);
	$params = array(
		'staffid' => "54"
	);
	$data = $client->call("getStaffCourseData",$params); 
	//echo 'data : ' . $data . '<br>';
	
	$staff = json_decode($data,true);
	//echo 'user : ' . $user . '<br><br>';
	$i = 1;
	echo '<table border="1">';
		echo '<tr>';
			echo '<th width="50">ลำดับ</th>';
			echo '<th width="50">ไอดี</th>';
			echo '<th width="50">คำนำหน้าชื่อ</th>';
			echo '<th width="150">ชื่อ</th>';
			echo '<th width="150">นามสกุล</th>';
			echo '<th width="50">ปี</th>';
			echo '<th width="50">เทอม</th>';
			echo '<th width="100">รหัสวิชา</th>';
			echo '<th width="150">ชื่อวิชาTH</th>';
			echo '<th width="150">ชื่อวิชาENG</th>';
			echo '<th width="150">คำอธิบายรายวิชา1</th>';
			echo '<th width="150">คำอธิบายรายวิชา2</th>';
		echo '</tr>';
		foreach ($staff as $result) {
			echo '<tr>';
				echo '<td>' . $i . '</td>';
				echo '<td>' . $result["STAFFID"] . '</td>';
				echo '<td>' . $result["PREFIXNAME"] . '</td>';
				echo '<td>' . $result["OFFICERNAME"] . '</td>';
				echo '<td>' . $result["OFFICERSURNAME"] . '</td>';
				echo '<td>' . $result["ACADYEAR"] . '</td>';
				echo '<td>' . $result["SEMESTER"] . '</td>';
				echo '<td>' . $result["COURSECODE"] . '</td>';
				echo '<td>' . $result["COURSENAME"] . '</td>';
				echo '<td>' . $result["COURSENAMEENG"] . '</td>';
				echo '<td>' . $result["DESCRIPTION1"] . '</td>';
				echo '<td>' . $result["DESCRIPTION2"] . '</td>';
			echo '</tr>';
			$i++;
		}
	echo '</table>';
?>