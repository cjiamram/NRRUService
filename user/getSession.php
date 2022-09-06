<?php	
	session_start();
	$UserItem=array(
    		"Picture"=> "<img src=\"".$_SESSION["Picture"]."\" class=\"img-circle\" alt=\"User Image\">",
    		"FullName"=> "<p>".$_SESSION["FullName"]."</p>" 
    		);
	echo json_encode($UserItem);
	

?>