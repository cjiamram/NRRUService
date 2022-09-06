<?php
	$mediaFolder=isset($_GET["folder"])?$_GET["folder"]:"uploads";
	$pieces = explode("/", $mediaFolder);
	//print_r($mediaFolder);
	//$mediaFolder="../uploads/BBBB";

	if(!file_exists($mediaFolder))
			mkdir($mediaFolder);


?>