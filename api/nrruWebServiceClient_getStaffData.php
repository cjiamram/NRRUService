<?php
	require_once("../lib/nusoap.php");
	header ("Content-Type: text/html; charset=utf-8");

	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_getStaffData.php?wsdl",true);
	$params = array(
		//'type' => "2" // 1=นักศึกษา 2=อาจารย์ (ถ้าเลือก 2 ไม่ต้องระบุ year,term)
		//'year' => "2557",
		//'term' => "1",
		'facultyid' => "5" // รหัสคณะ 1-5
	);
	$data = $client->call("getStaffData",$params); 
	$user = json_decode($data,true);
	
	//echo 'user : ' . $user . '<br><br>';
	$i = 1;
	echo '<table border="1">';
		echo '<tr>';
			echo '<th>ลำดับ</th>';
			echo '<th>ไอดี</th>';
			echo '<th>รหัส</th>';
			echo '<th>คำนำหน้าชื่อ</th>';
			echo '<th>ชื่อไทย</th>';
			echo '<th>นามสกุลไทย</th>';
			echo '<th>ชื่ออังกฤษ</th>';
			echo '<th>นามสกุลอังกฤษ</th>';
			echo '<th>เพศ</th>';
		echo '</tr>';
		foreach ($user as $result) {
			echo '<tr>';
				echo '<td>' . $i . '</td>';
				echo '<td>' . $result["staffid"] . '</td>';
				echo '<td>' . $result["staffcode"] . '</td>';
				echo '<td>' . $result["prefixname"] . '</td>';
				echo '<td>' . $result["staffname"] . '</td>';
				echo '<td>' . $result["staffsurname"] . '</td>';
				echo '<td>' . $result["staffnameeng"] . '</td>';
				echo '<td>' . $result["staffsurnameeng"] . '</td>';
				echo '<td>' . $result["staffsex"] . '</td>';
			echo '</tr>';
			$i++;
		}
	echo '</table>';
?>