<?php
$client_id = 'C2oNo5EgZN6UbRsPeaJnsE';
$client_secret = 'DR1V7hri7aO6Qdv2dmgNCWZPKooZwh5weIecTIHuY7Y';

$api_url = 'https://notify-bot.line.me/oauth/token';
//$callback_url = 'http://localhost/yii2-maekha/web/index.php?r=site/callback';
$callback_url = 'http://localhost/NRRUServiceOnline/lineBot/callback.php';

 $query = [
            'response_type' => 'code',
            'client_id' => $client_id,
            'redirect_uri' => $callback_url,
            'scope' => 'notify',
            'state' => 'mylinenotify'
        ];
        
 $result = $api_url .http_build_query($query);
 //print_r($result);

?>