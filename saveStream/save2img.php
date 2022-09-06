<?php
// Create a blank image and add some text
//$im = imagecreatetruecolor(120, 20);
 header('Content-Type: application/json;charset=UTF-8');

 $data = json_decode(file_get_contents("php://input"));

 $destFolder=$data->destFolder;
 $fileName=$data->fileName;
 $fileName=$destFolder."/".$fileName;
 $imageData = str_replace(' ','+',$data->contents);
 $filteredData=substr($imageData, strpos($imageData, ",")+1);
 $unencodedData=base64_decode($filteredData);
 $file = fopen($fileName, 'wb');
 fwrite($file, $unencodedData);
 fclose($file);
 
 echo json_encode(array("message"=>true));
?>