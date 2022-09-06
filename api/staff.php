<?php
	include_once "../lib/nusoap.php";

	class Staff{
		private $client;
		public function __construct(){
			$this->client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_staffData.php?wsdl",true);
		}


		public function getStaffName($staffId){
			$params = array(
				'staffid' => $staffId
			);
			$data = $this->client->call("getStaffData",$params); 
			$staff = json_decode($data,true);
			$staffName=$staff[0]["staffname"]." ".$staff[0]["staffsurname"]; 
			return $staffName;
		}
	}


