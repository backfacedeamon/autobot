<?php
require_once('./vendor/autoload.php');

//Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

//Token
$channel_token='lWtY8ZGPyvz4W0zzz5KH4eHcR5cerA0sqGCEmjwu976pAaNsikSl4H931y8b1mBxR3GImGGUDhYM6RJKXyZVyQAVn0aY0zxmWxntOYGmw9tQl99TifEWI6oqPmnkhJF+b1V/pExiEk9/fW+7z9yYTwdB04t89/1O/w1cDnyilFU=';
$channel_secret='35e654c7cd3a978fab43c926c660dd98';

//Get message from line API
$content=file_get_contents('php://input');
$events=json_decode($content, true);

if(!is_null($events['events'])){
    //Loop through each event
    foreach($events['events']as $event){

        //Line API send a lot of event type, we interested in massage only.
        if($event['type']=='message'&& $event['message']['type']=='text'){

            //Get replyToken
            $replyToken=$event['replyToken'];

            //split message then keep it in database.
            $appointments=explode(',', $event['message']['text']);

            if(count($appointments)==2){

                $host = 'ec2-54-235-92-43.compute-1.amazonaws.com';
                $dbname='ddqiktp7kdbt1';
                $user='emnxsaqcgcvhgv';
                $pass='a54775509dc91ed67584f2ec108f808c82fd0158e5c74d89f33ff4eb70dd6314';
                $connecttion=new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);

                $params=array(
                    'time' => $appointments[0],
                    'content'=> $appointments[1],
                );
                    $statement=$connecttion->prepare("INSERT INTO appointments (time, content)VALUES(:time, :content)");

                    $result=$statement->execute($params);

                    $respMessage='Your appointment has saved.';
            }else{
                    $respMessage='You can send appointment like this "12.00,House keeping."';

                    $query = sprintf("SELECT*FROM appointments WHERE content = 'hardware' ", $event['message']['text']);
                    $result = $connection->query($sql);
                    $respMessage = 'ข้อมูล ';
            break;
            }
                $httpClient=new CurlHTTPClient($channel_token);
                $bot=new LINEBot($httpClient, array('channelSecret'=> $channel_secret));

                $textMessageBuilder=new TextMessageBuilder($respMessage);
                $response=$bot->replyMessage($replyToken, $textMessageBuilder);
        }
    }
}
echo"OK";
    