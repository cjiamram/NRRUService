<?php
$mediaFolder=isset($_GET["folder"])?$_GET["folder"]:"uploads";
//print_r($mediaFolder);
/* Getting file name */
if(!isset($_FILES['file']['name'])){
   print_r("File Not Found");
   return ;
}

$filename = $_FILES['file']['name'];

if(isset($_GET["subdir"])){
	$mediaFolder = $mediaFolder."/".$_GET["subdir"];
	if(!file_exists($mediaFolder))
		mkdir($mediaFolder);
}


/* Location */
$location = $mediaFolder."/".$filename;

$uploadOk = 1;
$imageFileType = pathinfo($location,PATHINFO_EXTENSION);

/* Valid Extensions */
$valid_extensions = array("pdf","doc","docx","jpg","rtf","png","avi","mp4","mov","txt");
/* Check file extension */
if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
   $uploadOk = 0;
}



if($uploadOk == 0){
   echo 0;
}else{
   /* Upload file */
   if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
      if(isset($_GET["newFileName"])){
         if($_GET["newFileName"]!="")
            rename($location,$mediaFolder."/".$_GET["newFileName"]);
         
      }

   }else{
   }
}
?>