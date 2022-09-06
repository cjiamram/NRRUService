<?php
        $client_id = 'ZtAdgYvewFgwh4BCda7HyOUZ';
        $client_secret = 'Cr6zqdWdWRPm6CgfU7bnas7IWp2gxouoUfbiROHwXQHZDk7';

        $api_url = 'https://notify-bot.line.me/oauth/token';
        $callback_url = 'http://localhost/NRRUServiceOnline/lineBot/callback.php';

        parse_str($_SERVER['QUERY_STRING'], $queries);

        //var_dump($queries);
        $fields = [
            'grant_type' => 'authorization_code',
            'code' => $queries['code'],
            'redirect_uri' => $callback_url,
            'client_id' => $client_id,
            'client_secret' => $client_secret
        ];
        
        try {
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
            $res = curl_exec($ch);
            curl_close($ch);
        
            if ($res == false)
                throw new Exception(curl_error($ch), curl_errno($ch));
        
            $json = json_decode($res);
            print_r($json->access_token);
        
            //var_dump($json);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
            //var_dump($e);
        }

?>