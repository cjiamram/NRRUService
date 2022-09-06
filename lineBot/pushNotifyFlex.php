<?php
    require 'sendLineFlex.php';

    session_start();
	include_once "../config/config.php";
	include_once "../lib/classAPI.php";
	include_once "../objects/tstaff.php";
	include_once "../config/database.php";


	$database=new Database();
	$db=$database->getConnection();
	$obj=new tstaff($db);

	$cnf=new Config();
	$api=new classAPI();
	$restURL=$cnf->restURL;
	$id=isset($_GET["id"])?$_GET["id"]:0;
	$assignTo=isset($_GET["assignTo"])?$_GET["assignTo"]:"";
	$staffName=$obj->getStaffName($assignTo);


	$path="tissue/readOneNotify.php?id=".$id;
	$url=$cnf->restURL.$path;

	$data=$api->getAPI($url);

	 $flexDataJson = '{
  "type": "bubble",
  "body": {
    "type": "box",
    "layout": "vertical",
    "contents": [
      {
        "type": "text",
        "text": "NRRU COMPUTER Service Center",
        "color": "#1DB446",
        "size": "md",
        "weight": "bold"
      },
      {
        "type": "text",
        "text": "ได้รับแจ้งจาก",
        "weight": "bold",
        "size": "xxl",
        "margin": "md"
      },
      {
        "type": "text",
        "text": "'.$data["notifyBy"].'",
        "size": "sm",
        "color": "#555555",
        "wrap": true,
        "margin": "sm"
      },
      {
        "type": "separator",
        "margin": "xxl"
      },
      {
        "type": "box",
        "layout": "vertical",
        "margin": "xxl",
        "spacing": "sm",
        "contents": [
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "โทรศัพท์:",
                "size": "md",
                "color": "#777777",
                "flex": 0
              },
              {
                "type": "text",
                "text": "'.$data["telNo"].'",
                "size": "md",
                "color": "#777777",
                "align": "end"
              }
            ]
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "วันที่แจ้ง:",
                "size": "md",
                "color": "#777777",
                "flex": 0
              },
              {
                "type": "text",
                "text": "'.$data["createDate"].'",
                "size": "md",
                "color": "#777777",
                "align": "end"
              }
            ]
          },

           {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "ประเภทงาน:",
                "size": "md",
                "color": "#777777",
                "flex": 0
              },
              {
                "type": "text",
                "text": "'.$data["issueType"].'",
                "size": "md",
                "color": "#777777",
                "align": "end"
              }
            ]
          },

           {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "มอบหมายให้:",
                "size": "md",
                "color": "#777777",
                "flex": 0
              },
              {
                "type": "text",
                "text": "'.$staffName.'",
                "size": "md",
                "color": "#777777",
                "align": "end"
              }
            ]
          },


        ]
      },
      {
        "type": "separator",
        "margin": "xxl"
      },

       {
            "type": "box",
            "layout": "horizontal",
            "contents": [
             
              {
                "type": "text",
                "text": "'.$data["issueDetail"].'",
                "size": "md",
                "color": "#777777",
                "align": "end"
              }
            ]
          }

      {
        "type": "separator",
        "margin": "xxl"
      },
      
    ]
  },
  "styles": {
    "footer": {
      "separator": true
    }
  }
}';





 $flexDataJsonDeCode = json_decode($flexDataJson,true);
 print_r( $flexDataJsonDeCode);
  //$datas['url'] = "https://api.line.me/v2/bot/message/push";
  $datas['url'] = "https://notify-api.line.me/api/notify";
  $datas['token'] = "JTAVgZSOGOkZFqvn7eUAHNQAzODFgBQTFKOZgc0w6Nl" ;
  //$messages['to'] = "<user id>";
  $messages['messages'][] = $flexDataJsonDeCode;
  $encodeJson = json_encode($messages);


  sentMessage($encodeJson,$datas);

  
?>